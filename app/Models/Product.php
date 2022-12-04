<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    protected $guarded = [];


    /**
     * 檢查該產品是否有規格
     */
    public function checkSpec($sepc_name)
    {
        $spec_list = json_decode($this->spec);
        foreach($spec_list as $key => $spec_item){
            if($spec_item->name == $sepc_name){
                return true;
            }
        }

        return false;
    }



    public function getOriginalPrice()
    {
        $spec_list = json_decode($this->spec);
        $price = 0;
        foreach($spec_list as $key => $spec_item){
            if($key == 0){
                $price = $spec_item->original_price ?? 0;
            }else{
                if($price > $spec_item->original_price){
                    $price = $spec_item->original_price;
                }
            }

        }
        return $price;
    }

    public function getPrice()
    {
        $spec_list = json_decode($this->spec);
        $price = 0;
        foreach($spec_list as $key => $spec_item){
            if($key == 0){
                $price = $spec_item->price;
            }else{
                if($price >  $spec_item->price){
                    $price =  $spec_item->price;
                }
            }

        }
        return $price;
    }

    public function getPromotion()
    {
        $promotion_list = [];
        $list = Promotion::published()
        ->where('start_date','<=',now())
        ->where('end_date','>=',now())
        ->orderBy('position','ASC')
        ->get();

        $promotion_id_list = [];

        foreach($list as $item){

                switch($item->type){
                    case 1:
                        if(!in_array($item->id,$promotion_id_list)){
                                array_push($promotion_list,$item);
                                array_push($promotion_id_list,$item->id);
                        }
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $setting = json_decode($item->setting);
                        $include_product_list = $setting->product_list;
                        foreach($include_product_list as $include_product_item){
                            if($this->id == $include_product_item->product->id){
                                if(!in_array($item->id,$promotion_id_list)){
                                    array_push($promotion_list,$item);
                                    array_push($promotion_id_list,$item->id);
                                }
                            }
                        }
                        break;
            }
        }




        return $promotion_list;
    }

    /**
     * 回傳指定規格的盒子數量
     */
    public function getSpecBox($name)
    {
        $spec_list = json_decode($this->spec);
        foreach($spec_list as $key => $spec_item){
            if($spec_item->name == $name){
                return $spec_item->box ?? 99999999;
            }
        }

        return 999999;
    }

    /**
     * 回傳指定規格的價格
     */
    public function getSpecOrignalPrice($name)
    {
        $spec_list = json_decode($this->spec);
        foreach($spec_list as $key => $spec_item){
            if($spec_item->name == $name){
                return $spec_item->original_price;
            }
        }

        return 999999;
    }

    /**
     * 回傳指定規格的價格
     */
    public function getSpecPrice($name)
    {
        $spec_list = json_decode($this->spec);
        foreach($spec_list as $key => $spec_item){
            if($spec_item->name == $name){
                return $spec_item->price;
            }
        }

        return 999999;
    }

    public static function hasCombo()
    {
        $model = Promotion::published()
        ->where('type',">",1)
        ->where('type',"<",4)
        ->where('start_date','<=',now())
        ->where('end_date','>=',now())
        ->orderBy('position','ASC')
        ->first();
        if($model){
            return true;
        }
        return false;
    }
}

<?php

namespace TypiCMS\Modules\Deliveries\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $guarded = [];

    /**
     * 給予使用的區域
     */
    public static function getAreaList()
    {
        $list = [];
        $delivery_list = Delivery::published()->orderBy('position','ASC')->get();
        foreach($delivery_list as $item){
            $area = json_decode($item->area);

            foreach($area as $area_item){
                $delivery_area = $area_item->delivery_area;
                foreach($delivery_area as $delivery_area_item){
                    if(!in_array($delivery_area_item,$list)){
                        array_push($list, $delivery_area_item);
                    }
                }
            }
        }

        return $list;
    }

    /**
     * 檢查
     */
    public static function hasDelivery($list, $delivery_id)
    {
        foreach($list as $item){
            if($item->id == $delivery_id){
                return true;
            }
        }
        return false;
    }

    /**
     * 給予某地區的選項
     */
    public static function getDeliveryList($area)
    {
        $list = [];
        $delivery_list = self::published()->orderBy('position','ASC')->get();

        foreach($delivery_list as $delivery_item){
            $delivery_item_area = json_decode($delivery_item->area);
            foreach($delivery_item_area as $area_item){
                $delivery_area = $area_item->delivery_area;
                if(in_array($area,$delivery_area)){
                    array_push($list,$delivery_item);
                    break;
                }
            }
        }

        return $list;
    }

    /**
     * 給予運費
     */
    public function getCharge($area,$product_list)
    {
        $box_amount = 0;
        //計算盒數

        foreach($product_list as $product_item){
            $box_item_amount = 1;
            if($product_item['box']>1){
                $box_item_amount = $product_item['box'];
            }
            $amount =  $box_item_amount * $product_item['amount'];
            $box_amount += $amount;
        }


        $area_obj = null;
        //找出地區
        foreach(json_decode($this->area) as $area_item){
            if(in_array($area,$area_item->delivery_area)){
                $area_obj =  $area_item;
                break;
            }
        }

        if($area_obj){

            foreach($area_obj->rule as $rule){
                if($rule->min <= $box_amount && $rule->max >= $box_amount){
                    return $rule->shipping;
                }
            }

        }

        return 999999999;
    }
}

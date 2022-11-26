<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $guarded = [];


    public function getProductFirstImage()
    {
        if($this->product()){
            return $this->product()->getFirstImage();
        }else{
            return "";
        }
    }

    public function product(){
        $product = json_decode($this->product);
        $model = Product::published()->where('id',$product->id)->first();

        return $model;
    }

    public function specification(){
        return $this->belongsTo(Shopspecification::class,'specification_id');
    }
}

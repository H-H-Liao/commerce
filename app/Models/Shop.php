<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Shopproducts\Models\Shopproduct;

class Shop extends Model
{
    protected $guarded = [];

    public static function getCart(){
        $cart = Cart::init();
        $models=array();
        $allItems = $cart->getItems();

        foreach ($allItems as $items) {
            foreach ($items as $item) {
                    $product=Shopproduct::published()->where('id',$item['id'])->first();
                    if($product!=null){
                            $model=array();
                            $model['amount']=$item['quantity'];
                            $model['product']=$product;
                            $model['image']=$product->getFirstImageAttribute();
                            $model['url']=$product->url();
                            array_push($models,$model);
                    }else{
                        $cart->remove($item['id']);
                    }
            }
        }
        return $models;
    }
}

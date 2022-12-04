<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 購物車
 */
class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = 'cart_id';

    public static function getProduct($user_id)
    {
        $list = Cart::where('amount', '>' ,0)
                    ->where('user_id', $user_id)
                    ->join('products', 'products.product_id', '=','carts.product_id')
                    ->where('products.status', true)
                    ->get();


        return $list;
    }

    public static function addProduct($user_id, $product_id, $amount)
    {
        $product = Product::where('status', true)
                            ->where('product_id', $product_id)
                            ->firstOrFail();

        $user = User::where('user_id', $user_id)
                    ->firstOrFail();

        $cart = $user->getCart();
        $cart_product = new CartProduct();
        $cart_product->cart_id = $cart->cart_id;
        $cart_product->product_id = $product->product_id;
        $cart_product->amount = $amount;
        $cart_product->save();
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Http\Requests\Client\Cart\AddProductRequest;
use App\Http\Requests\Client\Cart\UpdateProductRequest;
use App\Http\Requests\Client\Cart\ChcekoutRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    public function index()
    {
        $user_id = auth('api')->id();
        $list = Cart::getProduct($user_id);

        return $list;
    }

    /**
     * 新增產品至購物車
     */
    public function addProduct($id, AddProductRequest $request)
    {
        $amount = $request->amount ?? 1;
        $user_id = auth('api')->id();
        try {
            Cart::addProduct($user_id, $id, $amount);
        } catch (ModelNotFoundException $ex) {
            return response('Not Found Product', 404);
        }

        return response('OK', 201);
    }

    /**
     * 更新購物車內的產品
     */
    public function updateProduct($id, UpdateProductRequest $request)
    {
        $amount = $request->amount ?? 1;

        $product = Product::where('status', true)
                            ->where('product_id', $id)
                            ->firstOrFail();

        return response('OK', 200);
    }

    /**
     * 從購物車移除產品
     */
    public function removeProduct($id)
    {
        $product = Product::where('status', true)
                            ->where('product_id', $id)
                            ->firstOrFail();

        return response('OK', 200);
    }


    public function checkout(ChcekoutRequest $request)
    {
        return response('OK', 200);
    }


}

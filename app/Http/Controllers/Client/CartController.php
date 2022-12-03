<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Client\Cart\AddProductRequest;
use App\Http\Requests\Client\Cart\UpdateProductRequest;
use App\Http\Requests\Client\Cart\ChcekoutRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * 新增產品至購物車
     */
    public function addProduct($id, AddProductRequest $request)
    {
        $amount = $request->amount ?? 1;

        $product = Product::where('status', true)
                            ->where('product_id', $id)
                            ->firstOrFail();

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

    public function address(Request $request)
    {
        return response('OK', 200);
    }

    public function delivery(Request $request)
    {
        return response('OK', 200);
    }

    public function paymnet(Request $request)
    {
        return response('OK', 200);
    }

    public function checkout(ChcekoutRequest $request)
    {
        return response('OK', 200);
    }


}

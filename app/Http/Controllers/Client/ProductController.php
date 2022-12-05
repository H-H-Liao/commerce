<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductIndex;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = ProductIndex::join('products', 'products.product_id', '=', 'product_indices.product_id')
                            ->where('products.status', true)
                            ->orderBy('position', 'DESC')
                            ->get();

        return response($list, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = ProductIndex::join('products', 'products.product_id', '=', 'product_indices.product_id')
                                ->where('products.product_id', $id)
                                ->where('products.status', true)
                                ->firstOrFail();

        return response($model, 200);
    }
}

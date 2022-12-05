<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Product;
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
                            ->orderBy('position', 'DESC')
                            ->get();

        return response($list, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        $product = Product::create($request->validated());
        $model = ProductIndex::create(['product_id' => $product->product_id]);

        return response($model, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = ProductIndex::where('products.product_id', $id)
                            ->join('products', 'products.product_id', '=', 'product_indices.product_id')
                            ->firstOrFail();

        return response($model, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {

        $product_index = ProductIndex::where('product_id', $id)
                                ->firstOrFail();

        $product = Product::where('product_id', $id)
                                ->firstOrFail();
        $data = $request->validated();
        $data['parent_id'] = $product->product_id;
        $model = $product->replicate()
                        ->fill($data)
                        ->save();
        $model = Product::where('parent_id', $product->product_id)
                        ->orderBy('created_at', 'DESC')
                        ->firstOrFail();
        $product->parent_id = $model->product_id;
        $product->save();

        $product_index->product_id = $model->product_id;
        $product_index->save();
        return response($model, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = ProductIndex::where('product_id', $id)
                        ->firstOrFail();
        $model->delete();

        return response('OK', 200);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Delivery\StoreRequest;
use App\Http\Requests\Admin\Delivery\UpdateRequest;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Delivery::orderBy('position', 'DESC')
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
        $model = Delivery::create($request->validated());

        return response('OK', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Delivery::where('delivery_id', $id)
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
        $model = Delivery::where('delivery_id', $id)
                        ->firstOrFail();
        $model->update($request->validated());

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
        $model = Delivery::where('delivery_id', $id)
                        ->firstOrFail();
        $model->delete();

        return response('OK', 200);
    }
}

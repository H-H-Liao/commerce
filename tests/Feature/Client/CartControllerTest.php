<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\Models\Product;

class CartControllerTest extends TestCase
{
    /**
     * 新增產品至購物車
     */
    public function test_addProductToCart()
    {
        $model = Product::where('status', true)
                        ->firstOrFail();
        $data = [
            'amount' => 10
        ];

        $response = $this->post('/api/client/cart/product/'.$model->product_id, $data);

        $response->assertStatus(201);
    }

    /**
     * 新增不存在的產品至購物車
     */
    public function test_addNotFoundProductToCart()
    {
        $model = Product::where('status', false)
                        ->firstOrFail();
        $data = [
            'amount' => 10
        ];

        $response = $this->post('/api/client/cart/product/'.$model->product_id, $data);


        $response->assertStatus(404);
    }

    /**
     * 更新購物車內的產品
     */
    public function test_updateProductFromCart()
    {
        $model = Product::where('status', true)
                        ->firstOrFail();
        $data = [
            'amount' => 10
        ];

        $response = $this->put('/api/client/cart/product/'.$model->product_id, $data);


        $response->assertStatus(200);
    }

    /**
     * 更新不存在購物車內的產品
     */
    public function test_updateNotFoundProductFromCart()
    {
        $model = Product::where('status', false)
                        ->firstOrFail();
        $data = [
            'amount' => 10
        ];

        $response = $this->put('/api/client/cart/product/'.$model->product_id, $data);


        $response->assertStatus(404);
    }


    /**
     * 從購物車移除產品
     */
    public function test_removeProductFromCart()
    {
        $model = Product::where('status', true)
                        ->firstOrFail();

        $response = $this->delete('/api/client/cart/product/'.$model->product_id);


        $response->assertStatus(200);
    }

    /**
     * 從購物車移除不存在的產品
     */
    public function test_removeNotFoundProductFromCart()
    {
        $model = Product::where('status', false)
                        ->firstOrFail();

        $response = $this->delete('/api/client/cart/product/'.$model->product_id);


        $response->assertStatus(404);
    }

    /**
     * 儲存地址
     */
    public function test_saveAddress()
    {
        $response = $this->post('/api/client/cart/address');

        $response->assertStatus(200);
    }

    /**
     * 儲存運送方式
     */
    public function test_saveDeliveryMethod()
    {
        $response = $this->post('/api/client/cart/delivery');

        $response->assertStatus(200);
    }

    /**
     * 儲存付款方式
     */
    public function test_savePaymentMethod()
    {
        $response = $this->post('/api/client/cart/payment');

        $response->assertStatus(200);
    }

    /**
     * 結帳
     */
    public function test_checkout()
    {
        $response = $this->post('/api/client/cart/checkout');

        $response->assertStatus(200);
    }
}

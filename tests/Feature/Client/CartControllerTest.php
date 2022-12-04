<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\Models\Product;
use Laravel\Passport\Passport;
use App\Models\User;

class CartControllerTest extends TestCase
{
    /**
     * 新增產品至購物車
     */
    public function test_addProductToCart()
    {
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
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
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
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
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
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
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
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
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
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
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
        $model = Product::where('status', false)
                        ->firstOrFail();

        $response = $this->delete('/api/client/cart/product/'.$model->product_id);


        $response->assertStatus(404);
    }


    /**
     * 結帳
     */
    public function test_checkout()
    {
        $user = User::firstOrFail();
        Passport::actingAs($user, []);

        $data = [
            'cart_id' => 1,
            'address_id' => 1,
            'delivery_id' => 1,
            'payment_id' => 1,
        ];
        $response = $this->post('/api/client/cart/checkout', $data);

        $response->assertStatus(200);
    }
}

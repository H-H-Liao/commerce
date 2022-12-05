<?php

namespace Tests\Feature\Client;

use App\Models\Address;
use App\Models\Delivery;
use App\Models\Payment;
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

        $address = Address::firstOrFail();
        $delivery = Delivery::firstOrFail();
        $payment = Payment::firstOrFail();

        $data = [
            'cart_id' => $user->getCart()->cart_id,
            'address_id' => $address->address_id,
            'delivery_id' =>  $delivery->delivery_id,
            'payment_id' => $payment->payment_id,
        ];
        $response = $this->post('/api/client/cart/checkout', $data);

        $response->assertStatus(200);
    }
}

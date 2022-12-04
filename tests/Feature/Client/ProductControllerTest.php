<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\Models\Product;
use Laravel\Passport\Passport;
use App\Models\User;

class ProductControllerTest extends TestCase
{
    public function test_show()
    {
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
        $model = Product::where('status', true)->firstOrFail();
        $response = $this->get('/api/client/product/'.$model->product_id);

        $response->assertStatus(200);
    }

    public function test_showStatusIsFalse()
    {
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
        $model = Product::where('status', false)->firstOrFail();
        $response = $this->get('/api/client/product/'.$model->product_id);

        $response->assertStatus(404);
    }

    public function test_index()
    {
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
        $response = $this->get('/api/client/product');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    public function test_show()
    {
        $model = Product::where('status', true)->firstOrFail();
        $response = $this->get('/api/client/product/'.$model->product_id);

        $response->assertStatus(200);
    }

    public function test_showStatusIsFalse()
    {
        $model = Product::where('status', false)->firstOrFail();
        $response = $this->get('/api/client/product/'.$model->product_id);

        $response->assertStatus(404);
    }

    public function test_index()
    {
        $response = $this->get('/api/client/product');

        $response->assertStatus(200);
    }
}

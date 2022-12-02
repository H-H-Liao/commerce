<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class AdminProductControllerTest extends TestCase
{
    public function test_create()
    {
        $model = [
            'name' => 'test'
        ];
        $response = $this->post('/api/admin/product', $model);
        $response->assertStatus(201);
    }

    public function test_edit()
    {
        $model = Product::firstOrFail();
        $data = [
            'name' => 'example'
        ];
        $response = $this->put('/api/admin/product/'.$model->product_id, $data);

        $response->assertStatus(200);
    }

    public function test_show()
    {
        $model = Product::firstOrFail();
        $response = $this->get('/api/admin/product/'.$model->product_id);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $model = Product::firstOrFail();
        $response = $this->delete('/api/admin/product/'.$model->product_id);

        $response->assertStatus(200);

    }



    public function test_index()
    {

        $response = $this->get('/api/admin/product');

        $response->assertStatus(200);
    }
}

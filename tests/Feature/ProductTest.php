<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // $response = $this->get('/product');
        $model = [
            'name' => 'test'
        ];
        $response = $this->post('/api/admin/product', $model);

        $response->assertStatus(204);
    }
}

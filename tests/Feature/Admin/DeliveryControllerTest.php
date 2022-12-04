<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Delivery;

class DeliveryControllerTest extends TestCase
{
    public function test_create()
    {
        Delivery::factory()->count(100)->create();
        $model = [
            'name' => 'test',
            'status' => true
        ];
        $response = $this->post('/api/admin/delivery', $model);
        $response->assertStatus(201);
    }

    public function test_edit()
    {
        $model = Delivery::firstOrFail();
        $data = [
            'name' => 'example'
        ];
        $response = $this->put('/api/admin/delivery/'.$model->delivery_id, $data);

        $response->assertStatus(200);
    }

    public function test_show()
    {
        $model = Delivery::firstOrFail();
        $response = $this->get('/api/admin/delivery/'.$model->delivery_id);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $model = Delivery::firstOrFail();
        $response = $this->delete('/api/admin/delivery/'.$model->delivery_id);

        $response->assertStatus(200);

    }

    public function test_index()
    {

        $response = $this->get('/api/admin/delivery');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Payment;

class PaymentControllerTest extends TestCase
{
    public function test_create()
    {
        Payment::factory()->count(100)->create();
        $model = [
            'name' => 'test',
            'status' => true
        ];
        $response = $this->post('/api/admin/payment', $model);
        $response->assertStatus(201);
    }

    public function test_edit()
    {
        $model = Payment::firstOrFail();
        $data = [
            'name' => 'example'
        ];
        $response = $this->put('/api/admin/payment/'.$model->payment_id, $data);

        $response->assertStatus(200);
    }

    public function test_show()
    {
        $model = Payment::firstOrFail();
        $response = $this->get('/api/admin/payment/'.$model->payment_id);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $model = Payment::firstOrFail();
        $response = $this->delete('/api/admin/payment/'.$model->payment_id);

        $response->assertStatus(200);

    }

    public function test_index()
    {

        $response = $this->get('/api/admin/payment');

        $response->assertStatus(200);
    }
}

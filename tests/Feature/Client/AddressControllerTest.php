<?php

namespace Tests\Feature\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;

class AddressControllerTest extends TestCase
{
    /**
     * 找出使用者的所有地址
     */
    public function test_index()
    {
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
        $response = $this->get('/api/client/address');

        $response->assertStatus(200);
    }
    /**
     * 新增地址
     */
    public function test_create()
    {
        $user = User::firstOrFail();
        Passport::actingAs($user, []);
        $response = $this->post('/api/client/address');

        $response->assertStatus(201);
    }
}

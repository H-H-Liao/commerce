<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Tests\TestCase;

class UserController extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        User::factory()->count(1)->create();
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

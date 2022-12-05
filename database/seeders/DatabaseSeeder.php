<?php

namespace Database\Seeders;

use App\Models\Delivery;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductIndex;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();
        Payment::factory(1)->create();
        Delivery::factory(1)->create();
        for ($index = 0 ; $index <= 10 ; $index++) {
            $this->call(ProductSeeder::class);
        }

    }
}

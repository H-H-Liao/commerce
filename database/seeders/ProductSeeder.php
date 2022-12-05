<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductIndex;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create(['name' => Str::random(10)]);
        $product_index = ProductIndex::create(['product_id' => $product->product_id]);

    }
}

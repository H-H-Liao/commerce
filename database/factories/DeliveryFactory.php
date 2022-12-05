<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => true,
            'title' => $this->faker->name(),
            'show_description' => true,
            'area' => '[]'
        ];
    }
}

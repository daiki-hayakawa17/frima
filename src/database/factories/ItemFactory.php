<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        return [
            'delivery_id' => null,
            'purchaser_id' => null,
            'seller_id' => 99,
            'condition' => 1,
            'name' => $this->faker->word(),
            'image' => 'default.png',
            'brand' => null,
            'price' => 1000,
            'description' => $this->faker->sentence(),
        ];
    }
}

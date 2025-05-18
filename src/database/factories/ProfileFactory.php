<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => 'default.png',
            'name' => 'testuser',
            'post' => '000-1234',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
        ];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deliveries')->insert([
            [
                'user_id' => 1,
                'post' => '123-4567',
                'address' => '東京都千代田区１－２－３',
            ],
            [
                'user_id' => 2,
                'post' => '111-2234',
                'address' => '東京都千代田区４－５－６',
            ],
            [
                'user_id' => 3,
                'post' => '100-1234',
                'address' => '東京都千代田区７－８－９',
            ]
        ]);
    }
}

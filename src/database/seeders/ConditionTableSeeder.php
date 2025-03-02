<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conditions')->insert([
            [
                'status' => '良好',
            ],
            [
                'status' => '目立った傷や汚れなし',
            ],
            [
                'status' => 'やや傷や汚れあり',
            ],
            [
                'status' => '状態が悪い',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'user_id' => '1',
                'condition' => '1',
                'name' => '腕時計',
                'image' => 'storage/images/Clock.jpg',
                'brand' => 'アルマーニ',
                'price' => '15000',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
            ],
            [
                'user_id' => '1',
                'condition' => '2',
                'name' => 'HDD',
                'image' => 'storage/images/Disk.jpg',
                'brand' => 'COACHTECH',
                'price' => '5000',
                'description' => '高速で信頼性の高いハードディスク',
            ],
            [
                'user_id' => '1',
                'condition' => '3',
                'name' => '玉ねぎ3束',
                'image' => 'storage/images/onion.jpg',
                'brand' => 'COACHTECH',
                'price' => '300',
                'description' => '新鮮な玉ねぎ3束のセット',
            ],
            [
                'user_id' => '1',
                'condition' => '4',
                'name' => '革靴',
                'image' => 'storage/images/LeatherShoes.jpg',
                'brand' => 'COACHTECH',
                'price' => '4000',
                'description' => 'クラシックなデザインの革靴',
            ],
            [
                'user_id' => '1',
                'condition' => '1',
                'name' => 'ノートPC',
                'image' => 'storage/images/pc.jpg',
                'brand' => 'COACHTECH',
                'price' => '45000',
                'description' => '高性能なノートパソコン',
            ],
            [
                'user_id' => '2',
                'condition' => '2',
                'name' => 'マイク',
                'image' => 'storage/images/MusicMic.jpg',
                'brand' => 'COACHTECH',
                'price' => '8000',
                'description' => '高音質のレコーディング用マイク',
            ],
            [
                'user_id' => '2',
                'condition' => '3',
                'name' => 'ショルダーバッグ',
                'image' => 'storage/images/pocket.jpg',
                'brand' => 'COACHTECH',
                'price' => '3500',
                'description' => 'おしゃれなショルダーバッグ',
            ],
            [
                'user_id' => '2',
                'condition' => '4',
                'name' => 'タンブラー',
                'image' => 'storage/images/Tumbler.jpg',
                'brand' => 'COACHTECH',
                'price' => '500',
                'description' => '使いやすいタンブラー',
            ],
            [
                'user_id' => '2',
                'condition' => '1',
                'name' => 'コーヒーミル',
                'image' => 'storage/images/CoffeeGrinder.jpg',
                'brand' => 'COACHTECH',
                'price' => '4000',
                'description' => '手動のコーヒーミル',
            ],
            [
                'user_id' => '2',
                'condition' => '2',
                'name' => 'メイクセット',
                'image' => 'storage/images/make.jpg',
                'brand' => 'COACHTECH',
                'price' => '2500',
                'description' => '便利なメイクアップセット',
            ],
        ]);
    }
}

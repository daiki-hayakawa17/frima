<?php

namespace Database\Seeders;

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
        $this->call([
            CategoryTableSeeder::class,
            ConditionTableSeeder::class,
            ItemCategorySeeder::class,
            ItemTableSeeder::class,
        ]);
    }
}

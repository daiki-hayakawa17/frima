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
            ItemCategorySeeder::class,
            UserTableSeeder::class,
            ItemTableSeeder::class,
            ProfileTableSeeder::class,
        ]);
    }
}

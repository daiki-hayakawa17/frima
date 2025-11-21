<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'testuser',
                'email' => 'test1@example.com',
                'password' => Hash::make('password1'),
                'email_verified_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'testuser2',
                'email' => 'test2@example.com',
                'password' => Hash::make('password2'),
                'email_verified_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'testuser3',
                'email' => 'test3@example.com',
                'password' => Hash::make('password3'),
                'email_verified_at' => now(),
            ]
            ]);
    }
}

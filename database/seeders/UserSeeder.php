<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()
        //     ->count(10)
        //     ->create();

        DB::table('users')->insert(
            [
                [
                    'name' => 'Admin Example',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('admin123'),
                    'remember_token' => Str::random(10),
                    'level' => 'ADMIN',
                ],
                [
                    'name' => 'User Example',
                    'email' => 'user@example.com',
                    'password' => Hash::make('user123'),
                    'remember_token' => Str::random(10),
                    'level' => 'USER',
                ],
            ]
        );
    }
}

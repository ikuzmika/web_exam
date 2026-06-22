<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Iveta Kuzmika',
            'email' => 'ikuzmika@gmail.com',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Marija Kļešņina',
            'email' => 'mashakle@inbox.lv',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);
    }
}

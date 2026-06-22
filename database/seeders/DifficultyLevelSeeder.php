<?php

namespace Database\Seeders;

use App\Models\DifficultyLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DifficultyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DifficultyLevel::create(['name' => 'A1']);
        DifficultyLevel::create(['name' => 'A2']);
        DifficultyLevel::create(['name' => 'A3']);
        DifficultyLevel::create(['name' => 'open']);
    }
}

<?php

namespace Database\Seeders;

use App\Models\SizeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SizeCategory::create(['name' => 'x-small']);
        SizeCategory::create(['name' => 'small']);
        SizeCategory::create(['name' => 'medium']);
        SizeCategory::create(['name' => 'intermedia']);
        SizeCategory::create(['name' => 'large']);
    }
}

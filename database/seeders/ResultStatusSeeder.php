<?php

namespace Database\Seeders;

use App\Models\ResultStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResultStatus::create([
            'name' => 'NS',
            'description' => 'not started',
        ]);

        ResultStatus::create([
            'name' => 'OK'
        ]);

        ResultStatus::create([
            'name' => 'DQ',
            'description' => 'disqualified',
        ]);
    }
}

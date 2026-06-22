<?php

namespace Database\Seeders;

use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Track::create([
            'difficulty_level_id' => 1,
            'competition_id' => 2
        ]);

        Track::create([
            'difficulty_level_id' => 1,
            'competition_id' => 5
        ]);

        Track::create([
            'difficulty_level_id' => 1,
            'competition_id' => 1
        ]);

        Track::create([
            'difficulty_level_id' => 2,
            'competition_id' => 2
        ]);

        Track::create([
            'difficulty_level_id' => 2,
            'competition_id' => 4
        ]);

        Track::create([
            'difficulty_level_id' => 2,
            'competition_id' => 1
        ]);

        Track::create([
            'difficulty_level_id' => 2,
            'competition_id' => 6
        ]);

        Track::create([
            'difficulty_level_id' => 3,
            'competition_id' => 2
        ]);

        Track::create([
            'difficulty_level_id' => 3,
            'competition_id' => 4
        ]);

        Track::create([
            'difficulty_level_id' => 3,
            'competition_id' => 5
        ]);

        Track::create([
            'difficulty_level_id' => 3,
            'competition_id' => 1
        ]);

        Track::create([
            'difficulty_level_id' => 3,
            'competition_id' => 6
        ]);

        Track::create([
            'difficulty_level_id' => 4,
            'competition_id' => 2
        ]);

        Track::create([
            'difficulty_level_id' => 4,
            'competition_id' => 3
        ]);

        Track::create([
            'difficulty_level_id' => 4,
            'competition_id' => 1
        ]);
    }
}

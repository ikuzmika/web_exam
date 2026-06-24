<?php

namespace Database\Seeders;

use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class   TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 1,
            'competition_id' => 2,
            'name' => '1'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 1,
            'competition_id' => 5,
            'name' => '1'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 1,
            'competition_id' => 1,
            'name' => '1'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 2,
            'competition_id' => 2,
            'name' => '2'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 2,
            'competition_id' => 4,
            'name' => '2'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 2,
            'competition_id' => 1,
            'name' => '2'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 2,
            'competition_id' => 6,
            'name' => '2'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 3,
            'competition_id' => 2,
            'name' => '3'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 3,
            'competition_id' => 4,
            'name' => '3'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 3,
            'competition_id' => 5,
            'name' => '3'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 3,
            'competition_id' => 1,
            'name' => '3'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 3,
            'competition_id' => 6,
            'name' => '3'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 4,
            'competition_id' => 2,
            'name' => '4'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 4,
            'competition_id' => 3,
            'name' => '4'
        ]);

        Track::create([
            'created_by_user_id' => 1,
            'difficulty_level_id' => 4,
            'competition_id' => 1,
            'name' => '4'
        ]);
    }
}

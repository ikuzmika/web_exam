<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Competition::create([
            'created_by_user_id' => 1,
            'title' => 'Rēzeknes novada vasara kauss-24',
            'date' => date("Y-m-d", mktime(12, 30, 0,6 , 15, 2024)),
            'organizer_id' => 3,
            'judge_id' => 15
        ]);

        Competition::create([
            'created_by_user_id' => 1,
            'title' => 'AFA Summer CUP 2024',
            'date' => date("Y-m-d", mktime(12, 30, 0,7 , 29, 2024)),
            'organizer_id' => 4,
            'judge_id' => 6
        ]);

        Competition::create([
            'created_by_user_id' => 1,
            'title' => 'Rēzeknes novada vasara kauss-25',
            'date' => date("Y-m-d", mktime(12, 30, 0,6 , 10, 2025)),
            'organizer_id' => 3,
            'judge_id' => 30
        ]);

        Competition::create([
            'created_by_user_id' => 1,
            'title' => 'AFA Summer CUP 2025',
            'date' => date("Y-m-d", mktime(12, 30, 0,6 , 30, 2025)),
            'organizer_id' => 4,
            'judge_id' => 18
        ]);

        Competition::create([
            'created_by_user_id' => 1,
            'title' => 'Adžiliti sacensības Zaķumuižā',
            'date' => date("Y-m-d", mktime(12, 30, 0,8 , 4, 2025)),
            'organizer_id' => 2,
            'judge_id' => 14
        ]);

        Competition::create([
            'created_by_user_id' => 1,
            'title' => 'Starptautiskās un nacionālās adžiliti sacensības',
            'date' => date("Y-m-d", mktime(12, 30, 0,5 , 31, 2025)),
            'organizer_id' => 1,
            'judge_id' => 17
        ]);

        Competition::create([
            'created_by_user_id' => 1,
            'title' => 'Nacionālās adžiliti sacensības',
            'date' => date("Y-m-d", mktime(12, 30, 0,9 , 17, 2025)),
            'organizer_id' => 1,
            'judge_id' => 13
        ]);
    }
}

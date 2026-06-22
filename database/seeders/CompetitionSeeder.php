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
            'title' => 'Rēzeknes novada vasara kauss-24',
            'date' => '2024-06-15 12:30:00',
            'organizer_id' => 3,
            'judge_id' => 15
        ]);

        Competition::create([
            'title' => 'AFA Summer CUP 2024',
            'date' => '2024-07-29 12:30:00',
            'organizer_id' => 4,
            'judge_id' => 6
        ]);

        Competition::create([
            'title' => 'Rēzeknes novada vasara kauss-25',
            'date' => '2025-06-10 12:30:00',
            'organizer_id' => 3,
            'judge_id' => 30
        ]);

        Competition::create([
            'title' => 'AFA Summer CUP 2025',
            'date' => '2025-06-30 12:30:00',
            'organizer_id' => 4,
            'judge_id' => 18
        ]);

        Competition::create([
            'title' => 'Adžiliti sacensības Zaķumuižā',
            'date' => '2025-08-04 12:30:00',
            'organizer_id' => 2,
            'judge_id' => 14
        ]);

        Competition::create([
            'title' => 'Starptautiskās un nacionālās adžiliti sacensības',
            'date' => '2025-05-31 12:30:00',
            'organizer_id' => 1,
            'judge_id' => 17
        ]);

        Competition::create([
            'title' => 'Nacionālās adžiliti sacensības',
            'date' => '2025-09-17 12:30:00',
            'organizer_id' => 1,
            'judge_id' => 13
        ]);
    }
}

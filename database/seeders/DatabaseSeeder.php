<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->call([
            UserSeeder::class,
            HandlerSeeder::class,
            SizeCategorySeeder::class,
            ResultStatusSeeder::class,
            DifficultyLevelSeeder::class,
            OrganizerSeeder::class,
            SponsorSeeder::class,
            DogSeeder::class,
            PairSeeder::class,
            CompetitionSeeder::class,
            TrackSeeder::class,
            OrganizerSponsorSeeder::class,
            ResultSeeder::class,
        ]);
        Schema::enableForeignKeyConstraints();
    }
}

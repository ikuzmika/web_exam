<?php

namespace Database\Seeders;

use App\Models\Organizer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organizer::create([
            'name' => 'Suņu sporta attīstības centrs',
            'venue' => 'Rīga'
        ]);

        Organizer::create([
            'name' => 'AgiLatLand',
            'venue' => 'Zaķumuiža'
        ]);

        Organizer::create([
            'name' => 'Rēzeknes kinoloģiskās attīstības centrs - RKAC',
            'venue' => 'Rēzekne'
        ]);

        Organizer::create([
            'name' => 'Suņu klubs "Mans draugs"',
            'venue' => 'Zibeņi'
        ]);
    }
}

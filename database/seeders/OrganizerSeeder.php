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
            'created_by_user_id' => 1,
            'name' => 'Suņu sporta attīstības centrs',
            'venue' => 'Rīga'
        ]);

        Organizer::create([
            'created_by_user_id' => 1,
            'name' => 'AgiLatLand',
            'venue' => 'Zaķumuiža',
            'contact_person' => 'Svetlana Krēsliņa',
            'contact_number' => '29891850'
        ]);

        Organizer::create([
            'created_by_user_id' => 1,
            'name' => 'Rēzeknes kinoloģiskās attīstības centrs - RKAC',
            'venue' => 'Rēzekne'
        ]);

        Organizer::create([
            'created_by_user_id' => 1,
            'name' => 'Suņu klubs "Mans draugs"',
            'venue' => 'Zibeņi'
        ]);
    }
}

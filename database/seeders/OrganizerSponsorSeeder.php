<?php

namespace Database\Seeders;

use App\Models\OrganizerSponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizerSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 1,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 4,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 1000
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 6,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 10,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 500
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 19,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 5,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 17,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 14,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 1000
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 8,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 2000
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 1,
            'sponsor_id' => 13,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 1,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 600
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 2,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 5000
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 4
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 11
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 16,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 18,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 19,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 2000
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 12,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 2,
            'sponsor_id' => 6
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 3,
            'sponsor_id' => 3,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 3,
            'sponsor_id' => 7,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 1500
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 3,
            'sponsor_id' => 9,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 1000
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 3,
            'sponsor_id' => 15
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 3,
            'sponsor_id' => 11,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 3,
            'sponsor_id' => 2,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 3,
            'sponsor_id' => 5
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 6,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 7,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 2000
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 19
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 4
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 10,
            'contribution_type' => 'Finansiālais atbalsts',
            'contribution_amount' => 500
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 15
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 3,
            'contribution_type' => 'Apbalvojumi'
        ]);

        OrganizerSponsor::create([
            'organizer_id' => 4,
            'sponsor_id' => 1,
            'contribution_type' => 'Apbalvojumi'
        ]);
    }
}

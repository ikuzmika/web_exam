<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sponsor::create([
            'name' => 'Joy for Friends',
            'created_by_user_id' => 1,
            'email' => 'info@tervetefood.lv'
        ]);

        Sponsor::create([
            'name' => 'Barfus',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'HiDogChews',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Nippers+Dailes',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'GIGI VET | PET SUPPLEMENTS',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Noseprint',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'ĶepaRawFood',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Bravedog',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'INTERVALS Shop',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Ledana - naturālā suņu barība',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Magnum Veterinārija SIA',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Quattro',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Universitātes Vetfonds',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'SIA Farmeko',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Stenders Cosmetics',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Eli Pet Products',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Alpro',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'VĒJŠ Cafe',
            'created_by_user_id' => 1,
        ]);

        Sponsor::create([
            'name' => 'Liepāja',
            'created_by_user_id' => 1,
        ]);
    }
}

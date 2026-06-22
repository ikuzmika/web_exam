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
        Sponsor::create(['name' => 'Joy for Friends']);

        Sponsor::create(['name' => 'Barfus']);

        Sponsor::create(['name' => 'HiDogChews']);

        Sponsor::create(['name' => 'Nippers+Dailes']);

        Sponsor::create(['name' => 'GIGI VET | PET SUPPLEMENTS']);

        Sponsor::create(['name' => 'Noseprint']);

        Sponsor::create(['name' => 'ĶepaRawFood']);

        Sponsor::create(['name' => 'Bravedog']);

        Sponsor::create(['name' => 'INTERVALS Shop']);

        Sponsor::create(['name' => 'Ledana - naturālā suņu barība']);

        Sponsor::create(['name' => 'Magnum Veterinārija SIA']);

        Sponsor::create(['name' => 'Quattro']);

        Sponsor::create(['name' => 'Universitātes Vetfonds']);

        Sponsor::create(['name' => 'SIA Farmeko']);

        Sponsor::create(['name' => 'Stenders Cosmetics']);

        Sponsor::create(['name' => 'Eli Pet Products']);

        Sponsor::create(['name' => 'Alpro']);

        Sponsor::create(['name' => 'VĒJŠ Cafe']);

        Sponsor::create(['name' => 'Liepāja']);
    }
}

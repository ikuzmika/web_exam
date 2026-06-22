<?php

namespace Database\Seeders;

use App\Models\Handler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HandlerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Handler::create([
            'name' => 'Aleksandr',
            'surname' => 'Borisov'
        ]);

        Handler::create([
            'name' => 'Aleksandra',
            'surname' => 'Švaikovska'
        ]);

        Handler::create([
            'name' => 'Anita',
            'surname' => 'Reine'
        ]);

        Handler::create([
            'name' => 'Anna',
            'surname' => 'Vaganova'
        ]);

        Handler::create([
            'name' => 'Arta',
            'surname' => 'Veisa'
        ]);

        Handler::create([
            'name' => 'Baiba',
            'surname' => 'Ozoliņa'
        ]);

        Handler::create([
            'name' => 'Brigita',
            'surname' => 'Ose'
        ]);

        Handler::create([
            'name' => 'Dāvis',
            'surname' => 'Stade'
        ]);

        Handler::create([
            'name' => 'Ilzīte',
            'surname' => 'Rivulet-Dudkeviča'
        ]);

        Handler::create([
            'name' => 'Inga',
            'surname' => 'Petrova'
        ]);

        Handler::create([
            'name' => 'Irina',
            'surname' => 'Sokolova'
        ]);

        Handler::create([
            'name' => 'Ivonna',
            'surname' => 'Veilande'
        ]);

        Handler::create([
            'name' => 'Jana',
            'surname' => 'Verbicka'
        ]);

        Handler::create([
            'name' => 'Jekaterina',
            'surname' => 'Akimova'
        ]);

        Handler::create([
            'name' => 'Jeļena',
            'surname' => 'Prošina'
        ]);

        Handler::create([
            'name' => 'Jeļena',
            'surname' => 'Tapiļina'
        ]);

        Handler::create([
            'name' => 'Jolanta',
            'surname' => 'Pelše'
        ]);

        Handler::create([
            'name' => 'Jūlija',
            'surname' => 'Kampuse'
        ]);

        Handler::create([
            'name' => 'Karina',
            'surname' => 'Zaržecka'
        ]);

        Handler::create([
            'name' => 'Ksenija',
            'surname' => 'Diča'
        ]);

        Handler::create([
            'name' => 'Lidia',
            'surname' => 'Belyaeva'
        ]);

        Handler::create([
            'name' => 'Madara',
            'surname' => 'Ozoliņa'
        ]);

        Handler::create([
            'name' => 'Marija',
            'surname' => 'Kļešņina'
        ]);

        Handler::create([
            'name' => 'Natalja',
            'surname' => 'Trestjana'
        ]);

        Handler::create([
            'name' => 'Natālija',
            'surname' => 'Rakitenko'
        ]);

        Handler::create([
            'name' => 'Reilika',
            'surname' => 'Jugolainena-Klesnina'
        ]);

        Handler::create([
            'name' => 'Rūta Elīza',
            'surname' => 'Fišmane'
        ]);

        Handler::create([
            'name' => 'Saiva',
            'surname' => 'Pekuse'
        ]);

        Handler::create([
            'name' => 'Svetlana',
            'surname' => 'Krēsliņa'
        ]);

        Handler::create([
            'name' => 'Tatjana',
            'surname' => 'Nikitina'
        ]);
    }
}

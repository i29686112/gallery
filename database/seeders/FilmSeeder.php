<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Film::factory()->create(['key_name' => 'c200', 'name' => 'C200']);
        Film::factory()->create(['key_name' => 'vista200', 'name' => 'Vista 200']);
        Film::factory()->create(['key_name' => 'colorplus200', 'name' => 'ColorPlus 200']);
        Film::factory()->create(['key_name' => 'xtra400', 'name' => 'Xtra 400']);
        Film::factory()->create(['key_name' => 'e100', 'name' => 'E100']);
        Film::factory()->create(['key_name' => 'gold200', 'name' => 'Gold 200']);
        Film::factory()->create(['key_name' => 'proimage100', 'name' => 'ProImage 100']);
        Film::factory()->create(['key_name' => 'lomography800', 'name' => 'Lomography 800']);
        Film::factory()->create(['key_name' => 'gp3', 'name' => 'Gp3']);
        Film::factory()->create(['key_name' => 'ilfordhp5400', 'name' => 'Ilford HP5 400']);
        Film::factory()->create(['key_name' => 'kodak250d', 'name' => 'Kodak 250d']);
        Film::factory()->create(['key_name' => 'portra400', 'name' => 'Portra 400']);
        Film::factory()->create(['key_name' => 'tmax3200', 'name' => 'Tmax 3200']);
        Film::factory()->create(['key_name' => 'ilfordxp2400', 'name' => 'Ilford XP2 400']);
        Film::factory()->create(['key_name' => '500t', 'name' => '500T']);
        Film::factory()->create(['key_name' => '50d', 'name' => '50D']);
        Film::factory()->create(['key_name' => 'ektar100', 'name' => 'Ektar 100']);
        Film::factory()->create(['key_name' => 'filmneverdie400', 'name' => 'Film Never Die 400']);

    }
}


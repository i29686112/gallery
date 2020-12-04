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
        Film::factory()->create([
            'key_name' => 'c200',
            'name' => 'C200',
            'description' => 'c200 description',
            'cover_image_name' => 'c200.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'vista200',
            'name' => 'Vista 200',
            'description' => 'vista200 description',
            'cover_image_name' => 'vista200.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'colorplus200',
            'name' => 'ColorPlus 200',
            'description' => 'colorplus200 description',
            'cover_image_name' => 'colorplus200.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'xtra400',
            'name' => 'Xtra 400',
            'description' => 'xtra400 description',
            'cover_image_name' => 'xtra400.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'e100',
            'name' => 'E100',
            'description' => 'e100 description',
            'cover_image_name' => 'e100.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'gold200',
            'name' => 'Gold 200',
            'description' => 'gold200 description',
            'cover_image_name' => 'gold200.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'proimage100',
            'name' => 'ProImage 100',
            'description' => 'proimage100 description',
            'cover_image_name' => 'proimage100.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'lomography800',
            'name' => 'Lomography 800',
            'description' => 'lomography800 description',
            'cover_image_name' => 'lomography800.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'gp3',
            'name' => 'Gp3',
            'description' => 'gp3 description',
            'cover_image_name' => 'gp3.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'ilfordhp5400',
            'name' => 'Ilford HP5 400',
            'description' => 'ilfordhp5400 description',
            'cover_image_name' => 'ilfordhp5400.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'kodak250d',
            'name' => 'Kodak 250d',
            'description' => 'kodak250d description',
            'cover_image_name' => 'kodak250d.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'portra400',
            'name' => 'Portra 400',
            'description' => 'portra400 description',
            'cover_image_name' => 'portra400.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'tmax3200',
            'name' => 'Tmax 3200',
            'description' => 'tmax3200 description',
            'cover_image_name' => 'tmax3200.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'ilfordxp2400',
            'name' => 'Ilford XP2 400',
            'description' => 'ilfordxp2400 description',
            'cover_image_name' => 'ilfordxp2400.jpg',
        ]);
        Film::factory()->create([
            'key_name' => '500t',
            'name' => '500T',
            'description' => '500t description',
            'cover_image_name' => '500t.jpg',
        ]);
        Film::factory()->create([
            'key_name' => '50d',
            'name' => '50D',
            'description' => '50d description',
            'cover_image_name' => '50d.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'ektar100',
            'name' => 'Ektar 100',
            'description' => 'ektar100 description',
            'cover_image_name' => 'ektar100.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'filmneverdie400',
            'name' => 'Film Never Die 400',
            'description' => 'filmneverdie400 description',
            'cover_image_name' => 'filmneverdie400.jpg',
        ]);

    }
}


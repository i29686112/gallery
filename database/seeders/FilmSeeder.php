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
        Film::factory()->create(['key_name' => 'c200', 'name' => 'C200', 'cover_image_path' => 'c200.jpg']);
        Film::factory()->create([
            'key_name' => 'vista200',
            'name' => 'Vista 200',
            'cover_image_path' => 'vista200.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'colorplus200',
            'name' => 'ColorPlus 200',
            'cover_image_path' => 'colorplus200.jpg',
        ]);
        Film::factory()->create(['key_name' => 'xtra400', 'name' => 'Xtra 400', 'cover_image_path' => 'xtra400.jpg']);
        Film::factory()->create(['key_name' => 'e100', 'name' => 'E100', 'cover_image_path' => 'e100.jpg']);
        Film::factory()->create(['key_name' => 'gold200', 'name' => 'Gold 200', 'cover_image_path' => 'gold200.jpg']);
        Film::factory()->create([
            'key_name' => 'proimage100',
            'name' => 'ProImage 100',
            'cover_image_path' => 'proimage100.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'lomography800',
            'name' => 'Lomography 800',
            'cover_image_path' => 'lomography800.jpg',
        ]);
        Film::factory()->create(['key_name' => 'gp3', 'name' => 'Gp3', 'cover_image_path' => 'gp3.jpg']);
        Film::factory()->create([
            'key_name' => 'ilfordhp5400',
            'name' => 'Ilford HP5 400',
            'cover_image_path' => 'ilfordhp5400.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'kodak250d',
            'name' => 'Kodak 250d',
            'cover_image_path' => 'kodak250d.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'portra400',
            'name' => 'Portra 400',
            'cover_image_path' => 'portra400.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'tmax3200',
            'name' => 'Tmax 3200',
            'cover_image_path' => 'tmax3200.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'ilfordxp2400',
            'name' => 'Ilford XP2 400',
            'cover_image_path' => 'ilfordxp2400.jpg',
        ]);
        Film::factory()->create(['key_name' => '500t', 'name' => '500T', 'cover_image_path' => '500t.jpg']);
        Film::factory()->create(['key_name' => '50d', 'name' => '50D', 'cover_image_path' => '50d.jpg']);
        Film::factory()->create([
            'key_name' => 'ektar100',
            'name' => 'Ektar 100',
            'cover_image_path' => 'ektar100.jpg',
        ]);
        Film::factory()->create([
            'key_name' => 'filmneverdie400',
            'name' => 'Film Never Die 400',
            'cover_image_path' => 'filmneverdie400.jpg',
        ]);

    }
}


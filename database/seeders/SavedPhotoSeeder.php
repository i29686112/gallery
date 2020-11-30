<?php

namespace Database\Seeders;

use App\Models\SavedPhoto;
use Illuminate\Database\Seeder;

class SavedPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SavedPhoto::factory()->count(20)->create();
    }
}

<?php

namespace Database\Factories;

use App\Models\SavedPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavedPhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SavedPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'file_name' => getRandomFileName(),
            'upload_telegram_user_id' => $this->faker->numerify('#########'),
            'film_id' => $this->faker->numberBetween(1, 18),
        ];
    }
}

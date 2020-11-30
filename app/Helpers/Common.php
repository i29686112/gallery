<?php


if ( ! function_exists('getRandomFileName'))
{
    function getRandomFileName()
    {
        $faker = Faker\Factory::create();

        $now = DateTime::createFromFormat('U.u', microtime(true));

        return $faker->word . '-' . $now->format("u-Y-m-d-H-i-s");
    }

}

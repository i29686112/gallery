<?php


if ( ! function_exists('getRandomFileName'))
{
    function getRandomFileName($fileExtensionName = 'jpg')
    {
        if ( ! $fileExtensionName)
        {
            $fileExtensionName = 'jpg';
        }
        $faker = Faker\Factory::create();

        $now = DateTime::createFromFormat('U.u', microtime(true));

        return $faker->word . '-' . $now->format("u-Y-m-d-H-i-s") . '.' . $fileExtensionName;
    }

}

if ( ! function_exists('getFileExtensionNameFromMimeType'))
{
    function getFileExtensionNameFromMimeType($mimeType = '')
    {
        if ( ! $mimeType)
        {
            return false;
        }


        $availableType = [
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/jpeg' => 'jpg',
        ];

        return (isset($availableType[$mimeType])) ? $availableType[$mimeType] : false;
    }

}

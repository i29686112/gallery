<?php

namespace app\Http\Controllers;


use Tests\TestCase;

class FilmControllerTest extends TestCase
{
    public function testIndex()
    {

        $response = $this->get('/api/film');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "success",
            "code",
            "locale",
            "message",
            "data" => [
                "items" => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'cover_image_name',
                        'cover_image_url',
                    ],
                ],
            ],
        ]);

    }

}

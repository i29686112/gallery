<?php

namespace Tests\Feature;

use Tests\TestCase;

class PhotoControllerTest extends TestCase
{

    public function testIndex_failed_withInvalidFilmIdFormat()
    {

        $response = $this->get('/api/photo/%^&*(');

        $response->assertStatus(404);
    }


    public function testIndex_failed_withNoFilmId()
    {

        $response = $this->get('/api/photo');

        $response->assertStatus(404);
    }


    public function testIndex_ok()
    {

        $response = $this->get('/api/photo/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "success",
            "code",
            "locale",
            "message",
            "data" => [
                "items" => [
                    '*' => [
                        'file_path',
                        'photo_url',
                    ],
                ],
            ],
        ]);
    }
}

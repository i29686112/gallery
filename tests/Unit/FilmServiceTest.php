<?php

namespace Tests\Unit;

use App\Services\FilmService;
use Tests\TestCase;

class FilmServiceTest extends TestCase
{

    private $filmService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filmService = new FilmService();

    }


    public function testGetKeyNameFromCaption_stringWithEmptyAndDifferentCase()
    {
        $this->assertEquals('ilfordxp2400', $this->filmService->getKeyNameFromCaption('Ilford XP2 400'));
    }

    public function testGetKeyNameFromCaption_stringWithNonAlphaNumeric()
    {
        $this->assertEquals('ilfordxp2400', $this->filmService->getKeyNameFromCaption('Ilfor!@#$%^&*(d !@X#$P2 400'));
    }

}

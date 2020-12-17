<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\CreatesApplication;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use CreatesApplication;


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $this->assertTrue(Storage::disk('local')->put('public/photos/example.txt', 'Contents'));
    }

    public function test_str_getcsv()
    {


        $str = '1,2,3,4';
        $str_getcsv = str_getcsv($str);
        $this->assertIsArray($str_getcsv);
    }
}

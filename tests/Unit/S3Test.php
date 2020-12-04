<?php

namespace Tests\Unit;


use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class S3Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testS3IsWorking()
    {

        $photo = file_get_contents(storage_path('app/public/covers/50d.jpg'));

        $result = Storage::disk('s3')->put('photos/50d3.jpg', $photo);


        $this->assertTrue($result);
    }
}

<?php

namespace Tests\Unit;

use App\Classes\PhotoHandler;
use Tests\TestCase;

class PhotoHandlerTest extends TestCase
{

    public function testParseCaptionOK()
    {

        /** @var \Longman\TelegramBot\Entities\Message $message */
        $messageMock = \Mockery::mock("\Longman\TelegramBot\Entities\Message");

        $messageMock->shouldReceive('getCaption')->andReturn('abcde');


        $this->assertEquals('abcde', (new PhotoHandler($messageMock))->getCaption());

    }

    public function testParseCaptionWithEmpty()
    {

        /** @var \Longman\TelegramBot\Entities\Message $message */
        $messageMock = \Mockery::mock("\Longman\TelegramBot\Entities\Message");

        $messageMock->shouldReceive('getCaption')->andReturn(null);


        $this->assertEquals(null, (new PhotoHandler($messageMock))->getCaption());

    }

    public function testGetFileIdOk()
    {

        /** @var \Longman\TelegramBot\Entities\Message $message */
        $messageMock = \Mockery::mock("\Longman\TelegramBot\Entities\Message");

        $photoSizeMock = \Mockery::mock("\Longman\TelegramBot\Entities\PhotoSize");

        $photoSizeMock->shouldReceive('getFileId')->andReturn('abcde');
        $messageMock->shouldReceive('getPhoto')->andReturn([$photoSizeMock]);


        $this->assertEquals('abcde', (new PhotoHandler($messageMock))->getFileId());

    }


}

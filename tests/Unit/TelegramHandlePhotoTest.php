<?php

namespace Tests\Unit;

use App\Classes\TelegramParser;
use Tests\TestCase;

class TelegramHandlePhotoTest extends TestCase
{

    public function testTelegramParserSingleCompressPhotoOk()
    {

        /** @var \Longman\TelegramBot\Entities\Message $message */
        $messageMock = \Mockery::mock("\Longman\TelegramBot\Entities\Message");

        $messageMock->shouldReceive('getType')->andReturn('photo');
        $messageMock->shouldReceive('getProperty')->withArgs(['media_group_id'])->andReturn(null);


        $this->assertTrue(is_a(TelegramParser::create($messageMock), 'App\Classes\SinglePhotoHandler'));

    }

    public function testTelegramParserMultipleCompressPhotoOk()
    {

        /** @var \Longman\TelegramBot\Entities\Message $message */
        $messageMock = \Mockery::mock("\Longman\TelegramBot\Entities\Message");

        $messageMock->shouldReceive('getType')->andReturn('photo');
        $messageMock->shouldReceive('getProperty')->withArgs(['media_group_id'])->andReturn(1);


        $this->assertTrue(is_a(TelegramParser::create($messageMock), 'App\Classes\MultiplePhotoHandler'));

    }

    public function testTelegramParserSingleUnCompressPhotoOk()
    {

        /** @var \Longman\TelegramBot\Entities\Message $message */
        $messageMock = \Mockery::mock("\Longman\TelegramBot\Entities\Message");

        $messageMock->shouldReceive('getType')->andReturn('document');
        // chain mock
        $messageMock->shouldReceive('getDocument->getMimeType')->andReturn('image/jpeg');
        $messageMock->shouldReceive('getProperty')->withArgs(['media_group_id'])->andReturn(null);


        $this->assertTrue(is_a(TelegramParser::create($messageMock), 'App\Classes\SinglePhotoDocumentHandler'));

    }

    public function testTelegramParserMultipleUnCompressPhotoOk()
    {

        /** @var \Longman\TelegramBot\Entities\Message $message */
        $messageMock = \Mockery::mock("\Longman\TelegramBot\Entities\Message");

        $messageMock->shouldReceive('getType')->andReturn('document');
        $messageMock->shouldReceive('getDocument->getMimeType')->andReturn('image/jpeg');
        $messageMock->shouldReceive('getProperty')->withArgs(['media_group_id'])->andReturn(1);


        $this->assertTrue(is_a(TelegramParser::create($messageMock), 'App\Classes\MultiplePhotoDocumentHandler'));

    }


}

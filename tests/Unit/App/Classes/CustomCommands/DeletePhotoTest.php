<?php

namespace App\Classes\CustomCommands;

use Tests\TestCase;

class DeletePhotoTest extends TestCase
{

    public function testCheckAndGetResponse_wrong_keyword()
    {
        $photoIdCsv = '1,2,3,4';

        $mockMessage = \Mockery::mock('Longman\TelegramBot\Entities\Message');
        $mockMessage->shouldReceive('getText')->andReturn('fooboo ' . $photoIdCsv);

        $mockSavedPhotoService = \Mockery::mock('App\Services\SavedPhotoService');
        $mockSavedPhotoService->shouldReceive('deleteByIdArray')->andReturn(str_getcsv($photoIdCsv));


        $this->assertEquals('', DeletePhoto::checkAndGetResponse($mockMessage, $mockSavedPhotoService));

    }

    public function testCheckAndGetResponse_emptyIdCsv()
    {
        $photoIdCsv = '';

        $mockMessage = \Mockery::mock('Longman\TelegramBot\Entities\Message');
        $mockMessage->shouldReceive('getText')->andReturn('delete ' . $photoIdCsv);

        $mockSavedPhotoService = \Mockery::mock('App\Services\SavedPhotoService');
        $mockSavedPhotoService->shouldReceive('deleteByIdArray')->andReturn(str_getcsv($photoIdCsv));


        $this->assertEquals(PLEASE_INPUT_VALID_PHOTO_ID, DeletePhoto::checkAndGetResponse($mockMessage, $mockSavedPhotoService));

    }

    public function testCheckAndGetResponse_single_id_success()
    {
        $photoIdCsv = '1';

        $mockMessage = \Mockery::mock('Longman\TelegramBot\Entities\Message');
        $mockMessage->shouldReceive('getText')->andReturn('delete ' . $photoIdCsv);

        $mockSavedPhotoService = \Mockery::mock('App\Services\SavedPhotoService');
        $mockSavedPhotoService->shouldReceive('deleteByIdArray')->andReturn(str_getcsv($photoIdCsv));


        $this->assertEquals(WE_DELETED_YOUR_PHOTO . $photoIdCsv, DeletePhoto::checkAndGetResponse($mockMessage, $mockSavedPhotoService));

    }


    public function testCheckAndGetResponse_all_success()
    {
        $photoIdCsv = '1,2,3,4';

        $mockMessage = \Mockery::mock('Longman\TelegramBot\Entities\Message');
        $mockMessage->shouldReceive('getText')->andReturn('delete ' . $photoIdCsv);

        $mockSavedPhotoService = \Mockery::mock('App\Services\SavedPhotoService');
        $mockSavedPhotoService->shouldReceive('deleteByIdArray')->andReturn(str_getcsv($photoIdCsv));


        $this->assertEquals(WE_DELETED_YOUR_PHOTO . $photoIdCsv, DeletePhoto::checkAndGetResponse($mockMessage, $mockSavedPhotoService));

    }

    public function testCheckAndGetResponse_all_failed()
    {
        $photoIdCsv = '1,2,3,4';

        $mockMessage = \Mockery::mock('Longman\TelegramBot\Entities\Message');
        $mockMessage->shouldReceive('getText')->andReturn('delete ' . $photoIdCsv);

        $mockSavedPhotoService = \Mockery::mock('App\Services\SavedPhotoService');
        $mockSavedPhotoService->shouldReceive('deleteByIdArray')->andReturn([]);

        $this->assertEquals(WE_DELETE_YOUR_PHOTO_FAILED . $photoIdCsv, DeletePhoto::checkAndGetResponse($mockMessage, $mockSavedPhotoService));

    }

    public function testCheckAndGetResponse_partial_failed()
    {
        $photoIdCsv = '1,2,3,4,5,6,7,8';

        // 把輸入的id分成刪除及失敗2部份
        $arrayChunk = array_chunk(str_getcsv($photoIdCsv), 4);
        $successIdArray = $arrayChunk[0];
        $failedIdArray = $arrayChunk[1];

        $mockMessage = \Mockery::mock('Longman\TelegramBot\Entities\Message');
        $mockMessage->shouldReceive('getText')->andReturn('delete ' . $photoIdCsv);

        $mockSavedPhotoService = \Mockery::mock('App\Services\SavedPhotoService');
        $mockSavedPhotoService->shouldReceive('deleteByIdArray')->andReturn($successIdArray);


        //預期的結果
        $responseText = WE_DELETED_YOUR_PHOTO . join(',', $successIdArray);
        $responseText .= "\n" . BUT_FAILED_DELETE . join(',', $failedIdArray);

        $this->assertEquals($responseText, DeletePhoto::checkAndGetResponse($mockMessage, $mockSavedPhotoService));

    }


}

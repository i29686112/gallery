<?php


namespace App\Classes\CustomCommands;


use App\Services\SavedPhotoService;
use Longman\TelegramBot\Entities\Message;

class DeletePhoto
{

    public static function checkAndGetResponse(Message $message, $savedPhotoService = null)
    {
        $responseText = '';

        if (stripos(mb_strtolower($message->getText()), 'delete') === false) {
            return $responseText;
        }

        if (!$savedPhotoService) {
            //to test inject mock service.
            $savedPhotoService = new SavedPhotoService();
        }

        $photoIdArray = self::parseIdCsvStringToArray($message->getText());

        $successDeletedIdArray = $savedPhotoService->deleteByIdArray($photoIdArray);

        $failedDeletedIdArray = array_filter($photoIdArray, function ($photoId) use ($successDeletedIdArray) {
            return !in_array($photoId, $successDeletedIdArray);
        });

        if (count($photoIdArray) === 0) {
            //沒輸入照片id
            $responseText = PLEASE_INPUT_VALID_PHOTO_ID;

        } else if (count($successDeletedIdArray) > 0) {
            //有刪成功的話

            $responseText = WE_DELETED_YOUR_PHOTO . join(',', $successDeletedIdArray);

            if (count($failedDeletedIdArray) > 0) {
                //有刪成功，但也有刪失敗的話，分開顯示
                $responseText .= "\n" . BUT_FAILED_DELETE . join(',', $failedDeletedIdArray);
            }

        } else {
            //完全刪失敗的話
            $responseText = WE_DELETE_YOUR_PHOTO_FAILED . join(',', $photoIdArray);

        }

        return $responseText;
    }


    private static function parseIdCsvStringToArray($text)
    {
        //remove delete and blank
        $idArray = str_getcsv(preg_replace('/delete[\s]*/m', '', strtolower($text)));

        return array_filter($idArray, function ($id) {

            return is_numeric($id);

        });


    }

}

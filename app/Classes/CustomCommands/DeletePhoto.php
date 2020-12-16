<?php


namespace App\Classes\CustomCommands;


use App\Services\SavedPhotoService;
use Longman\TelegramBot\Entities\Message;

class DeletePhoto
{

    public static function checkAndGetResponse(Message $message)
    {
        $responseText = '';

        if (stripos(mb_strtolower($message->getText()), 'delete') === false) {
            return $responseText;
        }

        $photoIdArray = self::getId($message->getText());

        $savedPhotoService = new SavedPhotoService();

        $deletedIdArray = $savedPhotoService->deleteByIdArray($photoIdArray);
        if (count($deletedIdArray) > 0) {
            $responseText = WE_DELETED_YOUR_PHOTO . join(',', $deletedIdArray);
        } else {
            $responseText = WE_DELETE_YOUR_PHOTO_FAILED . join(',', $photoIdArray);
        }

        return $responseText;
    }


    private static function getId($text)
    {
        //remove delete and blank
        $idArray = str_getcsv(preg_replace('/delete[\s]*/m', '', strtolower($text)));

        return array_filter($idArray, function ($id) {

            return is_numeric($id);

        });


    }

}

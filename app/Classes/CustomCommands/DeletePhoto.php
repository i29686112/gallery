<?php


namespace App\Classes\CustomCommands;


use App\Services\SavedPhotoService;
use Longman\TelegramBot\Entities\Message;

class DeletePhoto
{

    public static function checkAndGetResponse(Message $message)
    {
        $responseText = '';

        if (stripos(mb_strtolower($message->getText()), 'delete') === false)
        {
            return $responseText;
        }

        //list all picture under a film
        $photoId = str_replace('delete ', '', $message->getText());

        if ($photoId === '' || ! is_numeric($photoId))
        {
            return INVALID_PHOTO_ID;
        }

        $savedPhotoService = new SavedPhotoService();

        if ($film = $savedPhotoService->deleteById($photoId))
        {
            $responseText = WE_DELETED_YOUR_PHOTO . $photoId;
        } else
        {
            $responseText = WE_DELETE_YOUR_PHOTO_FAILED . $photoId;
        }

        return $responseText;
    }

}

<?php


namespace App\Classes;

use Longman\TelegramBot\Entities\Message;

class PhotoHandlerFactory
{


    /**
     * @param Message $message
     * @return PhotoHandler
     */
    public static function create(Message $message)
    {
        if ($message->getType() === 'photo')
        {
            if ($message->getProperty('media_group_id') !== null)
            {

                return new MultiplePhotoHandler($message);
            }
            return new SinglePhotoHandler($message);

        }


        if ($message->getType() === 'document' && in_array($message->getDocument()->getMimeType(),
                ['image/png', 'image/gif', 'image/jpeg']))
        {
            if ($message->getProperty('media_group_id') !== null)
            {

                return new MultiplePhotoDocumentHandler($message);
            }
            return new SinglePhotoDocumentHandler($message);

        }

        return new NonPhotoHandler($message);


    }
}

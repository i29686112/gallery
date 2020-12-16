<?php


namespace App\Classes\CustomCommands;


use App\Services\FilmService;
use App\Services\SavedPhotoService;
use Longman\TelegramBot\Entities\Message;

class ListPhoto
{

    public static function checkAndGetResponse(Message $message)
    {
        $responseText = '';

        if (stripos(mb_strtolower($message->getText()), 'list') === false)
        {
            return $responseText;
        }

        //list all picture under a film
        $filmName = str_replace('list ', '', $message->getText());

        $filmService = new FilmService();

        if ($film = $filmService->getFilmFromCaption($filmName))
        {
            $savedPhotoService = new SavedPhotoService();
            $photoList = $savedPhotoService->getByFilmId($film->id, ['file_name', 'id']);

            $responseText = WE_GOT_YOUR_FILM . $filmName;

            foreach ($photoList as $photo)
            {
                $responseText .= "\n({$photo->id})\n" . $photo->photo_url;
            }


        } else
        {
            $responseText = UNKNOWN_FILM_MESSAGE;
        }

        return $responseText;
    }

}

<?php


namespace App\Classes;


use App\Services\FilmService;
use App\Services\SavedPhotoService;

class NonPhotoHandler extends PhotoHandler
{


    public function process()
    {

        if (stripos(mb_strtolower($this->message->getText()), 'list') === 0)
        {
            //list all picture under a film
            $filmName = str_replace('list ', '', $this->message->getText());

            $filmService = new FilmService();

            if ($film = $filmService->getFilmFromCaption($filmName))
            {
                $savedPhotoService = new SavedPhotoService();
                $photoList = $savedPhotoService->getByFilmId($film->id, ['file_name', 'id']);

                $this->responseText = WE_GOT_YOUR_FILM . $filmName;

                foreach ($photoList as $photo)
                {
                    $this->responseText .= "\n({$photo->id})\n" . $photo->photo_url;
                }


            } else
            {

                $this->responseText = UNKNOWN_FILM_MESSAGE;

            }


        } else
        {
            $this->responseText = NOT_PHOTO_MESSAGE;
        }


        return false;

    }


}

<?php


namespace App\Classes;


use App\Services\FilmService;

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

                $this->responseText = WE_GOT_YOUR_FILM . $filmName;
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

<?php


namespace App\Classes;


class NonPhotoHandler extends PhotoHandler
{

    public function process()
    {

        $this->responseText = NOT_PHOTO_MESSAGE;

        return false;

    }


}

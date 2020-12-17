<?php


namespace App\Classes;


use App\Classes\CustomCommands\DeletePhoto;
use App\Classes\CustomCommands\ListPhoto;

class NonPhotoHandler extends PhotoHandler
{


    public function process()
    {

        $this->responseText = NOT_PHOTO_MESSAGE;

        if ($response = ListPhoto::checkAndGetResponse($this->message)) {
            $this->responseText = $response;

        }

        if ($response = DeletePhoto::checkAndGetResponse($this->message)) {
            $this->responseText = $response;
        }


        return false;

    }


}

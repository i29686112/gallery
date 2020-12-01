<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class TelegramController extends Controller
{
    //


    public function index(Request $request, Telegram $telegram)
    {

        try
        {

            $telegram->setCustomInput($request->getContent());

            if ($telegram->handle())
            {

                $response = $telegram->getLastCommandResponse();

                if ( ! $response)
                {
                    // we need check again cause sometime it may got NULL
                    return 'ok';

                }

                $responseText = $response->getResult()->text;

                if (stripos($responseText, SAVE_PHOTO_SUCCESS_MESSAGE) !== false)
                {
                    return SAVE_PHOTO_SUCCESS_MESSAGE;
                }

                if (stripos($responseText, SAVE_PHOTO_FAILED_MESSAGE) !== false)
                {
                    return SAVE_PHOTO_FAILED_MESSAGE;
                }

                // 因為有分行，我們判斷前10個字元就好
                if (stripos(UNKNOWN_FILM_MESSAGE, substr($responseText, 0, 10)) !== false)
                {
                    return UNKNOWN_FILM_MESSAGE;
                }

                if (stripos($responseText, NOT_SUPPORT_UNCOMPRESSED_PHOTO) !== false)
                {
                    return NOT_SUPPORT_UNCOMPRESSED_PHOTO;
                }

                return NOT_PHOTO_MESSAGE;
            }

            return DO_NOTHING_MESSAGE;

        } catch (TelegramException $e)
        {
            Log::error(exceptionToString($e));
            return "failed";
        }


    }

    public function hello(Request $request)
    {

        return 'hi';

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class TelegramController extends Controller
{
    //


    public function index(Request $request, Telegram $telegram, $apiSecret)
    {


        $input = $request->getContent();

        $chatId = $this->getChatId($input, $telegram);

        if ( ! $this->checkTheApiCallIsValid($chatId, $apiSecret))
        {
            if ($chatId === false)
            {
                // not a valid input.
                return DO_NOTHING_MESSAGE;
            }

            \Longman\TelegramBot\Request::sendMessage([
                'chat_id' => $chatId,
                'text' => NO_ADMIN_USING_MESSAGE,
            ]);
            return NO_ADMIN_USING_MESSAGE;

        }

        $telegram->setCustomInput($input);

        return $this->handleMessage($telegram);


    }

    public function hello(Request $request)
    {

        return 'hi';

    }


    /**
     * @param $chatId
     * @return bool
     */
    protected function checkTheApiCallIsValid($chatId, $apiSecret)
    {

        return ($chatId === (int)env('TELEGRAM_ADMIN_USER_ID')) && $apiSecret === env('TELEGRAM_API_SECRET');

    }

    private function getChatId(string $input, Telegram $telegram)
    {
        try
        {
            $update = new Update(json_decode($input, true), $telegram->getBotUsername());
            return $update->getMessage()->getChat()->getId();
        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));
        }

        return false;
    }


    private function handleMessage(Telegram $telegram)
    {
        try
        {
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
        } catch (TelegramException $e)
        {
            Log::error(exceptionToString($e));
        }

        return DO_NOTHING_MESSAGE;

    }

}

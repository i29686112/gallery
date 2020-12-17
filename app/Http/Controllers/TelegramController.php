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

        if (!$this->checkTheApiCallIsValid($chatId, $apiSecret)) {
            if ($chatId === false) {
                // not a valid input.
                return DO_NOTHING_MESSAGE;
            }

            \Longman\TelegramBot\Request::sendMessage([
                'chat_id' => $chatId,
                'text'    => NO_ADMIN_USING_MESSAGE,
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
        try {
            $update = new Update(json_decode($input, true), $telegram->getBotUsername());
            return $update->getMessage()->getChat()->getId();
        } catch (\Exception $e) {
            log::error(exceptionToString($e));
        }

        return false;
    }


    private function handleMessage(Telegram $telegram)
    {
        try {
            if ($telegram->handle()) {

                $response = $telegram->getLastCommandResponse();

                if (!$response) {
                    // we need check again cause sometime it may got NULL
                    return 'ok';

                }

                $responseText = $response->getResult()->text;


                $resultText = NOT_PHOTO_MESSAGE;
                foreach ([
                             SAVE_PHOTO_SUCCESS_MESSAGE,
                             SAVE_PHOTO_FAILED_MESSAGE,
                             UNKNOWN_FILM_MESSAGE,
                             NOT_SUPPORT_UNCOMPRESSED_PHOTO,
                             WE_GOT_YOUR_FILM,
                             WE_DELETED_YOUR_PHOTO,
                             WE_DELETE_YOUR_PHOTO_FAILED,
                             BUT_FAILED_DELETE,
                             PLEASE_INPUT_VALID_PHOTO_ID
                         ] as $message) {

                    if (stripos($responseText, $message) !== false) {
                        $resultText = $message;
                    }

                    // 因為有分行，我們判斷前10個字元就好
                    if (stripos(UNKNOWN_FILM_MESSAGE, substr($responseText, 0, 10)) !== false) {
                        $resultText = UNKNOWN_FILM_MESSAGE;
                    }

                }


                return $resultText;
            }
        } catch (TelegramException $e) {
            Log::error(exceptionToString($e));
        }

        return DO_NOTHING_MESSAGE;

    }

}

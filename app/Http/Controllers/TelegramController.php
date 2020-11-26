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
                return "ok";
            }

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

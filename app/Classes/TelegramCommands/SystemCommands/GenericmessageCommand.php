<?php

/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Classes\SystemCommands;

use App\Exceptions\CaptionNotSetException;
use App\Exceptions\FileIdNotSetException;
use App\Exceptions\PhotoNotFoundException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Redis;

/**
 * Generic message command
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = Telegram::GENERIC_MESSAGE_COMMAND;

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * @var bool
     */
    protected $need_mysql = true;

    /**
     * Execution if MySQL is required but not available
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function executeNoDb()
    {
        // Try to execute any deprecated system commands.
        if (self::$execute_deprecated && $deprecated_system_command_response = $this->executeDeprecatedSystemCommand())
        {
            return $deprecated_system_command_response;
        }

        return Request::emptyResponse();
    }

    /**
     * Execute command
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute()
    {
        // non-command message will be execute the block
        // Try to continue any active conversation.
        if ($active_conversation_response = $this->executeActiveConversation())
        {
            return $active_conversation_response;
        }

        // Try to execute any deprecated system commands.
        if (self::$execute_deprecated && $deprecated_system_command_response = $this->executeDeprecatedSystemCommand())
        {
            return $deprecated_system_command_response;
        }


        $message = $this->getMessage();
        $chatId = $message->getChat()->getId();

        $responseText = 'Some problem happens while get photo size, please send it again';

        if ($message->getType() === 'photo' && $photos = $message->getPhoto())
        {
            $caption = $message->getProperty('caption');
            $mediaGroupId = $message->getProperty('media_group_id');

            if (isset($photos[0]))
            {
                if ($mediaGroupId)
                {
                    $caption = $this->handleMultiplePhoto($caption, $mediaGroupId);
                }

                try
                {
                    if ( ! $caption)
                    {
                        throw new CaptionNotSetException();
                    }
                    $fileId = $photos[0]->getFileId();
                    if ( ! $fileId)
                    {
                        throw new FileIdNotSetException();
                    }

                    $filePath = $this->getFilePathByFileId($fileId);
                    $file = $this->getFileByFilePath($filePath);

                    if ( ! $file)
                    {
                        throw new PhotoNotFoundException();
                    }


                    $responseText = 'Cool, we got your photo with caption:' . $caption;


                } catch (CaptionNotSetException $e)
                {
                    $responseText = 'Please write a film name for the photo';

                } catch (FileIdNotSetException $e)
                {

                    $responseText = 'Some problem happens while get photo id, please send it again';

                } catch (PhotoNotFoundException $e)
                {
                    $responseText = 'Some problem happens while get photo file, please send it again';

                }

            }

        } else
        {
            $responseText = 'Please send a photo';
        }

        return Request::sendMessage(['chat_id' => $chatId, 'text' => $responseText]);

    }

    /**
     * @param $mediaGroupId
     * @param $caption
     */
    protected function setCaptionInRedis($mediaGroupId, $caption): void
    {


        /** @var Redis $redis */
        $redis = resolve('Redis');

        // only set when the key is not exist, and it will auto deleted after 1 min
        $redis->set($mediaGroupId, $caption,
            ['NX', 'EX' => 60]);

    }

    /**
     * @param $caption
     * @param $mediaGroupId
     * @return bool|mixed|string
     */
    protected function handleMultiplePhoto($caption, $mediaGroupId)
    {
        //multiple images
        /** @var Redis $redis */
        $redis = resolve('Redis');

        if ($caption)
        {
            //first image in the media group, save its caption in redis for other images in the same media group
            $this->setCaptionInRedis($mediaGroupId, $caption);
        } else
        {
            //get caption from redis with same media group id
            $caption = $redis->get($mediaGroupId);
        }
        return $caption;
    }

    private function getFilePathByFileId(string $fileId)
    {

        /** @var Client $http */
        $http = resolve('GuzzleHttp\Client');
        //https://api.telegram.org/bot1499930220:AAFlvI__hozB3ImiUaiPvrERdDdA7SpXXWM/getFile?file_id=AgACAgUAAxkBAAMeX79pzqco8f8zpaqVEF9GSpFGeiYAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E

        try
        {
            $response = $http->get(env('TELEGRAM_BOT_API_URL') . 'bot' . env('TELEGRAM_BOT_API_KEY') . '/getFile?file_id=' . $fileId);
            $contents = json_decode($response->getBody()->getContents());
            return (isset($contents->result->file_path) && $contents->result->file_path !== '') ? $contents->result->file_path : false;
        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));
        }
        return false;

    }

    private function getFileByFilePath($filePath)
    {

        if ( ! $filePath)
        {
            return false;
        }


        /** @var Client $http */
        $http = resolve('GuzzleHttp\Client');
        //https://api.telegram.org/file/bot1499930220:AAFlvI__hozB3ImiUaiPvrERdDdA7SpXXWM/photos/file_1.jpg

        try
        {

            $response = $http->request('get',
                env('TELEGRAM_BOT_API_URL') . 'file/bot' . env('TELEGRAM_BOT_API_KEY') . '/' . $filePath,
                [
                    'sink' => storage_path('test' . mt_rand(0, 1000) . '.jpg'),
                ]);

            return $response;
        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));

        }
        return false;
    }
}



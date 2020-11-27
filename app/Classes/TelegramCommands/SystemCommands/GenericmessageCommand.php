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

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

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

        if ($message->getType() === 'photo' && $photos = $message->getPhoto())
        {
            if (isset($photos[0]))
            {
                if ($message->getProperty('media_group_id') && $message->getProperty('caption'))
                {

                    $redis = resolve('Redis');

                }
                $fileId = $photos[0]->getFileId();


                return Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Cool, we got your photo with caption:' . $message->getProperty('caption'),
                ]);

            }

        } else
        {
            return Request::sendMessage(['chat_id' => $chatId, 'text' => 'Please send a photo']);
        }
        //$user_id = $message->getFrom()->getId();


    }
}

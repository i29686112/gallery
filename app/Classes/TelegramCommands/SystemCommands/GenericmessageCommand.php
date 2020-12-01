<?php

/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Classes\TelegramCommands\SystemCommands;

use App\Classes\PhotoHandlerFactory;
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

        if ($response = $this->handleActiveConversationOrDeprecatedSystemCommand())
        {
            return $response;
        }

        $message = $this->getMessage();
        $chatId = $message->getChat()->getId();

        $photoHandler = PhotoHandlerFactory::create($message);
        $photoHandler->process();
        $responseText = $photoHandler->getResponseText();

        return Request::sendMessage(['chat_id' => $chatId, 'text' => $responseText]);

    }

    private function handleActiveConversationOrDeprecatedSystemCommand()
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

        return false;
    }
}



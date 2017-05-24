<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class Ping
 * @package Bot\Commands
 */
class Ping extends Command
{
    /**
     * Command handler.
     *
     * @param  Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     * @return void
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $bot->sendMessage($message->getChat()->getId(), 'pong!');
    }
}

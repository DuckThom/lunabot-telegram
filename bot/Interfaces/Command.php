<?php

namespace Bot\Interfaces;

use Bot\Client;
use TelegramBot\Api\Types\Message;

/**
 * Interface Command
 * @package Bot\Interfaces
 */
interface Command
{

    /**
     * Command handler
     *
     * @param  Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     */
    public static function run(Client $bot, Message $message);

}

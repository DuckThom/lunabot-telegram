<?php

namespace Bot\Interfaces;

use Bot\Client;
use TelegramBot\Api\Types\Message;

interface Command
{

    /**
     * Command handler
     *
     * @param  Bot\Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     */
    public static function run(Client $bot, Message $message);

}

<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;
use Bot\Interfaces\Command as CommandInterface;

abstract class Command implements CommandInterface
{

    /**
     * Run the command.
     *
     * @param  Bot\Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     */
    public static function run(Client $bot, Message $message)
    {
        $cmd = new static($bot);

        $array = explode(" ", $message->getText());

        $args = count($array) >= 2 ? array_slice($array, 1) : [];

        $cmd->handle($bot, $message, $args);
    }

    /**
     * Command handler, should be overridden in the actual command.
     *
     * @param  Bot\Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     * @throws \Exception
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        throw new \Exception("Error Processing Request", 1);
    }

}

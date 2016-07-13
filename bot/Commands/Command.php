<?php

namespace Bot\Commands;

use Bot\Client;
use Bot\Exceptions\Exception;
use TelegramBot\Api\Types\Message;
use Bot\Interfaces\Command as CommandInterface;

/**
 * Class Command
 * @package Bot\Commands
 */
abstract class Command implements CommandInterface
{

    /**
     * Run the command.
     *
     * @param  Client $bot
     * @param  Message $message
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
     * @param  Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     * @throws Exception
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        throw new Exception(__CLASS__ . " does not have a handler.");
    }

}

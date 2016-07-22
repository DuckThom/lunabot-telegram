<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;
use Bot\Interfaces\Command as CommandInterface;

/**
 * Class AdminCommand
 * @package Bot\Commands
 */
abstract class AdminCommand extends Command implements CommandInterface
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

        if ($message->getFrom()->getId() == env('ADMIN_ID')) {
            $cmd->handle($bot, $message, $args);
        }
    }

}

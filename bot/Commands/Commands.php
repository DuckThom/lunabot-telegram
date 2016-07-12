<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

class Commands extends Command
{

    /**
     * List of possible commands.
     *
     * @var array
     */
    public static $commands = [
        'commands'  => self::class,
        'ping'      => Ping::class,
        'weather'   => Weather::class,
        'fortune'   => Fortune::class,
        'laugh'     => Laugh::class,
        'doge'      => Doge::class,
        'git'       => Git::class,
        'hatquote'  => Hatquote::class
    ];

    /**
     * Command handler.
     *
     * @param  Bot\Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $text = "Possible commands are:\n";

        foreach (self::$commands as $command => $class) {
            $text .= "/{$command} ";
        }

        $bot->sendMessage($message->getChat()->getId(), $text);
    }

}

<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class Laugh
 * @package Bot\Commands
 */
class Laugh extends Command
{
    /**
     * List of possible responses.
     *
     * @var array
     */
    private $responses = [
        "HAHAHAHAHAHAHAHAHAHAHAHAHAHA",
        "mwaahaAHAHAAHHAHAAHHAHAHA",
        "hehe",
        "hahahahaha",
        "hahahaAHAHAHA",
        "TeeHee",
        "kek",
        "topkek",
        "lol",
        "lawl",
        "haha",
        "huehuehue",
        "lololololol",
        "trolololol",
        "hihihihihi",
        "lmao",
        "rofl",
        "roflcopter",
        "55555",
        "www",
    ];

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
        $text = $this->responses[array_rand($this->responses)];

        $bot->sendMessage($message->getChat()->getId(), $text);
    }
}

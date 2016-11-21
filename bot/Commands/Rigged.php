<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class Rigged
 * @package Bot\Commands
 */
class Rigged extends Command
{
    
    /**
     * @var array
     */
    private $messages = [
        "I'm not rigged ye bastard!",
        "Feck off m8, I'm clean!",
        "I've done nothing wrong! Nothing that you can prove anyway...",
        "You can't prove anything!",
        "In my defence: I'm just doing what I'm told...",
        "Prove it!"
    ];

    /**
     * Command handler.
     *
     * @param  Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $text = $this->_getMessage();
    
        $bot->sendMessage($message->getChat()->getId(), $text);
    }
    
    /**
     * Get a random message from the array.
     *
     * @return string
     */
    protected function _getMessage()
    {
        return $this->messages[array_rand($this->messages)];
    }
    
}

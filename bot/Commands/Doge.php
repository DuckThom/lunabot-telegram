<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class Doge
 * @package Bot\Commands
 */
class Doge extends Command
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
        $stickerHash = "BQADAgAD3gAD9HsZAAFphGBFqImfGAI";

        $bot->sendSticker($message->getChat()->getId(), $stickerHash);
    }
}

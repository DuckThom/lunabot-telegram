<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

class Doge extends Command
{

    /**
     * Command handler.
     *
     * @param  Bot\Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $stickerHash = "BQADAgAD3gAD9HsZAAFphGBFqImfGAI";

        $bot->sendSticker($message->getChat()->getId(), $stickerHash);
    }

}

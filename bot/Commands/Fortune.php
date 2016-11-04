<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class Fortune
 * @package Bot\Commands
 */
class Fortune extends Command
{

    /**
     * Command handler.
     *
     * @param  Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $text = '';

		exec("/usr/games/fortune -a", $out, $code);

		// If the return code is 0 (successful) return the fortune
		if ($code === 0) {
			foreach($out as $line) { // Needed for multi-line fortunes
				$text .= $line . "\r\n";
            }

            // Too many Mark Twain fortunes, let's take it out on him!
			$text = preg_replace("/Mark\sTwain/", 'Mark "The Twat" Twain', $text);
		} else {
			$text = "No fortunes found :(";
        }

        $bot->sendMessage($message->getChat()->getId(), $text);
    }

}

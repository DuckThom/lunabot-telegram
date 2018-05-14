<?php

namespace Bot;

use Bot\Commands\Commands;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Client as ApiClient;

/**
 * Client
 *
 * @package Bot
 */
class Client extends ApiClient
{
    /**
     * Load all the commands in bot/Commands/Kernel::$commands
     *
     * @return void
     */
    public function loadCommands()
    {
        $bot = $this;

        foreach(Commands::$commands as $command => $class) {
            $this->command($command, function(Message $message) use (&$bot, $command, $class) {
                if ($bot->isTarget($message->getText())) {
                    Log::info("Executing command {$command} - Requester: " . json_encode([
                        'id' => $message->getFrom()->getId(),
                        'first_name' => $message->getFrom()->getFirstName(),
                        'last_name' => $message->getFrom()->getLastName(),
                        'chat_id' => $message->getChat()->getId(),
                    ]));

                    $class::run($bot, $message);
                }
            });
        }
    }

    /**
     * Check if the bot is the target
     *
     * @param  string $message
     * @return boolean
     */
    public function isTarget($message)
    {
        preg_match("/@(.*)\s*/", $message, $matches);

        $name   = env('BOT_NAME');
        $target = (isset($matches[1]) ? $matches[1] : $name);

        return strtolower($target) === strtolower($name);
    }
}

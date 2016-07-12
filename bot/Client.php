<?php

namespace Bot;

use Bot\Commands\Commands;
use Nayjest\StrCaseConverter\Str;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Client as ApiClient;

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
            $this->command($command, function($message) use (&$bot, $command, $class) {
                if ($bot->isTarget($message)) {
                    $class::run($bot, $message);
                }
            });
        }
    }

    /**
     * Check if the bot is the target
     *
     * @param  TelegramBot\Api\Types\Message $message
     * @return boolean
     */
    public function isTarget($message)
    {
        preg_match("/@(.*)\s*/", $message->getText(), $matches);

        $name   = env('BOT_NAME');
        $target = (isset($matches[1]) ? $matches[1] : $name);

        return strtolower($target) === strtolower($name);
    }

}

<?php

namespace Bot;

use Bot\Commands\Commands;
use Nayjest\StrCaseConverter\Str;
use \TelegramBot\Api\Client as ApiClient;

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
                $class::run($bot, $message);
            });
        }
    }

}

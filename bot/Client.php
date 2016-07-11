<?php

namespace Bot;

use \TelegramBot\Api\Client as ApiClient;
use Bot\Commands\Commands;

class Client extends ApiClient
{

    /**
     * Load all the commands in bot/Commands/Kernel::$commands
     *
     * @return void
     */
    public function loadCommands()
    {
        $client = $this;

        foreach(Commands::$commands as $command => $class) {
            $this->command($command, function($message) use (&$client, $command, $class) {
                $class::run($client, $message);
            });
        }
    }

}

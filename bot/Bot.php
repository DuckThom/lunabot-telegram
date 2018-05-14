<?php

namespace Bot;

use josegonzalez\Dotenv\Loader;

/**
 * Bot
 *
 * @package Bot
 */
class Bot {
    /**
     * Start the bot.
     *
     * @return void
     */
    public static function boot()
    {
        $loader = new Loader(base_path('.env'));
        // Parse the .env file
        $loader->parse();
        // Send the parsed .env file to the $_ENV variable
        $loader->toEnv();

        try {
            // Create a new Bot\Client instance
            $bot = new Client(env('BOT_API'));

            // Load the commands
            $bot->loadCommands($bot);

            // Process the message
            $bot->run();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}

<?php

require(__DIR__ . '/../vendor/autoload.php');

define('BASE_PATH', __DIR__ . "/..");

$loader = new josegonzalez\Dotenv\Loader(base_path('.env'));
// Parse the .env file
$loader->parse();
// Send the parsed .env file to the $_ENV variable
$loader->toEnv();

try {
    $bot = new \Bot\Client(env('BOT_API'));

    $bot->loadCommands($bot);

    $bot->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}

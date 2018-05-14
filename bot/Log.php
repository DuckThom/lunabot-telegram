<?php

namespace Bot;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class Log
 * @package Bot
 */
class Log
{
    /**
     * Using this function will cause functions from Monolog\Logger to be static
     *
     * @param  string  $method
     * @param  array  $args
     * @return void
     */
    public static function __callStatic($method, $args)
    {
        call_user_func_array(function($message) use ($method) {
            $log = new Logger('bot');
            $log->pushHandler(new StreamHandler(storage_path('bot/logs/bot.log'), Logger::DEBUG));

            $log->$method($message);
        }, $args);
    }
}

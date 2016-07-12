<?php

namespace Bot;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log {

    public static function __callStatic($method, $args)
    {
        call_user_func_array(function($message) use ($method) {
            $log = new Logger('bot');
            $log->pushHandler(new StreamHandler(storage_path('bot/logs/bot.log'), Logger::DEBUG));

            $log->$method($message);
        }, $args);
    }

}

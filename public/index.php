<?php

require ('../vendor/autoload.php');

define('BOT_START', microtime(true));
define('BASE_PATH', __DIR__ . "/..");

\Bot\Bot::boot();

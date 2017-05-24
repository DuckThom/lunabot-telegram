<?php

if (!function_exists('env')) {
    /**
     * Read a value from $_ENV
     *
     * @param  string $key
     * @param  string $default
     * @return mixed
     */
    function env($key, $default = "") {
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}

if (!function_exists('base_path')) {
    /**
     * Return the full path to the project root
     *
     * @param  string $path
     * @return string
     */
    function base_path($path = "") {
        return realpath(BASE_PATH . ($path ? "/" . $path : ''));
    }
}

if (!function_exists('bot_path')) {
    /**
     * Return the full path to the bot folder
     *
     * @param  string $path
     * @return string
     */
    function bot_path($path = "") {
        return base_path('bot/' . $path);
    }
}

if (!function_exists('storage_path')) {
    /**
     * Return the full path to the storage folder
     *
     * @param  string $path
     * @return string
     */
    function storage_path($path = "") {
        return base_path('storage/' . $path);
    }
}

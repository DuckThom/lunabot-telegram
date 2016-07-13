<?php

namespace Bot\Exceptions;

/**
 * Class Exception
 * @package Bot\Exceptions
 */
class Exception extends \Exception
{

    /**
     * Exception constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $message = "[" . get_class(static::class) . "] {$message}";

        parent::__construct($message, $code, $previous);
    }

}
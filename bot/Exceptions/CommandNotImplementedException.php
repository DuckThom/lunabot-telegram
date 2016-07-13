<?php

namespace Bot\Exceptions;

use Bot\Exception;

/**
 * Class CommandNotImplementedException
 * @package Bot\Exceptions
 */
class CommandNotImplementedException extends Exception
{

    /**
     * CommandNotImplementedException constructor.
     * @param $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
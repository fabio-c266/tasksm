<?php

namespace src\Exceptions;

use src\Core\Response;

class UnexpectedErrorException extends \Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code, $code === 0 ? Response::HTTP_BAD_REQUEST : $code);
    }
}
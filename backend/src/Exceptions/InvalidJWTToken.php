<?php

namespace src\Exceptions;

use src\Core\Response;

class InvalidJWTToken extends \Exception
{
    public function __construct()
    {
        parent::__construct('Token Inválido', Response::HTTP_UNAUTHORIZED);
    }
}
<?php

namespace src\Exceptions;

use Exception;
use src\Core\Response;

class EmailOrPasswordInvalid extends Exception
{
    public function __construct()
    {
        parent::__construct('Email ou senha inválidos', Response::HTTP_UNAUTHORIZED);
    }
}
<?php

namespace src\Exceptions;

use src\Core\Response;

class RouterNotFound extends \Exception
{
    public function __construct()
    {
        parent::__construct("Rota não encontrada", Response::HTTP_NOT_FOUND);
    }
}
<?php

namespace src\Exceptions;

use src\Core\Response;

class TaskInvalidUpdateBody extends \Exception
{
    public function __construct()
    {
        parent::__construct("Corpo de atualização inválido", Response::HTTP_BAD_REQUEST);
    }
}
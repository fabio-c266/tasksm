<?php

namespace src\Exceptions;

use src\Core\Response;

class TaskNotFound extends \Exception
{
    public function __construct()
    {
        parent::__construct("Tarefa não encontrada", Response::HTTP_BAD_REQUEST);
    }
}
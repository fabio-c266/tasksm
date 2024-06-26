<?php

namespace src\Exceptions;

use src\Core\Response;

class TaskWithSameTitle extends \Exception
{
    public function __construct()
    {
        parent::__construct('Você já possui uma tarefa com esse título', Response::HTTP_BAD_REQUEST);
    }
}
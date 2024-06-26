<?php

namespace src\Exceptions;

use src\Core\Response;

class TaskWithSameDescription extends \Exception
{
    public function __construct()
    {
        parent::__construct('Essa tarefa já possui essa descrição', Response::HTTP_BAD_REQUEST);
    }
}
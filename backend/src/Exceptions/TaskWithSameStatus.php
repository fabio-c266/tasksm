<?php

namespace src\Exceptions;

use src\Core\Response;

class TaskWithSameStatus extends \Exception
{
    public function __construct()
    {
        parent::__construct('A tarefa não pode ter o mesmo estatos', Response::HTTP_BAD_REQUEST);
    }
}
<?php

namespace src\Core;

use Ramsey\Uuid\Uuid as libUUID;

class UUID
{
    public static function generate(): string
    {
        $uuid = libUUID::uuid4();
        return $uuid->toString();
    }
}
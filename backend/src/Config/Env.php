<?php

namespace src\Config;

use Dotenv\Dotenv;
use Exception;
use src\Core\Libs\SchemaValidations\Schema;
use src\Core\Libs\SchemaValidations\Validations;
use Throwable;

class Env
{
    public static function init()
    {
        $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
        $dotenv->load();

        $envSchema = [
            "DB_HOST" => ['string', 'required'],
            "DB_USER" => ['string', 'required'],
            "DB_PASSWORD" => ['string', 'optional'],
            "DB_NAME" => ['string', 'required'],
            "JWT_SECRET" => ['string', 'required', 'min:5']
        ];

        try {
            (new Schema())->validate(schema: $envSchema, data: $_ENV);
        } catch (Exception $execpt) {
          throw new Exception("Invalid environments variables because: \n\n{$execpt->getMessage()}");
        }
    }
}
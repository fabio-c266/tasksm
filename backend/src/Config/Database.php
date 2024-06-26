<?php

namespace src\Config;

use Exception;
use PDO;
use PDOException;

class Database
{
    private static $connection = null;

    public static function connect()
    {
        define('DB_HOST', $_ENV['DB_HOST']);
        define('DB_USER', $_ENV['DB_USER']);
        define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
        define('DB_NAME', $_ENV['DB_NAME']);

        try {
            $connection = new PDO("mysql:host=".DB_HOST.";"."dbname=".DB_NAME.";"."charset=utf8;", DB_USER, DB_PASSWORD);
            $connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

            self::$connection = $connection;
        } catch (PDOException $error) {
            throw new Exception("Failed to connect to the database because: {$error->getMessage()}");
        }
    }

    public static function query(string $queryContent)
    {
        try {
            $connection = self::$connection;
            $result = $connection->prepare($queryContent);

            if ($result->execute()) {
                $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
            }
        } catch (PDOException $error) {
            throw new Exception("Fail to execute query because: {$error->getMessage()}");
        }
    }
}
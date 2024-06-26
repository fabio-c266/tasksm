<?php

use src\Config\Database;
use src\Config\Env;
use src\Core\Request;
use src\Core\Response;

include_once __DIR__ . '/vendor/autoload.php';

if (!isset($_REQUEST)) return;

header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    Env::init(); 
    Database::connect();

    $request = new Request($_SERVER);
    $request->execute();
} catch (Throwable $th) {
    echo Response::json(["message" => "Ocorreu um erro durante a execução dessa requisição"], Response::HTTP_BAD_REQUEST);
}



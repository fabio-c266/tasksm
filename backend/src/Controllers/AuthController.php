<?php

namespace src\Controllers;

use Exception;
use src\Core\Libs\SchemaValidations\Schema;
use src\Core\Request;
use src\Core\Response;
use src\Exceptions\UnexpectedErrorException;
use src\Repositories\UserRepository;
use src\Services\AuthService;
use Throwable;

class AuthController 
{
    public function login(Request $request)
    {
        $bodySchema = [
            "email" => ["string", "required", "email"],
            "password" => ["string", "required", "min:6"]
        ];

        try {
            $body = (new Schema())->validate($bodySchema, $request->getBody());
            $responseData = (new AuthService(new UserRepository()))->login(data: $body);
    
            return Response::json($responseData, Response::HTTP_OK);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }
}
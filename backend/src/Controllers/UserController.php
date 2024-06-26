<?php

namespace src\Controllers;

use src\Core\Libs\SchemaValidations\Schema;
use src\Core\Request;
use src\Core\Response;
use src\Exceptions\UnexpectedErrorException;
use src\Repositories\UserRepository;
use src\Services\UserService;
use Throwable;

class UserController
{
    public function create(Request $request)
    {
        $bodySchema = [
            "name" => ["string", "required", "min:3"],
            "email" => ["string", "required", "email", "notexist:user"],
            "password" => ["string", "required", "min:6"],
        ];

        try {
            $body = (new Schema())->validate($bodySchema, $request->getBody());
            $responseData = (new UserService(new UserRepository()))->create(data: $body);

            return Response::json($responseData, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }
}

<?php

namespace src\Controllers;

use src\Core\Libs\SchemaValidations\Schema;
use src\Core\Request;
use src\Core\Response;
use src\Exceptions\UnexpectedErrorException;
use src\Repositories\TaskRepository;
use src\Services\TaskService;
use Throwable;

class TaskController
{
    public function create(Request $request)
    {
        $bodySchema = [
            "title" => ["string", "required", "min:3", "max:50"],
            "desc" => ["string", "optional", "min:3", "max:800"],
            "id_task_status" => ["int", "required", "exist:task_status"],
        ];

        try {
            $userId = $request->getJWT()->data->id_user;
            $body = (new Schema())->validate($bodySchema, $request->getBody());

            $responseData = (new TaskService(
                new TaskRepository()
            ))->create($userId, $body);

            return Response::json($responseData, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }

    public function get(Request $request)
    {
        $queryParamsSchema = [
            "id" => ["string", "required"],
        ];

        try {
            $userId = $request->getJWT()->data->id_user;
            $queryParamsData = (new Schema())->validate($queryParamsSchema, $request->getQueryParams());

            $responseData = (new TaskService(
                new TaskRepository()
            ))->get($userId, $queryParamsData['id']);

            return Response::json($responseData, Response::HTTP_OK);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $userId = $request->getJWT()->data->id_user;

            $responseData = (new TaskService(
                new TaskRepository()
            ))->getAllByUser($userId);

            return Response::json($responseData, Response::HTTP_OK);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }

    public function getAllStatus(Request $request)
    {
        try {
            $responseData = (new TaskService(
                new TaskRepository()
            ))->getAvailableStatus();

            return Response::json($responseData, Response::HTTP_OK);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }

    public function update(Request $request)
    {
        $bodySchema = [
            "id" => ["string", "required"],
            "title" => ["string", "optional", "min:3", "max:50"],
            "desc" => ["string", "optional", "min:3", "max:800"],
            "id_task_status" => ["int", "optional", "exist:task_status"]
        ];

        try {
            $userId = $request->getJWT()->data->id_user;
            $body = (new Schema())->validate($bodySchema, $request->getBody());
            $body["id_public"] = $body["id"];
            unset($body["id"]);

            $responseData = (new TaskService(
                new TaskRepository()
            ))->update($userId, $body);

            return Response::json($responseData, Response::HTTP_OK);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }

    public function delete(Request $request)
    {
        $queryParamsSchema = [
            "id" => ["string", "required"]
        ];

        try {
            $queryParamsData = (new Schema())->validate($queryParamsSchema, $request->getQueryParams());
            $userId = $request->getJWT()->data->id_user;

            $responseData = (new TaskService(
                new TaskRepository()
            ))->delete($userId, $queryParamsData['id']);

            return Response::json($responseData, Response::HTTP_OK);
        } catch (Throwable $th) {
            throw new UnexpectedErrorException($th->getMessage(), $th->getCode());
        }
    }
}

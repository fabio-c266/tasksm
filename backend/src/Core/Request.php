<?php

namespace src\Core;

use src\Exceptions\InvalidJWTToken;
use src\Exceptions\RouterNotFound;
use src\Helpers\StringHelper;

class Request
{
    private array $headers;
    private string $uri;
    private string $httpMethod;
    private array $body;
    private array $queryParams;
    private array $files;
    private mixed $JWT = null;

    public function __construct($server)
    {
        $uri = $server['REQUEST_URI'];

        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        $urlData = parse_url($uri);

        $this->uri = $urlData['path'];
        $this->httpMethod = $server['REQUEST_METHOD'];
        $this->headers = getallheaders();
        $this->body = json_decode(file_get_contents('php://input'), true) ?? [];
        $this->queryParams = StringHelper::getQueryParams($urlData['query'] ?? '');
        $this->files = $_FILES ?? [];
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHTTPMethod(): string
    {
        return $this->httpMethod;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setJWT($data): void
    {
        $this->JWT = $data;
    }

    public function getJWT(): \stdClass
    {
        return $this->JWT;
    }

    public function execute()
    {
        $route = Routes::get_route(
            $this->httpMethod,
            $this->uri
        );

        try {
            if (!$route) throw new RouterNotFound();

            if ($route->requireAuth) {
                $headers = $this->getHeaders();

                if (!isset($headers['Authorization'])) throw new InvalidJWTToken();

                $token = explode(' ', $headers['Authorization'])[1];
                $jwtData = JWT::get_data($token);

                if (!$jwtData) throw new InvalidJWTToken();

                $this->setJWT($jwtData);
            }

            echo File::executeClass($route->controllerName, $route->controllerMethod, $this);
        } catch (\Throwable $th) {
            echo Response::json(["message" => $th->getMessage()], $th->getCode());
        }
    }
}
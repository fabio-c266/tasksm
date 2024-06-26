<?php

namespace src\Services;

use Exception;
use src\Core\JWT;
use src\Core\Response;
use src\Exceptions\EmailOrPasswordInvalid;
use src\Repositories\UserRepository;

class AuthService
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @throws EmailOrPasswordInvalid
     */
    public function login(array $data): array
    {
        $user = $this->userRepository->findUserByEmail($data['email']);

        if (!$user) throw new EmailOrPasswordInvalid();

        $isValidPassword = password_verify($data['password'], $user['password_hashed']);

        if (!$isValidPassword) throw new EmailOrPasswordInvalid();

        $userData = [
            "id_user" => $user['id_user'],
            "id_public" => $user['id_public'],
            "email" => $user['email']
        ];

        return (["token" => JWT::generate($userData)]);
    }
}
<?php

namespace src\Services;

use src\Core\UUID;
use src\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function create($data): array
    {
        $passwordHashed = password_hash($data['password'], PASSWORD_BCRYPT, ["cost" => 6]);;
        $userData = [
            "id_public" => UUID::generate(),
            "name" => $data['name'],
            "email" => $data['email'],
            "password_hashed" => $passwordHashed
        ];

        $this->userRepository->create($userData);

        return [
            "id" => $data['id_public'],
            "name" => $data['name'],
            "email" => $data['email']
        ];
    }
}
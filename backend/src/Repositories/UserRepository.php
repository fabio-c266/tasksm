<?php

namespace src\Repositories;

use src\Config\Database;
use src\Core\Query;

class UserRepository
{
    private string $tableName = 'user';

    public function create(array $data): void
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->insert(columns: ['id_public', 'name', 'email', 'password_hashed'], data: $data)
            ->build();

        Database::query($queryContent);
    }

    public function findUserByEmail(string $email): array | null
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->select(['id_user', 'id_public', 'email', 'password_hashed'])
            ->where('email', $email)
            ->build();

        $user = Database::query($queryContent);
        return $user ? $user[0] : null;
    }

    public function findOne(string $idPublic): array | null
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->select(['id_user', 'id_public', 'name', 'email', 'created_at'])
            ->where('id_public', $idPublic)
            ->build();

        $user = Database::query($queryContent);
        return $user ? $user[0] : null;
    }

    public function findWhere(string $column, $value): array | null
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->select(['id_public'])
            ->where($column, $value)
            ->build();

        $data = Database::query($queryContent);
        return $data ? $data[0] : null;
    }
}

<?php

namespace src\Repositories;

use src\Config\Database;
use src\Core\Query;
use src\Helpers\ArrayHelper;

class TaskRepository
{
    private string $tableName = 'task';

    public function create(array $data): void
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->insert(columns: ['id_public', 'title', '`desc`', 'fk_task_status', 'fk_user'], data: $data)
            ->build();

        Database::query($queryContent);
    }

    public function findTaskWithSameTitle(string $title): array|null
    {
        $queryContent = (new Query($this->tableName))
            ->select(['title', 'fk_user'])
            ->where('title', $title)
            ->build();

        $task = Database::query($queryContent);

        return $task ? $task[0] : null;
    }

    public function findOne(string $idPublic): array|null
    {
        $queryContent = (new Query($this->tableName))
            ->select(['id_public', 'title', '`desc`', 'created_at', 'fk_user', 'fk_task_status'])
            ->where('id_public', $idPublic)
            ->build();

        $task = Database::query($queryContent);
        return $task ? $task[0] : null;
    }

    public function findOneByUser(string $userId, $taskIdPublic): array|null
    {
        $queryContent = "select t.id_public as 'id', t.title, t.desc, t.created_at, ts.id_task_status as 'status.id_task_status', ts.name as 'status.name' from task as t inner join task_status ts on ts.id_task_status = t.fk_task_status where t.id_public = '{$taskIdPublic}' and t.fk_user = {$userId}";

        $task = Database::query($queryContent);

        return $task ? ArrayHelper::formatData($task) : null;
    }

    public function findWhere(string $column, $value): array|null
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->select(['id_public'])
            ->where($column, $value)
            ->build();

        $data = Database::query($queryContent);
        return $data ? $data[0] : null;
    }

    public function findAllByUserId(int $userId): array
    {
        $queryContent = "select t.id_public as 'id', t.title, t.`desc`, t.created_at, ts_status.id_task_status as 'status.id', ts_status.name as 'status.name' from task as t inner join `task_status` ts_status on t.fk_task_status = ts_status.id_task_status where t.fk_user = {$userId}";

        return ArrayHelper::formatData(Database::query($queryContent));
    }

    public function findManyStatus(): array
    {
        $queryContent = (new Query('task_status'))
            ->select(['id_task_status', 'name'])
            ->build();

        return Database::query($queryContent);
    }

    public function update(string $idPublic, array $data): void
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->update($data)
            ->where('id_public', $idPublic)
            ->limit(1)
            ->build();

        Database::query($queryContent);
    }

    public function delete(string $idPubic)
    {
        $queryContent = (new Query(tableName: $this->tableName))
            ->delete()
            ->where('id_public', $idPubic)
            ->build();

        Database::query($queryContent);
    }
}

<?php

namespace src\Services;

use src\Core\UUID;
use src\Exceptions\TaskInvalidUpdateBody;
use src\Exceptions\TaskNotFound;
use src\Exceptions\TaskWithSameDescription;
use src\Exceptions\TaskWithSameStatus;
use src\Exceptions\TaskWithSameTitle;
use src\Repositories\TaskRepository;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $taskRepository
    )
    {
    }

    public function create($userId, $data): array
    {
        $task = $this->taskRepository->findTaskWithSameTitle($data['title']);

        if ($task && $task['fk_user'] == $userId) throw new TaskWithSameTitle();

        $data = [
            "id_public" => UUID::generate(),
            "title" => $data['title'],
            "desc" => $data['desc'] ?? null,
            "id_task_status" => $data['id_task_status'],
            "fk_user" => $userId,
        ];

        $this->taskRepository->create($data);

        return $data;
    }

    public function get($userId, $taskIdPubic): array
    {
        $task = $this->taskRepository->findOneByUser($userId, $taskIdPubic);

        if (!$task) throw new TaskNotFound();

        return $task[0];
    }

    public function getAllByUser($userId): array
    {
        return $this->taskRepository->findAllByUserId($userId);
    }

    public function getAvailableStatus(): array
    {
        return $this->taskRepository->findManyStatus();
    }

    public function update($userId, $data): array
    {
        $taskIdPublic = $data['id_public'];
        $newTitle = $data['title'] ?? null;
        $newDesc = $data['desc'] ?? null;
        $newTaskStatusId = $data['id_task_status'] ?? null;

        if (!$newTitle && !$newDesc && !$newTaskStatusId) throw new TaskInvalidUpdateBody();

        $task = $this->taskRepository->findOne($taskIdPublic);
        $newData = [];

        if ($newTitle) {
            $taskWithSameTitle = $this->taskRepository->findTaskWithSameTitle($newTitle);

            if ($taskWithSameTitle && $taskWithSameTitle['fk_user'] == $userId) throw new TaskWithSameTitle();
            $newData['title'] = $newTitle;
        }

        if ($newDesc) {
            if ($task['desc'] == $newDesc) throw new TaskWithSameDescription();
            $newData['desc'] = $newDesc;
        }

        if ($newTaskStatusId) {
            if ($task['fk_task_status'] == $newTaskStatusId) throw new TaskWithSameStatus();
            $newData['fk_task_status'] = $newTaskStatusId;
        }

        $this->taskRepository->update($taskIdPublic, $newData);
        return $this->get($userId, $taskIdPublic);
    }

    public function delete($userId, $taskIdPublic): array
    {
        $task = $this->get($userId, $taskIdPublic);
        $this->taskRepository->delete($taskIdPublic);

        return $task;
    }
}

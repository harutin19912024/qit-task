<?php

namespace app\Service;

use app\DTO\TaskDTO;
use app\DTO\TaskStatusDTO;
use app\Entity\Task;
use app\Entity\TaskStatus;
use app\Repository\TaskRepositoryInterface;
use app\Utils\UuidGenerator;
use DateTimeImmutable;
use Random\RandomException;

/**
 * Class TaskService
 */
class TaskService
{
    /**
     * @param TaskRepositoryInterface $repository
     */
    public function __construct(
        private readonly TaskRepositoryInterface $repository
    ) {}

    /**
     * @param TaskDTO $dto
     * @return Task
     * @throws RandomException
     */
    public function createTask(TaskDTO $dto): Task
    {
        $task = new Task(
            id: UuidGenerator::generateUuid(),
            title: $dto->title,
            description: $dto->description,
            status: TaskStatus::TODO,
            assigneeId: $dto->assigneeId,
            createdAt: new DateTimeImmutable()
        );

        $this->repository->save($task);

        return $task;
    }

    /**
     * @param TaskStatus|null $status
     * @param string|null $assigneeId
     * @return array
     */
    public function getAllTasks(?TaskStatus $status = null, ?string $assigneeId = null): array
    {
        return $this->repository->findAll($status, $assigneeId);
    }

    /**
     * @param TaskStatusDTO $dto
     * @return void
     */
    public function updateTaskStatus(TaskStatusDTO $dto): void
    {
        $task = $this->repository->findById($dto->id);

        if (!$task) {
            throw new \RuntimeException("Task not found.");
        }

        $task->updateStatus($dto->status);

        $this->repository->save($task);
    }

    /**
     * @param string $id
     * @param string $userId
     * @return void
     */
    public function assignTask(string $id, string $userId): void
    {
        $task = $this->repository->findById($id);

        if (!$task) {
            throw new \RuntimeException("Task not found.");
        }

        $task->assignToUser($userId);

        $this->repository->save($task);
    }

    /**
     * @param string $id
     * @return void
     */
    public function deleteTask(string $id): void
    {
        $this->repository->delete($id);
    }
}

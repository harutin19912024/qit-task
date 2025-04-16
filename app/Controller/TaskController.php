<?php

namespace app\Controller;

use app\DTO\TaskDTO;
use app\DTO\TaskStatusDTO;
use app\Entity\TaskStatus;
use app\Service\TaskService;

/**
 * Class TaskController
 */
class TaskController
{
    /**
     * @param TaskService $taskService
     */
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    /**
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        $dto = new TaskDTO(
            title: $request['title'],
            description: $request['description'],
            assigneeId: $request['assigneeId'] ?? null
        );

        $task = $this->taskService->createTask($dto);

        echo "Task created with ID: {$task->getId()}\n";
    }

    /**
     * @param array $queryParams
     * @return void
     */
    public function list(array $queryParams): void
    {
        $status = isset($queryParams['status']) ? TaskStatus::from($queryParams['status']) : null;
        $assigneeId = $queryParams['assigneeId'] ?? null;

        $tasks = $this->taskService->getAllTasks($status, $assigneeId);

        foreach ($tasks as $task) {
            echo "- [{$task->getStatus()->value}] {$task->getTitle()} (ID: {$task->getId()})\n";
        }
    }

    /**
     * @param array $request
     * @return void
     */
    public function updateStatus(array $request): void
    {
        $dto = new TaskStatusDTO(
            id: $request['id'],
            status: TaskStatus::from($request['status'])
        );

        $this->taskService->updateTaskStatus($dto);

        echo "Task status updated successfully.\n";
    }

    /**
     * @param array $request
     * @return void
     */
    public function assign(array $request): void
    {
        $this->taskService->assignTask(
            id: $request['id'],
            userId: $request['assigneeId']
        );

        echo "Task assigned to user {$request['assigneeId']}.\n";
    }
}

<?php

namespace app\Controller;

use app\DTO\TaskDTO;
use app\DTO\TaskStatusDTO;
use app\Entity\TaskStatus;
use app\Http\JsonResponse;
use app\Http\Request;
use app\Service\TaskService;
use app\Validator\Validator;

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
     * @param Request $request
     * @return void
     * @throws \Random\RandomException
     */
    public function create(Request $request): void
    {
        $data = $request->all();

        $validator = new Validator($data, [
            'title' => ['required'],
            'description' => ['required'],
            'assigneeId' => ['nullable', 'string'],
        ]);

        if (! $validator->passes()) {
            JsonResponse::error($validator->errors(), 422);
            return;
        }

        $dto = new TaskDTO(
            title: $data['title'],
            description: $data['description'],
            assigneeId: $data['assigneeId'] ?? null
        );

        $task = $this->taskService->createTask($dto);

        JsonResponse::success([
            'message' => 'Task created successfully',
            'task' => $task->toArray()
        ], 201);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function list(Request $request): void
    {
        $status = $request->query('status');
        $assigneeId = $request->query('assigneeId');

        $statusEnum = $status ? TaskStatus::from($status) : null;

        $tasks = $this->taskService->getAllTasks($statusEnum, $assigneeId);

        $response = array_map(fn($task) => $task->toArray(), $tasks);

        JsonResponse::success($response);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateStatus(Request $request): void
    {
        $data = $request->all();

        $validator = new Validator($data, [
            'id' => ['required'],
            'status' => ['required']
        ]);

        if (! $validator->passes()) {
            JsonResponse::error($validator->errors(), 422);
            return;
        }

        $dto = new TaskStatusDTO(
            id: $data['id'],
            status: TaskStatus::from($data['status'])
        );

        $this->taskService->updateTaskStatus($dto);

        JsonResponse::success(['message' => 'Task status updated']);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function assign(Request $request): void
    {
        $data = $request->all();

        $validator = new Validator($data, [
            'id' => ['required'],
            'assigneeId' => ['required']
        ]);

        if (! $validator->passes()) {
            JsonResponse::error($validator->errors(), 422);
            return;
        }

        $this->taskService->assignTask($data['id'], $data['assigneeId']);

        JsonResponse::success(['message' => 'Task assigned']);
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        if (empty($id)) {
            JsonResponse::error(['message' => 'Task ID is required']);
            return;
        }

        $this->taskService->deleteTask($id);

        JsonResponse::success(['message' => "Task with ID {$id} deleted"]);
    }
}

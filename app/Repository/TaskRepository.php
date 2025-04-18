<?php

namespace app\Repository;

use app\Entity\Task;
use app\Entity\TaskStatus;

class TaskRepository implements TaskRepositoryInterface
{
    /** @var Task[] */
    private array $tasks = [];
    private string $storageFile = __DIR__ . '/../../public/storage/tasks.json';

    public function __construct()
    {
        if (file_exists($this->storageFile)) {
            $tasks = json_decode(file_get_contents($this->storageFile), true);
            foreach ($tasks as $task) {
                $this->tasks[] = new Task(
                    id: $task['id'],
                    title: $task['title'],
                    description: $task['description'],
                    status: TaskStatus::from($task['status']),
                    assigneeId: $task['assigneeId'],
                    createdAt: new \DateTimeImmutable($task['createdAt'])
                );
            }
        }
    }

    /**
     * @param Task $task
     * @return void
     */
    public function save(Task $task): void
    {
        $this->tasks[] = $task;
        $this->persist();
    }

    /**
     * @param TaskStatus|null $status
     * @param string|null $assigneeId
     * @return array|Task[]
     */
    public function findAll(?TaskStatus $status = null, ?string $assigneeId = null): array
    {
        if ($status === null && $assigneeId === null) {
            return $this->tasks;
        }

        return array_filter($this->tasks, function (Task $task) use ($status, $assigneeId) {
            if ($status !== null && $task->getStatus() !== $status) {
                return false;
            }

            if ($assigneeId !== null && $task->getAssigneeId() !== $assigneeId) {
                return false;
            }

            return true;
        });
    }

    /**
     * @param string $id
     * @return Task|null
     */
    public function findById(string $id): ?Task
    {
        return $this->tasks[$id] ?? null;
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        $this->tasks = array_filter($this->tasks, fn(Task $task) => $task->getId() !== $id);
        $this->persist();
    }

    /**
     * @return void
     */
    private function persist(): void
    {
        file_put_contents(
            $this->storageFile,
            json_encode(array_map(fn($task) => $task->toArray(), $this->tasks), JSON_PRETTY_PRINT)
        );
    }
}

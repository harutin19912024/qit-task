<?php

namespace app\Repository;

use app\Entity\Task;
use app\Entity\TaskStatus;

class InMemoryTaskRepository implements TaskRepositoryInterface
{
    /** @var Task[] */
    private array $tasks = [];

    public function save(Task $task): void
    {
        $this->tasks[(string) $task->getId()] = $task;
    }

    public function findAll(?TaskStatus $status = null, ?string $assigneeId = null): array
    {
        return array_filter($this->tasks, function (Task $task) use ($status, $assigneeId) {
            if ($status && $task->getStatus() !== $status) {
                return false;
            }

            if ($assigneeId !== null && $task->getAssigneeId() !== $assigneeId) {
                return false;
            }

            return true;
        });
    }

    public function findById(string $id): ?Task
    {
        return $this->tasks[$id] ?? null;
    }
}

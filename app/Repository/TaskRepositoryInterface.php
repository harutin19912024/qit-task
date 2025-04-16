<?php

namespace app\Repository;

use app\Entity\Task;
use app\Entity\TaskStatus;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;

    public function findAll(?TaskStatus $status = null, ?string $assigneeId = null): array;

    public function findById(string $id): ?Task;
}

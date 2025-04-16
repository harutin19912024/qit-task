<?php

namespace app\DTO;

use app\Entity\TaskStatus;

class TaskStatusDTO
{
    /**
     * @param string $id
     * @param TaskStatus $status
     */
    public function __construct(
        public readonly string $id,
        public readonly TaskStatus $status
    ) {}
}

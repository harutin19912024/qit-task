<?php

namespace app\DTO;

/**
 * Class TaskDTO
 */
class TaskDTO
{
    /**
     * @param string $title
     * @param string $description
     * @param string|null $assigneeId
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $assigneeId = null
    ) {}
}

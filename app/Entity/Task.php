<?php

namespace app\Entity;

use DateTimeImmutable;

class Task
{
    /**
     * @param string $id
     * @param string $title
     * @param string $description
     * @param TaskStatus $status
     * @param string|null $assigneeId
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        private readonly string   $id,
        private string            $title,
        private string            $description,
        private TaskStatus        $status,
        private ?string           $assigneeId,
        private readonly DateTimeImmutable $createdAt
    ) {}

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return TaskStatus
     */
    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getAssigneeId(): ?string
    {
        return $this->assigneeId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param string $userId
     * @return void
     */
    public function assignToUser(string $userId): void
    {
        $this->assigneeId = $userId;
    }

    /**
     * @param TaskStatus $status
     * @return void
     */
    public function updateStatus(TaskStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'assigneeId' => $this->assigneeId,
            'createdAt' => $this->createdAt->format(\DateTimeInterface::ATOM),
        ];
    }
}

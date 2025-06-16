<?php

namespace App\DTOs\Task;

use App\Enums\TaskPriorityEnum;

class UpdateTaskDto
{
    public function __construct(
        private readonly int $taskId,
        private readonly string $title,
        private readonly string $date,
        private readonly TaskPriorityEnum $priority,
        private readonly ?string $description = null,
    ) {}


    public static function fromArray(array $data): self
    {
        return new self(
            taskId: $data['taskId'],
            title: $data['title'],
            date: $data['date'],
            priority: $data['priority'],
            description: $data['description'] ?? null,
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getPriority(): TaskPriorityEnum
    {
        return $this->priority;
    }
}

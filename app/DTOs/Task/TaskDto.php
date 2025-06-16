<?php

namespace App\DTOs\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Task;

class TaskDto
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly string $date,
        private readonly string $status = TaskStatusEnum::PENDING->value,
        private readonly ?string $priority,
        private readonly ?string $description,
        private readonly string $created_at,
    ) {}

    public static function fromModel(Task $task): self
    {
        return new self(
            id: $task->id,
            title: $task->title,
            status: TaskStatusEnum::from($task->status)->name,
            priority: TaskPriorityEnum::from($task->priority)->name,
            description: $task->description,
            date: $task->date,
            created_at: $task->created_at->toDateTimeString(),
        );
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
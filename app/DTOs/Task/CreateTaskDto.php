<?php

namespace App\DTOs\Task;

use App\Enums\TaskPriorityEnum;

class CreateTaskDto
{
    public function __construct(
        private readonly string $title,
        private readonly string $date,
        private readonly ?string $description = null,
        private readonly TaskPriorityEnum $priority
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            date: $data['date'],
            priority: TaskPriorityEnum::{$data['priority']},
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

    public function getPriority(): TaskPriorityEnum
    {
        return $this->priority;
    }
}

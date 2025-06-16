<?php

namespace App\DTOs\Task;

use App\Enums\TaskStatusEnum;

class UpdateTaskStatusDto
{
    public function __construct(
        private readonly int $taskId,
        private readonly TaskStatusEnum $status
    ) {}


    public static function fromArray(array $data): self
    {
        return new self(
            taskId: $data['taskId'],
            status: TaskStatusEnum::{$data['status']},
        );
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getStatus(): TaskStatusEnum
    {
        return $this->status;
    }
}

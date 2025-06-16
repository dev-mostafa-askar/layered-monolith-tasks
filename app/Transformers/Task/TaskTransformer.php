<?php

namespace App\Transformers\Task;

use App\DTOs\Task\TaskDto;
use Flugg\Responder\Transformers\Transformer;

class TaskTransformer extends Transformer
{
    /**
     * Transform the DTO.
     *
     * @param  \App\DTOs\Task\TaskDto $task
     * @return array
     */
    public function transform(TaskDto $task)
    {
        return [
            'id' => (int) $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'date' => $task->getDate(),
            'status' => $task->getStatus(),
            'priority' => $task->getPriority(),
            'created_at' => $task->getCreatedAt(),
        ];
    }
}

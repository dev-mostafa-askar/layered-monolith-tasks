<?php

namespace App\Repositories\Task\Eloquent;

use App\DTOs\Task\CreateTaskDto;
use App\DTOs\Task\ListTaskDto;
use App\DTOs\Task\TaskDto;
use App\DTOs\Task\UpdateTaskDto;
use App\DTOs\Task\UpdateTaskStatusDto;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Repositories\Task\TaskRepository;

class EloquentTaskRepository implements TaskRepository
{

    public function __construct(private Task $task) {}

    public function ListAllTasks(ListTaskDto $taskDto)
    {
        $query = $this->task->query()->where('user_id', auth()->id());

        if ($taskDto->getSearch()) {
            $query->fullTextSearch($taskDto->getSearch());
        }
        if ($taskDto->getStatus()) {
            $query->where('status', $taskDto->getStatus()->value);
        }

        if ($taskDto->getFromDate()) {
            $query->where('date', '>=', $taskDto->getFromDate());
        }

        if ($taskDto->getToDate()) {
            $query->where('date', '<=', $taskDto->getToDate());
        }

        if ($taskDto->getPriority()) {
            $query->where('priority', $taskDto->getPriority()->value);
        }

        $query->orderBy($taskDto->getSortedBy() ?? 'created_at', $taskDto->getOrderedBy() ?? 'desc');

        $tasks = $query->paginate($taskDto->getPerPage() ?? 10, [
            'id',
            'title',
            'date',
            'status',
            'priority',
            'created_at'
        ], 'page', $taskDto->page ?? 1);

        $tasks->getCollection()->transform(fn($task) => TaskDto::fromModel($task));

        return $tasks;
    }
    public function create(CreateTaskDto $taskDto)
    {
        $task = $this->task->create([
            'title' => $taskDto->getTitle(),
            'description' => $taskDto->getDescription(),
            'date' => $taskDto->getDate(),
            'status' => (int) TaskStatusEnum::PENDING->value,
            'priority' => $taskDto->getPriority()->value,
            'user_id' => auth()->id()
        ]);
        return TaskDto::fromModel($task);
    }
    public function update(UpdateTaskDto $taskDto)
    {
        $task = $this->task->findOrFail($taskDto->getTaskId());
        $task->update([
            'title' => $taskDto->getTitle(),
            'description' => $taskDto->getDescription(),
            'date' => $taskDto->getDate(),
            'priority' => $taskDto->getPriority()->value
        ]);

        return TaskDto::fromModel($task);
    }

    public function updateStatus(UpdateTaskStatusDto $taskDto)
    {
        $task = $this->task->findOrFail($taskDto->getTaskId());
        $task->update([
            'status' => $taskDto->getStatus()->value
        ]);
        return TaskDto::fromModel($task);
    }

    public function delete(int $taskId)
    {
        $task = $this->task->findOrFail($taskId);
        $task->delete();
        return true;
    }

    public function find(int $taskId)
    {
        $task = $this->task->findOrFail($taskId);
        return TaskDto::fromModel($task);
    }
}

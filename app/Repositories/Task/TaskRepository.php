<?php

namespace App\Repositories\Task;

use App\DTOs\Task\CreateTaskDto;
use App\DTOs\Task\ListTaskDto;
use App\DTOs\Task\TaskDto;
use App\DTOs\Task\UpdateTaskDto;
use App\DTOs\Task\UpdateTaskStatusDto;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepository
{
    public function ListAllTasks(ListTaskDto $taskDto): Collection;
    public function createTask(CreateTaskDto $taskDto);
    public function updateTask(UpdateTaskDto $taskDto);
    public function updateStatus(UpdateTaskStatusDto $taskDto);
    public function deleteTask(int $taskId): bool;
    public function findTask(int $taskId): TaskDto;
}

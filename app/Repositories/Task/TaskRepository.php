<?php

namespace App\Repositories\Task;

use App\DTOs\Task\CreateTaskDto;
use App\DTOs\Task\ListTaskDto;
use App\DTOs\Task\UpdateTaskDto;
use App\DTOs\Task\UpdateTaskStatusDto;

interface TaskRepository
{
    public function ListAllTasks(ListTaskDto $taskDto);
    public function create(CreateTaskDto $taskDto);
    public function update(UpdateTaskDto $taskDto);
    public function updateStatus(UpdateTaskStatusDto $taskDto);
    public function delete(int $taskId);
    public function find(int $taskId);
}

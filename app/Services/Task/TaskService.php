<?php

namespace App\Services\Task;

use App\DTOs\Task\CreateTaskDto;
use App\DTOs\Task\ListTaskDto;
use App\DTOs\Task\UpdateTaskDto;
use App\DTOs\Task\UpdateTaskStatusDto;
use App\Enums\TaskStatusEnum;
use App\Repositories\Task\TaskRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TaskService
{

    public function __construct(private TaskRepository $taskRepository) {}

    public function ListAllTasks(ListTaskDto $taskDto)
    {
        return $this->taskRepository->ListAllTasks($taskDto);
    }

    public function create(CreateTaskDto $createTaskDto)
    {
        return $this->taskRepository->create($createTaskDto);
    }

    public function update(UpdateTaskDto $updateTaskDto)
    {
        return $this->taskRepository->update($updateTaskDto);
    }

    public function updateStatus(UpdateTaskStatusDto $updateTaskStatusDto)
    {
        if ($updateTaskStatusDto->getStatus()->value === TaskStatusEnum::COMPLETED->value) {
            $task = $this->find($updateTaskStatusDto->getTaskId());
            if ($task->getStatus() != TaskStatusEnum::IN_PROGRESS->name) {
                throw new BadRequestHttpException("Task is not in progress");
            }
        }
        return $this->taskRepository->updateStatus($updateTaskStatusDto);
    }

    public function delete(int $taskId)
    {
        return $this->taskRepository->delete($taskId);
    }

    public function find(int $taskId)
    {
        return $this->taskRepository->find($taskId);
    }
}
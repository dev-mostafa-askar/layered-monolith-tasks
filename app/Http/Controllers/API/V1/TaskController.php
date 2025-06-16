<?php

namespace App\Http\Controllers\API\V1;

use App\DTOs\Task\CreateTaskDto;
use App\DTOs\Task\ListTaskDto;
use App\DTOs\Task\UpdateTaskDto;
use App\DTOs\Task\UpdateTaskStatusDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\ListTasksRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\UpdateTaskStatusRequest;
use App\Services\Task\TaskService;
use App\Transformers\Task\AbstractTaskTransformer;
use App\Transformers\Task\TaskTransformer;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function index(ListTasksRequest $request)
    {
        $listTaskDto = ListTaskDto::fromArray($request->validated());
        $listTaskDto = $this->taskService->ListAllTasks($listTaskDto);
        return responder()->success($listTaskDto, AbstractTaskTransformer::class)->respond(Response::HTTP_OK);
    }

    public function create(CreateTaskRequest $request)
    {
        $taskDto = CreateTaskDto::fromArray($request->validated());
        $taskDto = $this->taskService->create($taskDto);
        return responder()->success($taskDto, TaskTransformer::class)->respond(Response::HTTP_CREATED);
    }

    public function update(UpdateTaskRequest $request, int $taskId)
    {
        $taskDto = UpdateTaskDto::fromArray([...$request->validated(), 'taskId' => $taskId]);
        $taskDto = $this->taskService->update($taskDto);
        return responder()->success(['message' => 'Task updated successfully'])->respond(Response::HTTP_OK);
    }

    public function updateTaskStatus(UpdateTaskStatusRequest $request, int $taskId)
    {
        $taskDto = UpdateTaskStatusDto::fromArray([...$request->validated(), 'taskId' => $taskId]);
        $taskDto = $this->taskService->updateStatus($taskDto);
        return responder()->success(['message' => 'Task status updated successfully'])->respond(Response::HTTP_OK);
    }

    public function delete($taskId)
    {
        $this->taskService->delete($taskId);
        return responder()->success(['message' => 'Task deleted successfully'])->respond(Response::HTTP_OK);
    }
}
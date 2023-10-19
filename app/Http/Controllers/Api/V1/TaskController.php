<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\StoreTaskAction;
use App\Exceptions\ApiResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskFormRequest;
use App\Http\Requests\UpdateTaskFormRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\UpdateTaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * @throws ApiResponseException
     */
    public function store(CreateTaskFormRequest $request, StoreTaskAction $action): JsonResponse|TaskResource
    {
        return new TaskResource($action($request));
    }

    /**
     * @throws ApiResponseException
     */
    public function update(Task $task, UpdateTaskFormRequest $request, UpdateTaskService $service): TaskResource
    {
        $updatedTask = $service->saveUpdate($task, $request);
        $aggregate = $service->getAggregateParams($updatedTask);

        return (new TaskResource($task))->additional(['meta' => $aggregate]);
    }
}

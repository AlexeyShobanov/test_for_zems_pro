<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\TaskDTO;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreTaskAction
{
    /**
     * @throws ApiResponseException
     */
    public function __invoke($request)
    {
        $taskData = TaskDTO::fromRequest($request);
        $project = Project::query()->find($taskData->projectID);
        if (!$project) {
            return response()->json([
                'errors' => [
                    [
                        'code' => 422,
                        'title' => "Обращение к несуществующему проекту"
                    ]
                ]
            ]);
        }
        try {
            $task = $project->tasks()->create(["title" => $taskData->title]);
        } catch (Throwable $e) {
            throw new ApiResponseException('Ошибка создания записи проекта (' . $e->getMessage() . ').' );
        }

        return $task;
    }
}
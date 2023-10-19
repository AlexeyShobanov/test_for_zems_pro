<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiResponseException;
use Carbon\Carbon;
use Throwable;
use App\Models\Task;

final class UpdateTaskService
{
    /**
     * @throws ApiResponseException
     */
    public function saveUpdate(Task $task, $request): Task
    {
        try {
            if ($request->get('status') == 1) {
                $task->finish_time = Carbon::now();
            } else {
                $task->start_time = Carbon::now();
            }
            $task->save();
        } catch (Throwable $e) {
            throw new ApiResponseException('Ошибка обновления записи задачи (' . $e->getMessage() . ').' );
        }

        return $task;
    }

     public function getAggregateParams(Task $task)
     {
         return [
             'duration' => $task->duration,
             'finishTask' => is_null($task->finish_time) ? 0 : 1,
             'startTask' => is_null($task->start_time) && is_null($task->finish_time) ? 0 : 1
         ];
     }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $test = 0;
        if ($this->whenLoaded('tasks')) {
            $test = 1;
//            $agrDuration = $this->tasks->reduce(function ($agregate, $task) {
//                $agregate['agrDuration'] += $task->duration;
//                $agregate['finishTasks'] += is_null($task->finish_time) ? 0 : 1;
//                $agregate['startTasks'] += is_null($task->start_time) ? 0 : 1;
//                return $agregate;
//            }, [
//                'agrDuration' => 0,
//                'finishTasks' => 0,
//                'startTasks' => 0
//            ]);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->created_at->format("d.m.Y"),
            'task_count' =>  $this->whenCounted('tasks'),
//            'agrDuration' => $agrDuration,
//            'finishTasks' => $finishTasks,
//            'startTasks' => $startTasks,
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            'test' => $test

        ];
    }
}

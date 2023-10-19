<?php

declare(strict_types=1);

namespace App\Actions;

final class ShowProjectAction
{
    public function __invoke($project)
    {
        return $project->tasks->reduce(function ($aggregate, $task) {
            $aggregate['agrDuration'] += $task->duration;
            $aggregate['finishTasks'] += is_null($task->finish_time) ? 0 : 1;
            $aggregate['startTasks'] += is_null($task->start_time) ? 0 : 1;
            return $aggregate;
        }, [
            'agrDuration' => 0,
            'finishTasks' => 0,
            'startTasks' => 0
        ]);
    }
}
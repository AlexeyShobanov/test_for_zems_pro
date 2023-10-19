<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Http\Requests\CreateTaskFormRequest;
use App\Traits\Makeable;
use Illuminate\Http\Request;

final class TaskDTO
{
    use Makeable;

    public function __construct(
        public readonly string $title,
        public readonly string $projectID,
    ) {
    }


    public static function fromRequest(CreateTaskFormRequest $request): TaskDTO
    {
        $title = $request->get('title');
        $projectID = $request->get('project');

        return self::make($title, $projectID);
    }

}
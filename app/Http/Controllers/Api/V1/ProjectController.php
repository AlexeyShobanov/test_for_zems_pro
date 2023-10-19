<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ShowProjectAction;
use App\Exceptions\ApiResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectFormRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Throwable;

class ProjectController extends Controller
{
    public function index(): ProjectCollection
    {
        return new ProjectCollection(auth()->user()->projects()->withCount('tasks')->orderBy('id', 'desc')->paginate(10));
    }

    public function show(Project $project, ShowProjectAction $action): ProjectResource
    {
        $aggregate = $action($project);

        return (new ProjectResource($project->load('tasks')->loadCount('tasks')))
            ->additional(['meta' => $aggregate]);
    }

    /**
     * @throws ApiResponseException
     */
    public function store(ProjectFormRequest $request): ProjectResource
    {
        try {
            $project = auth()->user()->projects()->create(["title" => $request->get("title")]);
        } catch (Throwable $e) {
            throw new ApiResponseException('Ошибка создания записи проекта (' . $e->getMessage() . ').' );
        }

        return new ProjectResource($project);
    }

    /**
     * @throws ApiResponseException
     */
    public function update(Project $project, ProjectFormRequest $request): ProjectResource
    {
        try {
            $project->title = $request->get("title");
            $project->save();
        } catch (Throwable $e) {
            throw new ApiResponseException('Ошибка обновления записи проекта (' . $e->getMessage() . ').' );
        }

        return new ProjectResource($project);
    }
}

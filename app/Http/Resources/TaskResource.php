<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'project_id' => $this->project_id,
            'start_time' => $this->start_time?->format("d.m.Y H:i"),
            'finish_time' => $this->finish_time?->format("d.m.Y H:i"),
            'date' => $this->created_at->format("d.m.Y"),
            'duration' =>  $this->duration
        ];
    }
}

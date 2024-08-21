<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoadmapResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'roadmap-name' => $this->title,
            'roadmap-description' => $this->description,
            'roadmap-levels' => LevelResource::collection($this->level)
        ];
    }
}

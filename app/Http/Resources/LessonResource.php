<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lesson-id' => $this->id,
            'lesson-title' => $this->title,
            'lesson-url' => $this->url,
            'lesson-duration' => $this->duration
        ];
    }
}

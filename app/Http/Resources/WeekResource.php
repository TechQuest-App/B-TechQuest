<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'week-id' => $this->id,
            'week-number' => 'week ' . $this->number,
            'week-topics' => TopicResource::collection($this->topic),
            'week-courses' =>    ResourcesResource::collection($this->resources),
        ];
    }
}

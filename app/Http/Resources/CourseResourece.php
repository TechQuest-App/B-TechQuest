<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResourece extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course-id' => $this->id,
            'course-name' => $this->name,
            'course-image' => $this->image,
            'course-price' => $this->price,
            'course-rate' => $this->rate,
            'course-duration' => $this->length,
//            'category' => new CategoryResource($this->category), // entire object with our resource
//            'category' => $this-> category,    // object without resource
            'category' => $this-> category-> name,

        ];
    }
}

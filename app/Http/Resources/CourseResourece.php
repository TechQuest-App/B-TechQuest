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
            'course-mentor' => $this->mentor->f_name . ' ' . $this->mentor->l_name,
//            'category' => new CategoryResource($this->category), // entire object with our resource
//            'category' => $this-> category,    // object without resource
            'category' => $this-> category-> name,

        ];
    }
}

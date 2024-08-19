<?php

namespace App\Http\Resources;

use App\Models\Certificate_fullName;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // TODO: separate mentor form user
        return [
            //for mentor
            'certificate-id' => $this->id,
            'certificate-description' => $this->description,
            'course-name' => $this->course->name,
            'user-fullName' => Certificate_fullName::where('user_id', $request->user()->id)->first()->full_name,
            'course-mentor' => $this->course->mentor->f_name . " ". $this->course->mentor->l_name,
        ];
    }
}

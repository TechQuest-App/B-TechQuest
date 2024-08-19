<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'user-id' => $this->id,
            'first-name' => $this->f_name,
            'last-name' => $this->l_name,
            'email' => $this->email,
            'is-active' => $this->is_active,
            'image' => $this->pic,
            'phone-number' => $this->phone
        ];
    }

}

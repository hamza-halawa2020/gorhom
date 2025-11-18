<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
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
            'ip_address' => $this->ip_address,
            'count' => $this->count,
            'country' => $this->country,
            'city' => $this->city,
            'user_agent' => $this->user_agent,
            'created_at' => $this->created_at,
        ];
    }
}

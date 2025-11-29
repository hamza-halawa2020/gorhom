<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'review' => $this->review,
            'name' => $this->name,
            'rate' => $this->rate,
            'product' => $this->whenLoaded('product'),
        ];
    }
}

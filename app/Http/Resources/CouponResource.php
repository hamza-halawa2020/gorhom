<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'max_discount' => $this->max_discount,
            'min_order_amount' => $this->min_order_amount,
            'is_automatic' => $this->is_automatic,
            'automatic_type' => $this->automatic_type,
            'usage_limit' => $this->usage_limit,
            'usage_count' => $this->usage_count,
            'usage_per_user' => $this->usage_per_user,
            'is_active' => $this->is_active,
            'starts_at' => $this->starts_at,
            'expires_at' => $this->expires_at,
            'createdBy' => new UserResource($this->whenLoaded('createdBy')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

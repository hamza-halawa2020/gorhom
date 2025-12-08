<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = $request->get('lang', 'en');

        if ($locale === 'all') {
            return [
                'id' => $this->id,
                'title' => $this->getTranslations('title'),
                'slug' => $this->slug,
                'description' => $this->getTranslations('description'),
                'image' => $this->image,
                'price_before_discount' => $this->price_before_discount,
                'discount' => $this->discount,
                'price_after_discount' => $this->price_after_discount,
                'category' => new CategoryResource($this->whenLoaded('category')),
                'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
                'createdBy' => new UserResource($this->whenLoaded('createdBy')),
                'files' => FileResource::collection($this->whenLoaded('files')),
                'views' => ViewResource::collection($this->whenLoaded('views')),
                'created_at' => $this->created_at,
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'slug' => $this->slug,
            'description' => $this->getTranslation('description', $locale),
            'image' => $this->image,
            'price_before_discount' => $this->price_before_discount,
            'discount' => $this->discount,
            'price_after_discount' => $this->price_after_discount,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'createdBy' => new UserResource($this->whenLoaded('createdBy')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'views' => ViewResource::collection($this->whenLoaded('views')),
            'created_at' => $this->created_at,
        ];
    }
}

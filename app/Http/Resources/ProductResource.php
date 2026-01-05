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
                'category' => new CategoryResource($this->whenLoaded('category')),
                'sizes' => ProductSizeResource::collection($this->whenLoaded('sizes')),
                'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
                'createdBy' => new UserResource($this->whenLoaded('createdBy')),
                'files' => FileResource::collection($this->whenLoaded('files')),
                'views' => ViewResource::collection($this->whenLoaded('views')),
                'created_at' => $this->created_at,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'slug' => $this->slug,
            'description' => $this->getTranslation('description', $locale),
            'image' => $this->image,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'sizes' => ProductSizeResource::collection($this->whenLoaded('sizes')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'createdBy' => new UserResource($this->whenLoaded('createdBy')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'views' => ViewResource::collection($this->whenLoaded('views')),
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

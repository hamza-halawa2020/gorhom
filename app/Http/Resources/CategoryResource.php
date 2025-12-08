<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = $request->get('lang', 'en');

        if ($locale === 'all') {
            return [
                'id' => $this->id,
                'name' => $this->getTranslations('name'),
                'image' => $this->image,
                'children' => CategoryResource::collection($this->whenLoaded('children')),
                'products' => ProductResource::collection($this->whenLoaded('products')),

            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', $locale),
            'image' => $this->image,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'products' => ProductResource::collection($this->whenLoaded('products')),

        ];
    }
}

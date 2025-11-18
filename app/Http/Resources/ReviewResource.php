<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = $request->get('lang', 'en');

        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', $locale),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}

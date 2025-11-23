<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = $request->get('lang', 'en');

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'cities' => CityResource::collection($this->whenLoaded('cities')),
        ];
    }
}

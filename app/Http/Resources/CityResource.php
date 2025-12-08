<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = $request->get('lang', 'en');
       
        if ($locale === 'all') {

            return [
                'id' => $this->id,
                'title' => $this->getTranslations('title'),
                
                'country' => new CountryResource($this->whenLoaded('country')),
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'country' => new CountryResource($this->whenLoaded('country')),
        ];
    }
}

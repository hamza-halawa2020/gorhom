<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'nullable',
            'city_id' => 'nullable',
            'cost' => 'nullable',
        ];
    }
}

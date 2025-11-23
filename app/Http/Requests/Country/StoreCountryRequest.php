<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required',
            'city_id' => 'required',
            'cost' => 'required',
        ];
    }
}

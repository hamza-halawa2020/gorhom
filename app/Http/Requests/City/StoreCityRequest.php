<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
          return [
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];
    }
}

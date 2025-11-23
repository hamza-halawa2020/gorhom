<?php

namespace App\Http\Requests\Shipment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipmentRequest extends FormRequest
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

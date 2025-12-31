<?php

namespace App\Http\Requests\Client;

use App\Traits\BilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    use BilingualValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')->id;

        return [
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20|unique:clients,phone,' . $clientId,
            'email' => 'nullable|email|max:255',
        ];
    }

    protected function bilingualMessages(): array
    {
        return [
            'name.max' => [
                'ar' => 'الاسم يجب ألا يتجاوز 255 حرف',
                'en' => 'Name must not exceed 255 characters'
            ],
            'phone.unique' => [
                'ar' => 'رقم الهاتف مسجل بالفعل',
                'en' => 'Phone number is already registered'
            ],
            'email.email' => [
                'ar' => 'البريد الإلكتروني غير صحيح',
                'en' => 'Email format is invalid'
            ],
        ];
    }
}

<?php

namespace App\Http\Requests\Client;

use App\Traits\BilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    use BilingualValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:clients,phone',
            'email' => 'nullable|email|max:255',
        ];
    }

    protected function bilingualMessages(): array
    {
        return [
            'name.required' => [
                'ar' => 'الاسم مطلوب',
                'en' => 'Name is required'
            ],
            'name.max' => [
                'ar' => 'الاسم يجب ألا يتجاوز 255 حرف',
                'en' => 'Name must not exceed 255 characters'
            ],
            'phone.required' => [
                'ar' => 'رقم الهاتف مطلوب',
                'en' => 'Phone number is required'
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

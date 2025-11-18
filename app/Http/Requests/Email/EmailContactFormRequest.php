<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'passport' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'interest' => 'required|string|max:255',
            'investment_amount' => 'nullable|numeric|min:1000',
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Your email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'interest.required' => 'Please specify your area of interest.',
            'investment_amount.numeric' => 'Investment amount must be a number.',
            'investment_amount.min' => 'The minimum investment amount is $1,000.',
            'message.required' => 'Please enter your message so we can assist you better.',
        ];
    }
}

<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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

            'description' => 'required|array',
            'description.*' => 'required|string',

            'price_before_discount' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'price_after_discount' => 'required|numeric',

            'category_id' => 'required|integer|exists:categories,id',

            'image' => 'nullable|image|max:2048',
            'files.*' => 'nullable|image|max:2048',
        ];

    }
}

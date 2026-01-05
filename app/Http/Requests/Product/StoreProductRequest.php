<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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

            'category_id' => 'required|integer|exists:categories,id',

            'image' => 'nullable|image|max:2048',
            'files.*' => 'nullable|image|max:2048',

            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'required|string|max:255',
            'sizes.*.price_before_discount' => 'nullable|numeric|min:0',
            'sizes.*.discount' => 'nullable|numeric|min:0',
            'sizes.*.price_after_discount' => 'nullable|numeric|min:0',
            'sizes.*.stock' => 'required|integer|min:0',
        ];

    }
}

<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|array',
            'name.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
}

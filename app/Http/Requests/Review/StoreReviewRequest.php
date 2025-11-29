<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'review' => 'required|string',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:5',
            'product_id' => 'required|exists:products,id',
        ];
    }
}

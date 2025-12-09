<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $couponId = $this->route('coupon')->id;

        return [
            'code' => 'sometimes|string|max:255|unique:coupons,code,' . $couponId,
            'type' => 'sometimes|in:fixed,percentage',
            // 'value' => 'sometimes|numeric|min:0',
            'value' => [
                'sometimes',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->type === 'percentage' && $value > 100) {
                        $fail('The discount percentage cannot exceed 100%.');
                    }
                }
            ],

            'max_discount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'is_automatic' => 'nullable|boolean',
            'automatic_type' => 'nullable|string|in:first_order',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
        ];
    }

}

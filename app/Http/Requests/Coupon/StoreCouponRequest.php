<?php

namespace App\Http\Requests\Coupon;

use App\Traits\BilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    use BilingualValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
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

    protected function bilingualMessages(): array
    {
        return [
            'code.required' => [
                'ar' => 'كود الكوبون مطلوب',
                'en' => 'Coupon code is required'
            ],
            'code.unique' => [
                'ar' => 'كود الكوبون موجود بالفعل',
                'en' => 'Coupon code already exists'
            ],
            'type.required' => [
                'ar' => 'نوع الكوبون مطلوب',
                'en' => 'Coupon type is required'
            ],
            'type.in' => [
                'ar' => 'نوع الكوبون يجب أن يكون fixed أو percentage',
                'en' => 'Coupon type must be fixed or percentage'
            ],
            'value.required' => [
                'ar' => 'قيمة الخصم مطلوبة',
                'en' => 'Discount value is required'
            ],
            'expires_at.after' => [
                'ar' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية',
                'en' => 'Expiry date must be after start date'
            ],
        ];
    }
}
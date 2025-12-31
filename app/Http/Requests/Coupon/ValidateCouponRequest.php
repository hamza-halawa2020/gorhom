<?php

namespace App\Http\Requests\Coupon;

use App\Traits\BilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class ValidateCouponRequest extends FormRequest
{
    use BilingualValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|exists:coupons,code',
            'order_amount' => 'required|numeric|min:0',
            'client_id' => 'required|integer|exists:clients,id',
        ];
    }

    protected function bilingualMessages(): array
    {
        return [
            'code.required' => [
                'ar' => 'كود الكوبون مطلوب',
                'en' => 'Coupon code is required'
            ],
            'code.exists' => [
                'ar' => 'كود الكوبون غير صحيح',
                'en' => 'Invalid coupon code'
            ],
            'order_amount.required' => [
                'ar' => 'قيمة الطلب مطلوبة',
                'en' => 'Order amount is required'
            ],
            'client_id.required' => [
                'ar' => 'معرف العميل مطلوب',
                'en' => 'Client ID is required'
            ],
            'client_id.exists' => [
                'ar' => 'العميل غير موجود',
                'en' => 'Client not found'
            ],
        ];
    }
}
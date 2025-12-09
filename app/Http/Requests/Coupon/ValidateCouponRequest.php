<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCouponRequest extends FormRequest
{
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
}

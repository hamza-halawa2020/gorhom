<?php

namespace App\Http\Requests\Order;

use App\Traits\BilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    use BilingualValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,completed,cancelled',
        ];
    }

    protected function bilingualMessages(): array
    {
        return [
            'status.required' => [
                'ar' => 'حالة الطلب مطلوبة',
                'en' => 'Order status is required'
            ],
            'status.in' => [
                'ar' => 'حالة الطلب يجب أن تكون pending أو completed أو cancelled',
                'en' => 'Order status must be pending, completed, or cancelled'
            ],
        ];
    }
}
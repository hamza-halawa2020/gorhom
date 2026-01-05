<?php

namespace App\Http\Requests\Order;

use App\Traits\BilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    use BilingualValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'shipment_id' => 'required|integer|exists:shipments,id',
            'coupon_code' => 'nullable|string|exists:coupons,code',
            'payment_method' => 'required|in:cash_on_delivery,visa,vodafone_cash',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.product_size_id' => 'required|integer|exists:product_sizes,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    protected function bilingualMessages(): array
    {
        return [
            'name.required' => [
                'ar' => 'الاسم مطلوب',
                'en' => 'Name is required'
            ],
            'phone.required' => [
                'ar' => 'رقم الهاتف مطلوب',
                'en' => 'Phone number is required'
            ],
            'email.email' => [
                'ar' => 'البريد الإلكتروني غير صحيح',
                'en' => 'Email format is invalid'
            ],
            'address.required' => [
                'ar' => 'العنوان مطلوب',
                'en' => 'Address is required'
            ],
            'shipment_id.required' => [
                'ar' => 'طريقة الشحن مطلوبة',
                'en' => 'Shipping method is required'
            ],
            'shipment_id.exists' => [
                'ar' => 'طريقة الشحن غير موجودة',
                'en' => 'Shipping method not found'
            ],
            'coupon_code.exists' => [
                'ar' => 'كود الكوبون غير صحيح',
                'en' => 'Coupon code is invalid'
            ],
            'payment_method.required' => [
                'ar' => 'طريقة الدفع مطلوبة',
                'en' => 'Payment method is required'
            ],
            'payment_method.in' => [
                'ar' => 'طريقة الدفع غير صحيحة',
                'en' => 'Invalid payment method'
            ],
            'items.required' => [
                'ar' => 'يجب إضافة منتج واحد على الأقل',
                'en' => 'At least one item is required'
            ],
            'items.min' => [
                'ar' => 'يجب إضافة منتج واحد على الأقل',
                'en' => 'At least one item is required'
            ],
            'items.*.product_id.required' => [
                'ar' => 'معرف المنتج مطلوب',
                'en' => 'Product ID is required'
            ],
            'items.*.product_id.exists' => [
                'ar' => 'المنتج غير موجود',
                'en' => 'Product not found'
            ],
            'items.*.quantity.required' => [
                'ar' => 'الكمية مطلوبة',
                'en' => 'Quantity is required'
            ],
            'items.*.quantity.min' => [
                'ar' => 'الكمية يجب أن تكون 1 على الأقل',
                'en' => 'Quantity must be at least 1'
            ],
        ];
    }
}
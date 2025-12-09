<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'min_order_amount',
        'is_automatic',
        'automatic_type',
        'usage_limit',
        'usage_count',
        'usage_per_user',
        'is_active',
        'starts_at',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'is_automatic' => 'boolean',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_id');
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id');
    }

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function canBeUsedByClient($clientId)
    {
        if (!$this->usage_per_user) {
            return true;
        }

        $usageCount = $this->usages()->where('client_id', $clientId)->count();

        return $usageCount < $this->usage_per_user;
    }

    public function calculateDiscount($orderAmount)
    {
        if ($orderAmount < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $orderAmount);
        }

        $discount = ($orderAmount * $this->value) / 100;

        if ($this->max_discount) {
            return min($discount, $this->max_discount);
        }

        return $discount;
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}

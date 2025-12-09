<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'address',
        'client_id',
        'shipment_id',
        'coupon_id',
        'total_amount',
        'discount_amount',
        'final_amount',
        'status',
        'payment_method',
        'status_chnged_by',
    ];

    public function statusChngedBy()
    {
        return $this->belongsTo(User::class, 'status_chnged_by');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}

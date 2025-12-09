<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Http\Requests\Coupon\ValidateCouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class CouponController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
        $this->middleware('limitReq');
    }

    use ApiResponse;

    public function index()
    {
        $coupons = Coupon::with(['createdBy'])->get();

        return $this->success(CouponResource::collection($coupons));
    }

    public function store(StoreCouponRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        $coupon = Coupon::create($data);

        return $this->success(new CouponResource($coupon->load('createdBy')), 'Coupon created successfully', 201);
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['createdBy', 'usages']);

        return $this->success(new CouponResource($coupon));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $data = $request->validated();

        $coupon->update($data);

        return $this->success(new CouponResource($coupon->load('createdBy')), 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return $this->success(null, 'Coupon deleted successfully', 204);
    }

    public function validate(ValidateCouponRequest $request)
    {
        $data = $request->validated();

        $coupon = Coupon::where('code', $data['code'])->first();

        if (! $coupon->isValid()) {
            return $this->error('The coupon is invalid or has expired.', 400);
        }

        if (! $coupon->canBeUsedByClient($data['client_id'])) {
            return $this->error('You have used this coupon the maximum number of times.', 400);
        }

        $discount = $coupon->calculateDiscount($data['order_amount']);

        if ($discount == 0) {
            return $this->error('The order amount is less than the minimum required to use this coupon.', 400);
        }

        return $this->success([
            'coupon' => new CouponResource($coupon),
            'discount_amount' => $discount,
            'final_amount' => $data['order_amount'] - $discount,
        ], 'The coupon is valid for use.');
    }

    public function getAutomaticCoupon()
    {
        $clientId = request()->get('client_id');

        if (! $clientId) {
            return $this->error('Customer ID is required.', 400);
        }

        $client = \App\Models\Client::find($clientId);

        if (! $client) {
            return $this->error('Customer not found.', 404);
        }

        $hasOrders = \App\Models\Order::where('client_id', $clientId)
            ->where('status', 'completed')
            ->exists();

        if ($hasOrders) {
            return $this->error('No automatic coupon available.', 404);
        }

        $coupon = Coupon::where('is_automatic', true)
            ->where('automatic_type', 'first_order')
            ->where('is_active', true)
            ->first();

        if (! $coupon || ! $coupon->isValid()) {
            return $this->error('No automatic coupon available.', 404);
        }

        return $this->success(new CouponResource($coupon), 'An automatic coupon is available for the first order.');
    }
}

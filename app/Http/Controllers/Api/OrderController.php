<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderStatusRequest;
use App\Http\Resources\ClientResource;
use App\Http\Resources\OrderResource;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipment;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('index', 'show', 'updateStatus');
        $this->middleware('limitReq');
    }

    use ApiResponse;

    public function index()
    {
        $orders = Order::with(['client', 'shipment', 'coupon', 'items.product', 'statusChngedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->success(OrderResource::collection($orders));
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $client = Client::where('phone', $data['phone'])->first();

            if (! $client) {
                $client = Client::create([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'] ?? null,
                ]);
            } else {
                $client->update([
                    'name' => $data['name'],
                    'email' => $data['email'] ?? $client->email,
                ]);
            }

            $totalAmount = 0;
            $orderItems = [];

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->price_after_discount;
                $subtotal = $price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ];
            }

            $shipment = Shipment::findOrFail($data['shipment_id']);
            $productsTotal = $totalAmount;
            $totalAmount += $shipment->cost;

            $discountAmount = 0;
            $couponId = null;
            $coupon = null;

            if (! empty($data['coupon_code'])) {
                $coupon = Coupon::where('code', $data['coupon_code'])->first();

                if ($coupon && $coupon->isValid() && $coupon->canBeUsedByClient($client->id)) {
                    $discountAmount = $coupon->calculateDiscount($productsTotal);

                    if ($discountAmount > 0) {
                        $couponId = $coupon->id;
                    }
                }
            } else {
                $hasPreviousOrders = Order::where('client_id', $client->id)
                    ->exists();

                if (! $hasPreviousOrders) {
                    $automaticCoupon = Coupon::where('is_automatic', true)
                        ->where('automatic_type', 'first_order')
                        ->where('is_active', true)
                        ->first();

                    if ($automaticCoupon && $automaticCoupon->isValid()) {
                        $discountAmount = $automaticCoupon->calculateDiscount($productsTotal);

                        if ($discountAmount > 0) {
                            $couponId = $automaticCoupon->id;
                            $coupon = $automaticCoupon;
                        }
                    }
                }
            }

            $finalAmount = $totalAmount - $discountAmount;

            $order = Order::create([
                'address' => $data['address'],
                'client_id' => $client->id,
                'shipment_id' => $data['shipment_id'],
                'coupon_id' => $couponId,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
                'status' => 'pending',
                'payment_method' => $data['payment_method'],
                'status_chnged_by' => Auth::id() ?? null,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            if ($coupon && $discountAmount > 0) {
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'client_id' => $client->id,
                    'order_id' => $order->id,
                    'discount_amount' => $discountAmount,
                ]);

                $coupon->incrementUsage();
            }

            DB::commit();

            $order->load(['client', 'shipment', 'coupon', 'items.product']);

            return $this->success(new OrderResource($order), 'Order created successfully.', 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error('An error occurred while creating the order: '.$e->getMessage(), 500);
        }
    }

    public function show(Order $order)
    {
        $order->load(['client', 'shipment', 'coupon', 'items.product', 'statusChngedBy']);

        return $this->success(new OrderResource($order));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $data = $request->validated();

        $order->update([
            'status' => $data['status'],
            'status_chnged_by' => Auth::id(),
        ]);

        $order->load(['client', 'shipment', 'coupon', 'items.product', 'statusChngedBy']);

        return $this->success(new OrderResource($order), 'Order status updated successfully.');
    }

    public function getClientOrders($phone)
    {
        $client = Client::where('phone', $phone)->first();

        if (! $client) {
            return $this->error('Client not found.', 404);
        }

        $orders = Order::where('client_id', $client->id)
            ->with(['shipment', 'coupon', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->success([
            'client' => ClientResource::collection($client),
            'orders' => OrderResource::collection($orders),
        ]);
    }

    public function exportPendingOrders()
    {
        $orders = Order::where('status', 'pending')
            ->with(['client', 'shipment', 'coupon', 'items.product'])
            ->get();

        $fileName = 'pending_orders_'.now()->format('Y_m_d_H_i_s').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Order ID', 'Client Name', 'Phone', 'Total Amount', 'Discount', 'Final Amount', 'Status',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->client->name,
                    $order->client->phone,
                    number_format($order->total_amount, 2),
                    number_format($order->discount_amount, 2),
                    number_format($order->final_amount, 2),
                    $order->status,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ClientController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
        $this->middleware('limitReq');
    }

    use ApiResponse;

    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%'.$request->phone.'%');
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        $query->orderBy('created_at', 'desc');

        if ($request->has('with_orders')) {
            $query->with(['orders.items.product', 'orders.shipment', 'orders.coupon']);
        }

        $clients = $query->get();

        return $this->success(ClientResource::collection($clients));
    }

    public function store(StoreClientRequest $request)
    {
        $data = $request->validated();

        $client = Client::create($data);

        return $this->success(new ClientResource($client), 'Client created successfully.', 201);
    }

    public function show(Client $client)
    {
        $client->load(['orders.items.product', 'orders.shipment', 'orders.coupon']);

        return $this->success(new ClientResource($client));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $data = $request->validated();

        $client->update($data);

        return $this->success(new ClientResource($client), 'Client data updated successfully.');
    }

    public function destroy(Client $client)
    {
        if ($client->orders()->exists()) {
            return $this->error('The client cannot be deleted because they have existing orders.', 400);
        }

        $client->delete();

        return $this->success(null, 'Client deleted successfully.', 204);
    }

    public function getByPhone($phone)
    {
        $client = Client::where('phone', $phone)->first();

        if (! $client) {
            return $this->error('Client not found.', 404);
        }

        $client->load(['orders.items.product', 'orders.shipment', 'orders.coupon']);

        return $this->success(new ClientResource($client));
    }

    public function stats(Client $client)
    {
        $totalOrders = $client->orders()->count();
        $completedOrders = $client->orders()->where('status', 'completed')->count();
        $pendingOrders = $client->orders()->where('status', 'pending')->count();
        $cancelledOrders = $client->orders()->where('status', 'cancelled')->count();
        $totalSpent = $client->orders()->where('status', 'completed')->sum('final_amount');
        $totalDiscount = $client->orders()->where('status', 'completed')->sum('discount_amount');

        return $this->success([
            'client' => new ClientResource($client),
            'statistics' => [
                'total_orders' => $totalOrders,
                'completed_orders' => $completedOrders,
                'pending_orders' => $pendingOrders,
                'cancelled_orders' => $cancelledOrders,
                'total_spent' => $totalSpent,
                'total_discount' => $totalDiscount,
                'average_order_value' => $completedOrders > 0 ? $totalSpent / $completedOrders : 0,
            ],
        ]);
    }
}

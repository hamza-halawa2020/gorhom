<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Shipment\StoreShipmentRequest;
use App\Http\Requests\Shipment\UpdateShipmentRequest;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends BaseController
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
        $this->middleware('limitReq');
    }

    public function index()
    {
        $shipments = Shipment::with(['country','city'])->get();
        return $this->success(ShipmentResource::collection($shipments));
    }

    public function store(StoreShipmentRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        $shipment = Shipment::create($data);
        return $this->success(new ShipmentResource($shipment), 'Shipment created', 201);
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['country','city']);
        return $this->success(new ShipmentResource($shipment));
    }

    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        $data = $request->validated();
        $shipment->update($data);
        return $this->success(new ShipmentResource($shipment), 'Shipment updated');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return $this->success(null, 'Shipment deleted', 204);
    }
}

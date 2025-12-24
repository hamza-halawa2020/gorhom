<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class CityController extends BaseController
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
        $this->middleware('limitReq');
    }

    public function index()
    {
        $cities = City::with('country','shipment')->get();

        return $this->success(CityResource::collection($cities));
    }

    public function store(StoreCityRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        $city = City::create($data);

        return $this->success(new CityResource($city), 'City created', 201);
    }

    public function show(City $city)
    {
        $city->load('country','shipment');

        return $this->success(new CityResource($city));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $data = $request->validated();
        $city->update($data);

        return $this->success(new CityResource($city), 'City updated');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return $this->success(null, 'City deleted', 204);
    }
}

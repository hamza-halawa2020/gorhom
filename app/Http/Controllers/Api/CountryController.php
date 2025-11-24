<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class CountryController extends BaseController
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
        $this->middleware('limitReq');
    }

    public function index()
    {
        $countries = Country::with('cities')->get();

        return $this->success(CountryResource::collection($countries));
    }

    public function store(StoreCountryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        $country = Country::create($data);

        return $this->success(new CountryResource($country), 'Country created', 201);
    }

    public function show(Country $country)
    {
        $country->load('cities');

        return $this->success(new CountryResource($country));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->validated();
        $country->update($data);

        return $this->success(new CountryResource($country), 'Country updated');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return $this->success(null, 'Country deleted', 204);
    }
}

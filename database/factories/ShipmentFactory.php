<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition(): array
    {
        return [
            'country_id' => Country::query()->inRandomOrder()->value('id') ?? Country::factory()->create()->id,

            'city_id' => City::query()->inRandomOrder()->value('id') ?? City::factory()->create()->id,

            'cost' => $this->faker->numberBetween(50, 700),

            'created_by' => 1,
        ];
    }
}

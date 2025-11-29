<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = \App\Models\Review::class;

    public function definition()
    {
        return [
            'review' => $this->faker->sentence(),
            'name' => $this->faker->name(),
            'rate' => $this->faker->randomFloat(1, 1, 5),
            'product_id' => Product::factory(),
        ];
    }
}

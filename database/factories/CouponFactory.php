<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition()
    {
        return [
            'code' => strtoupper($this->faker->bothify('CPN###')),
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'value' => $this->faker->randomFloat(2, 5, 50),
            'max_discount' => $this->faker->optional()->randomFloat(2, 10, 100),
            'min_order_amount' => $this->faker->randomFloat(2, 50, 300),
            'is_automatic' => false,
            'automatic_type' => null,
            'usage_limit' => $this->faker->optional()->numberBetween(1, 20),
            'usage_count' => 0,
            'usage_per_user' => $this->faker->optional()->numberBetween(1, 5),
            'is_active' => true,
            'starts_at' => now()->subDays(5),
            'expires_at' => now()->addDays(30),
            'created_by' => 1,
        ];
    }

    public function firstOrder()
    {
        return $this->state([
            'is_automatic' => true,
            'automatic_type' => 'first_order',
            'type' => 'percentage',
            'value' => 20,
        ]);
    }
}

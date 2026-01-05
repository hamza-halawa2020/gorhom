<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Review;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ]);

        Category::factory()->count(10)->create();

        $parent = Category::factory()->create();

        Category::factory()->count(5)->withParent($parent->id)->create();

        Country::factory(1)->create()->each(function ($country) {
            City::factory(29)->create([
                'country_id' => $country->id,
            ]);
        });

        Shipment::factory()->count(40)->create();

        Coupon::factory()->count(2)->firstOrder()->create();
       
        Coupon::factory()->count(10)->create();

    }
}

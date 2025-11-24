<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    public function definition(): array
    {
        static $countries = [
            ['en' => 'Egypt',       'ar' => 'مصر'],
            // ['en' => 'United States', 'ar' => 'الولايات المتحدة'],
            // ['en' => 'Canada',      'ar' => 'كندا'],
            // ['en' => 'Germany',     'ar' => 'ألمانيا'],
            // ['en' => 'France',      'ar' => 'فرنسا'],
            // ['en' => 'Australia',   'ar' => 'أستراليا'],
            // ['en' => 'India',       'ar' => 'الهند'],
            // ['en' => 'Brazil',      'ar' => 'البرازيل'],
            // ['en' => 'China',       'ar' => 'الصين'],
            // ['en' => 'Japan',       'ar' => 'اليابان'],
        ];

        $country = $this->faker->unique()->randomElement($countries);

        return [
            'title' => json_encode($country),
            'created_by' => 1,
        ];
    }
}

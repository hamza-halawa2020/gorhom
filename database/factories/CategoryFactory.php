<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $names = [
            ['en' => 'Electronics',      'ar' => 'إلكترونيات'],
            ['en' => 'Cars',             'ar' => 'سيارات'],
            ['en' => 'Fashion',          'ar' => 'أزياء'],
            ['en' => 'Home Appliances',  'ar' => 'أجهزة منزلية'],
            ['en' => 'Sports',           'ar' => 'رياضة'],
            ['en' => 'Beauty',           'ar' => 'تجميل'],
            ['en' => 'Books',            'ar' => 'كتب'],
            ['en' => 'Furniture',        'ar' => 'أثاث'],
        ];

        return [
            'name' => $this->faker->randomElement($names),
            'parent_id' => null,
            'created_by' => 1,
        ];
    }

    /**
     * Create subcategory
     */
    public function withParent($parentId)
    {
        return $this->state(function () use ($parentId) {
            return [
                'parent_id' => $parentId,
            ];
        });
    }
}

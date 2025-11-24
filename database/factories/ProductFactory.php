<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $titles = [
            ['en' => 'Engine Oil',          'ar' => 'زيت موتور'],
            ['en' => 'Brake Pads',          'ar' => 'تيل فرامل'],
            ['en' => 'Truck Tire',          'ar' => 'كاوتش شاحنات'],
            ['en' => 'Gearbox Filter',      'ar' => 'فلتر فتيس'],
            ['en' => 'Fuel Pump',           'ar' => 'طلمبة بنزين'],
            ['en' => 'Steering Wheel',      'ar' => 'طارة عجلة قيادة'],
            ['en' => 'Cooling Radiator',    'ar' => 'ريداتير'],
            ['en' => 'Air Filter',          'ar' => 'فلتر هواء'],
        ];

        $title = $this->faker->randomElement($titles);

        $priceBefore = $this->faker->numberBetween(100, 2000);
        $discount = $this->faker->randomElement([0, 5, 10, 15, 20]);
        $priceAfter = $priceBefore - $discount;

        return [
            'title' => $title,

            'slug' => Str::slug($title['en']).'-'.$this->faker->unique()->numberBetween(1, 9999),

            'description' => [
                'en' => $this->faker->sentence(10),
                'ar' => 'وصف للمنتج بشكل عشوائي لاختبار قاعدة البيانات',
            ],

            'image' => null,

            'price_before_discount' => $priceBefore,
            'discount' => $discount,
            'price_after_discount' => $priceAfter,

            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory()->create()->id,

            'created_by' => 1,
        ];
    }
}

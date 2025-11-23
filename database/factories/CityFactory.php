<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    public function definition(): array
    {
        static $egyptianCities = [
            ['en' => 'Cairo',              'ar' => 'القاهرة'],
            ['en' => 'Alexandria',         'ar' => 'الإسكندرية'],
            ['en' => 'Giza',               'ar' => 'الجيزة'],
            ['en' => 'Shubra El-Kheima',   'ar' => 'شبرا الخيمة'],
            ['en' => 'Port Said',          'ar' => 'بورسعيد'],
            ['en' => 'Suez',               'ar' => 'السويس'],
            ['en' => 'El Mahalla El Kubra', 'ar' => 'المحلة الكبرى'],
            ['en' => 'Luxor',              'ar' => 'الأقصر'],
            ['en' => 'Mansoura',           'ar' => 'المنصورة'],
            ['en' => 'Tanta',              'ar' => 'طنطا'],
            ['en' => 'Asyut',              'ar' => 'أسيوط'],
            ['en' => 'Ismailia',           'ar' => 'الإسماعيلية'],
            ['en' => 'Faiyum',             'ar' => 'الفيوم'],
            ['en' => 'Zagazig',            'ar' => 'الزقازيق'],
            ['en' => 'Damietta',            'ar' => 'دمياط'],
            ['en' => 'Aswan',              'ar' => 'أسوان'],
            ['en' => 'Minya',              'ar' => 'المنيا'],
            ['en' => 'Damanhur',           'ar' => 'دمنهور'],
            ['en' => 'Beni Suef',          'ar' => 'بني سويف'],
            ['en' => 'Qena',               'ar' => 'قنا'],
            ['en' => 'Sohag',              'ar' => 'سوهاج'],
            ['en' => 'Hurghada',           'ar' => 'الغردقة'],
            ['en' => '6th of October City', 'ar' => 'مدينة 6 أكتوبر'],
            ['en' => 'Sharm El Sheikh',    'ar' => 'شرم الشيخ'],
            ['en' => 'Banha',              'ar' => 'بنها'],
            ['en' => 'Arish',              'ar' => 'العريش'],
            ['en' => '10th of Ramadan City', 'ar' => 'مدينة 10 رمضان'],
            ['en' => 'Marsa Matruh',       'ar' => 'مرسى مطروح'],
            ['en' => 'Al Khankah',         'ar' => 'الخانكة'],
        ];

        $city = $this->faker->unique()->randomElement($egyptianCities);

        return [
            'title' => json_encode($city),
            'country_id' => 1, 
        ];
    }
}

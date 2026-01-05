<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price_before_discount', 'discount', 'price_after_discount']);
        });

        Schema::table('product_sizes', function (Blueprint $table) {
            $table->decimal('price_before_discount', 10, 2)->default(0)->after('stock');
            $table->decimal('discount', 10, 2)->default(0)->after('price_before_discount');
            $table->decimal('price_after_discount', 10, 2)->default(0)->after('discount');
        });
    }


    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_before_discount', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('price_after_discount', 10, 2)->default(0);
        });

        Schema::table('product_sizes', function (Blueprint $table) {
            $table->dropColumn(['price_before_discount', 'discount', 'price_after_discount']);
        });
    }
};

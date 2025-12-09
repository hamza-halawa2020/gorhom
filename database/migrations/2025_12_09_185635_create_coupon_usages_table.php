<?php

use App\Models\Client;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Coupon::class, 'coupon_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(Client::class, 'client_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(Order::class, 'order_id')->constrained()->onDelete('cascade');
            $table->decimal('discount_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};

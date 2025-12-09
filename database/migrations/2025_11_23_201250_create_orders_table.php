<?php

use App\Models\Client;
use App\Models\Coupon;
use App\Models\Shipment;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->foreignIdFor(Shipment::class, 'shipment_id');
            $table->foreignIdFor(Coupon::class, 'coupon_id')->nullable();
            $table->foreignIdFor(Client::class, 'client_id');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->foreignIdFor(User::class, 'status_chnged_by');
            $table->enum('payment_method', ['cash_on_delivery', 'visa', 'vodafone_cash'])->default('cash_on_delivery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'canceled'])->default('pending');
            $table->foreignId('coupon_id')->nullable()->onDelete('set null'); // Link to coupons
            $table->decimal('discount_applied', 8, 2)->default(0); // Store applied discount
            $table->string('delivery_address'); // New: Store delivery address
            $table->string('phone_number'); // New: Store user’s phone number for contact
            $table->enum('payment_method', ['credit_card', 'cash_on_delivery', 'bank_transfer'])->default('cash_on_delivery'); // New: Store payment method
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

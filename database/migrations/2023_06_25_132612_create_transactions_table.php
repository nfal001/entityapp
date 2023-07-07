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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('cart_id');
            $table->string('payment_proof')->nullable();
            $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('total_price')->default(0);
            $table->enum('order_status',['Pending','Delivering','Delivered'])->default('Pending');
            $table->enum('order_status_message',['Preparing Order','Delivering Your Order','Order Delivered'])->default('Preparing Order');
            $table->enum('payment_status',['unpaid','paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

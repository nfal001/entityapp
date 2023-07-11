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
        // $table->timestamps();
        Schema::create('transaction_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('message');
        });

        // ['Pending','Delivering','Delivered']
        // ['Preparing Order','Delivering Your Order','Order Delivered']
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_statuses');
    }
};

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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('payment_provider_id')->constrained()->nullOnDelete();
            $table->foreignUuid('user_id')->constrained()->nullOnDelete();
            $table->foreignUuid('transaction_id')->constrained()->nullOnDelete();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('payment_provider_id');
        });
    }
};

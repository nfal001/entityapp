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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_info_id')->constrained()->cascadeOnDelete();
            $table->string('addr_name')->default("default");
            $table->text('address_full');
            $table->string('address_lat_long')->nullable();
            $table->string('postal_code');
            $table->string('receiver_name');
            $table->string('phone');
            $table->string('country')->nullable(); //draft
            $table->float('latitude')->nullable(); 
            $table->float('longitude')->nullable(); 
            $table->foreignId('district_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->foreignId('province_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_choosen_address')->default(false);
            $table->text('address_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};

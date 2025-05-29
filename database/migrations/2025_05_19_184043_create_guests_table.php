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
        Schema::create('guest', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('fullname');
            $table->string('address');
            $table->string('reason');
            $table->string('destination');
            $table->string('checkin');
            $table->string('checkout')->nullable();
            $table->string('whatsapp');
            $table->enum('status', ['Masuk', 'Keluar'])->default('Masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest');
    }
};

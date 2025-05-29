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
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->string('user_token')->unique()->nullable();
            $table->string('nik')->unique();
            $table->string('whatsapp')->unique();
            $table->string('kepala_keluarga')->nullable();
            $table->string('fullname');
            $table->string('address');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->default('Laki-laki');
            $table->enum('role', ['RT', 'Satpam', 'Warga'])->default('Warga');
            $table->enum('status_account', ['Pending', 'Active', 'Inactive'])->default('Pending');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};

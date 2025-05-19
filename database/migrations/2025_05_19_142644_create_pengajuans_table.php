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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('user_token');
            $table->enum('kategori', ['Pengaduan', 'Permohonan'])->default('Pengaduan');
            $table->string('judul');
            $table->longText('deskripsi')->nullable();
            $table->string('file')->nullable();
            $table->longText('reply')->nullable();
            $table->enum('status', ['Menunggu', 'Dilihat', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};

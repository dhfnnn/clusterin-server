<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = ['Pengaduan', 'Permohonan'];
        $statuses = ['Menunggu', 'Dilihat', 'Disetujui', 'Ditolak'];
        $judulPengaduan = [
            'Permohonan Informasi Publik',
            'Pengaduan Pelayanan Publik',
            'Permohonan Dokumen',
            'Pengaduan Fasilitas Umum',
            'Permohonan Izin',
            'Pengaduan Kebersihan',
            'Permohonan Surat Keterangan',
            'Pengaduan Jalan Rusak',
            'Permohonan Rekomendasi',
            'Pengaduan Pungutan Liar'
        ];

        for ($i = 0; $i < 10; $i++) {
            $randomKategori = $kategori[array_rand($kategori)];
            $randomStatus = $statuses[array_rand($statuses)];
            
            DB::table('pengajuan')->insert([
                'user_token' => Str::random(32), // Token acak 32 karakter
                'kategori' => $randomKategori,
                'judul' => $judulPengaduan[$i],
                'deskripsi' => 'Ini adalah deskripsi untuk ' . $judulPengaduan[$i] . '. Deskripsi ini berisi detail lengkap mengenai permohonan atau pengaduan yang diajukan.',
                'file' => $i % 3 === 0 ? 'document_' . ($i + 1) . '.pdf' : null, // 1/3 data memiliki file
                'reply' => $randomStatus !== 'Menunggu' ? 'Terima kasih atas pengajuan Anda. Status: ' . $randomStatus : null,
                'status' => $randomStatus,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 29)),
            ]);
        }
    }
}

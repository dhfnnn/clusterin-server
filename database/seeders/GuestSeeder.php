<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('guest')->insert([
                'fullname' => 'Tamu ' . $i,
                'destination_address' => 'Blok ' . chr(64 + $i) . ' No. ' . rand(1, 100),
                'reason' => 'Keperluan ' . $i,
                'checkin_date' => now()->subDays(rand(0, 5))->format('Y-m-d'),
                'checkout_date' => now()->addDays(rand(0, 3))->format('Y-m-d'),
                'status' => rand(0, 1) ? 'Masuk' : 'Keluar',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

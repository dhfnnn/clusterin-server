<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'user_token' => Str::random(32),
                'nik' => '3273010101010001',
                'whatsapp' => '6281111111111',
                'fullname' => 'Budi Santoso',
                'address' => 'Jl. Melati No. 10, RT 01/RW 05',
                'role' => 'RT',
                'status_account' => 'Active',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_token' => Str::random(32),
                'nik' => '3273010202020002',
                'whatsapp' => '6281222222222',
                'fullname' => 'Ani Wijaya',
                'address' => 'Jl. Anggrek No. 15, RT 01/RW 05',
                'role' => 'Warga',
                'status_account' => 'Active',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_token' => Str::random(32),
                'nik' => '3273010303030003',
                'whatsapp' => '6281333333333',
                'fullname' => 'Joko Prasetyo',
                'address' => 'Jl. Mawar No. 20, RT 02/RW 05',
                'role' => 'Satpam',
                'status_account' => 'Active',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_token' => Str::random(32),
                'nik' => '3273010404040004',
                'whatsapp' => '6281444444444',
                'fullname' => 'Siti Rahayu',
                'address' => 'Jl. Kenanga No. 5, RT 02/RW 05',
                'role' => 'Warga',
                'status_account' => 'Pending',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_token' => Str::random(32),
                'nik' => '3273010505050005',
                'whatsapp' => '6281555555555',
                'fullname' => 'Rudi Hermawan',
                'address' => 'Jl. Flamboyan No. 12, RT 03/RW 05',
                'role' => 'Warga',
                'status_account' => 'Inactive',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('account')->insert($accounts);
    }
}

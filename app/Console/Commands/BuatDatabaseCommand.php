<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BuatDatabaseCommand extends Command
{
    protected $signature = 'buat:db {username} {password} {database}';
    protected $description = 'Okayy, Lagi proses validasi database baru sekalian update .env kamu yaa...';

    public function handle()
    {
        $username = $this->argument('username');
        $password = $this->argument('password');
        $database = $this->argument('database');

        // 1. Membuat database
        $this->info("\n\n> Lagi bikin database {$database}...");
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS {$database}");
            $this->info("  Database {$database} udah dibikin nih");
        } catch (\Exception $e) {
            $this->error("  Yahh.. bikin database {$database} gagal: " . $e->getMessage());
            return;
        }

        // 2. Update file .env
        $this->info("> Lagi update file .env...");
        try {
            $envPath = base_path('.env');
            $envContent = File::get($envPath);
            
            // Update konfigurasi database
            $envContent = preg_replace(
                '/DB_DATABASE=(.*)/', 
                'DB_DATABASE='.$database, 
                $envContent
            );
            $envContent = preg_replace(
                '/DB_USERNAME=(.*)/', 
                'DB_USERNAME='.$username, 
                $envContent
            );
            $envContent = preg_replace(
                '/DB_PASSWORD=(.*)/', 
                'DB_PASSWORD='.$password, 
                $envContent
            );
            
            File::put($envPath, $envContent);
            $this->info("  File .env udah diupdate nih\n");
        } catch (\Exception $e) {
            $this->error("  Yahh.. Gagal update .env: " . $e->getMessage());
            return;
        }

        // 3. Tawarkan untuk migrate
        if ($this->confirm('Mau sekalian migrate?')) {
            $this->info("Lagi proses migrate sebentar yaa...");
            try {
                $this->call('migrate');
                $this->info("✅ Migrate udah selesai");
            } catch (\Exception $e) {
                $this->error("❌ Gagal migrate: " . $e->getMessage());
            }
        }

        $this->info("Horayyy, Proses selesai!. Have fun yaa jangan dibawa pusing. Baii baii");
    }
}
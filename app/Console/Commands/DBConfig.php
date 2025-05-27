<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use PDO;
use PDOException;

class DBConfig extends Command
{
    protected $signature = 'db';
    protected $description = 'Update DB credentials in .env and create the database if it does not exist';
    public $requiresConnection = false;

    public function handle()
    {
        $dbHost = $this->ask('Database Host', 'localhost');
        $dbPort = $this->ask('Database Port', '3306');
        $dbUser = $this->ask('Database username', 'root');
        $dbPass = $this->ask('Database password', '');
        $dbName = $this->ask('Database Name');

        $this->updateEnv([
            'DB_HOST' => $dbHost,
            'DB_PORT' => $dbPort,
            'DB_DATABASE' => $dbName,
            'DB_USERNAME' => $dbUser,
            'DB_PASSWORD' => $dbPass,
        ]);

        if ($this->createDatabaseIfNotExists($dbHost, $dbPort, $dbName, $dbUser, $dbPass)) {
            $this->info(" Konfigurasi Database Berhasil.");
        } else {
            $this->error(" Koneksi ke Database gagal.");
        }

        $this->info(' File .env berhasil diperbarui.');
        $this->info(' Jangan lupa jalanin nanti yaa: php ccn migrate');
    }

    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        $envContent = File::exists($envPath) ? File::get($envPath) : '';

        foreach ($data as $key => $value) {
            $pattern = "/^$key=.*/m";
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "$key=\"$value\"", $envContent);
            } else {
                $envContent .= "\n$key=\"$value\"";
            }
        }

        File::put($envPath, $envContent);
    }

    protected function createDatabaseIfNotExists($host, $port, $dbName, $username, $password)
    {
        try {
            $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
            return true;
        } catch (PDOException $e) {
            $this->error("PDO Error: " . $e->getMessage());
            return false;
        }
    }
}

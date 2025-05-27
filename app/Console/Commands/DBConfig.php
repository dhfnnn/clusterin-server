<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DBConfig extends Command
{
    protected $signature = 'db';
    protected $description = 'Update DB credentials in .env file';

    public function handle()
    {
        $dbName = $this->ask('Enter database name (DB_DATABASE)');
        $dbUser = $this->ask('Enter database username (DB_USERNAME)');
        $dbPass = $this->secret('Enter database password (DB_PASSWORD)');

        $this->updateEnv([
            'DB_DATABASE' => $dbName,
            'DB_USERNAME' => $dbUser,
            'DB_PASSWORD' => $dbPass,
        ]);

        $this->info('.env file updated successfully.');
    }

    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

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
}

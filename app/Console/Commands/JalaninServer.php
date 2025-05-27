<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class JalaninServer extends Command
{
    protected $signature = 'jalanin';
    protected $description = 'Menjalankan server Laravel dengan IP dan PORT otomatis';

    public function handle()
    {
        $askip = $this->ask('Pilih IP Otomatis? [y/n]');
        if($askip == 'y' || $askip == 'Y') {
            $ipResult = $this->getWirelessIP();
            if ($ipResult == '127.0.0.1') {
                $this->warn(' Gagal ambilin IP dari wifi, Coba cek wifi kamu. Pakai default: 127.0.0.1');
            } 
            else {
                $ip = $ipResult;
            }
        } 
        else {
            $ip = $this->ask('Masukin IP');
        }
        $askport = $this->ask('Pilih PORT Otomatis? [y/n]');
        if($askport == 'y' || $askport == 'Y') {
            $port = random_int(8000, 8999);
        }
        else{
            $port = $this->ask('Masukin PORT');
        }

        $open = $this->ask('Mau sekalian bukain website-nya? [y/n]');
            if($open == 'y' || $open == 'Y') {
                $this->openInBrowser("http://$ip:$port");
            }
            else{
                echo "";
            }
        shell_exec("php ccn serve --host=$ip --port=$port");
    }

    protected function getWirelessIP()
    {
        $output = null;
        $os = PHP_OS_FAMILY;

        if ($os === 'Windows') {
            $output = shell_exec('ipconfig');
            if (preg_match('/Wireless LAN adapter Wi-Fi[\s\S]+?IPv4 Address[.\s]+:\s+([0-9.]+)/', $output, $matches)) {
                return $matches[1];
            }
        } elseif ($os === 'Linux' || $os === 'Darwin') {
            $output = shell_exec('ifconfig');
            if (preg_match('/wlan0.*?inet\s+([0-9.]+)/s', $output, $matches)) {
                return $matches[1];
            }
        }

        return "127.0.0.1";
    }

    protected function openInBrowser($url)
    {
        if (PHP_OS_FAMILY === 'Windows') {
            exec("start $url");
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            exec("open $url");
        } else {
            exec("xdg-open $url");
        }
    }
}

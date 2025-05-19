<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $filalable = ['user_token', 'kategori', 'judul', 'deskripsi', 'file', 'reply', 'status'];
}

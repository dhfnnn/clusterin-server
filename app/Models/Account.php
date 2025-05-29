<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'account';
    protected $hidden = [
        'password',
    ];
    protected $fillable = [
        'user_token', 
        'nik', 
        'whatsapp', 
        'fullname', 
        'address', 
        'role', 
        'gender', 
        'kepala_keluarga',
        'status_account'
    ];
}

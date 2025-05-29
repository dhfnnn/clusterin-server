<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $table = 'guest';
    protected $fillable = ['nik', 'fullname', 'address', 'destination', 'reason', 'checkin', 'checkout', 'whatsapp', 'status'];
}

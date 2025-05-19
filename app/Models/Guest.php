<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $table = 'guest';
    protected $fillable = ['fullname', 'destination_address', 'reason', 'checkin_date', 'checkout_date', 'status'];
}

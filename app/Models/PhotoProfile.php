<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoProfile extends Model
{
    use HasFactory;
    protected $table = 'photo_profiles';
    protected $fillable = ['user_token','photo'];
}

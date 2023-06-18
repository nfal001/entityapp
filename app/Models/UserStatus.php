<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use HasFactory;

    // public $timestamps = false;

    function users() {
        return $this->hasMany(User::class,'user_status');
    }
}

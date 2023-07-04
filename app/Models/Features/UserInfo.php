<?php

namespace App\Models\Features;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = ['first_name','last_name','phone'];

    public function scopeGetUserAddress()
    {
        return $this->hasMany(Address::class)->where('user_info_id',$this->id);
    }

    public function scopeGetChoosenAddress()
    {
        return $this->hasOne(Address::class)->where('is_choosen_address',1);
    }
}

<?php

namespace App\Models\Features;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at','user_info_id'];

    protected $fillable = [
        'addr_name',
        'postal_code',
        'address_full',
        'district_id',
        'phone',
        'city_id',
        'province_id',
        'receiver_name',
        'is_choosen_address'
    ];

    public function userInfo()
    {
        return $this->belongsTo(UserInfo::class);
    }
}

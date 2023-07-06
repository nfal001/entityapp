<?php

namespace App\Models\Features;

use App\Models\Geo\City;
use App\Models\Geo\District;
use App\Models\Geo\Province;
use App\Models\User;
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

    public function scopeReady() {
        return $this->where('is_choosen_address',true);
    }

    public function userInfo()
    {
        return $this->belongsTo(UserInfo::class);
    }

    /**
     * GEO
     */
    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }

    // public function createWithGeneratedAddressFull(array $data) {
    //     return create(['
    //     '])
    // }

    // public function geo() {
    //     return $this->with('province','city','disctrict');
    // }

    public function user() {
        return $this->belongsTo(User::class,'user_info_id');
    }
}

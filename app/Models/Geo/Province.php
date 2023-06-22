<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function districts()
    {
        return $this->hasMany(District::class);
    }
    
    public function cities()
    {
        return $this->hasManyThrough(City::class,District::class);
    }

    function city() {
        return $this->hasOne(City::class);
    }
}

<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = FALSE;

    public function districts()
    {
        return $this->hasManyThrough(District::class,City::class);
    }

    function cities() {
        return $this->hasMany(City::class);
    }
    
    function city() {
        return $this->hasOne(City::class);
    }
}

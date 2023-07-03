<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    function district() {
        return $this->hasOne(District::class);
    }
}

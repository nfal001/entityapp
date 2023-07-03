<?php

namespace App\Models;

use App\Models\Features\EntityDetail;
use App\Models\Geo\City;
use App\Models\Geo\District;
use App\Models\Geo\Province;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $with = ['district:id,name','city:id,name'];
    protected $hidden = ['district_id','city_id','user_id'];

    public function scopeReady()
    {
        return $this->where('entity_status','Ready');
    }

    public function entityDetail()
    {
        return $this->hasMany(EntityDetail::class,'entity_id');
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }
    
}

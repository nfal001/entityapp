<?php

namespace App\Models;

use App\Models\Features\EntityDetail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory, HasUuids;

    public function scopeReady()
    {
        return $this->where('entity_status','Ready');
    }

    public function entityDetail()
    {
        return $this->hasMany(EntityDetail::class,'entity_id');
    }
}

<?php

namespace App\Models\Features;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityDetail extends Model
{
    use HasFactory;

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
}

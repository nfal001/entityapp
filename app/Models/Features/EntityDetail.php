<?php

namespace App\Models\Features;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityDetail extends Model
{
    use HasFactory;

    protected $fillable = ['note','hd_image_url'];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
}

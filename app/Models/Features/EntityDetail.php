<?php

namespace App\Models\Features;

use App\Models\Entity;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityDetail extends Model
{
    use HasFactory;

    protected $fillable = ['description','hd_image_url'];
    protected $hidden = ['created_at','updated_at','id','entity_id'];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class,'entity_tags','tag_id','entity_id');
    }
}

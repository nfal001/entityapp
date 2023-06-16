<?php

namespace App\Models\Features;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityDefinition extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
}

<?php

namespace App\Models\Features;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    protected $incrementing = false;

    
    function createTransaction() {
        
    }
}

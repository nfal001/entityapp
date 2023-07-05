<?php

namespace App\Models\Features;

use App\Models\CartEntity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $hidden = ['status','created_at','user_id'];
    
    public function scopeCurrentActiveCart() {
        return $this->where('status','active')->cartList();
    }

    public function cartList() {
        return $this->hasMany(CartEntity::class);
    }

    function createTransaction() {
        
    }
}

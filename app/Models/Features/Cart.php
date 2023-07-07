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

    protected $fillable = ['status'];
    protected $hidden = ['status','created_at','user_id','id'];

    public function scopeCurrentActiveCart() {
        return $this->where('status','active');
    }

    public function itemList() {
        return $this->hasMany(CartEntity::class);
    }

    public function addToCart(string $item, int $last_price) {
        return $this->itemList()->create(['entity_id'=>$item, 'last_price'=> $last_price ]);
    }
    
    function createTransaction() {
        
    }
}

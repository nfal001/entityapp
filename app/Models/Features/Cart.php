<?php

namespace App\Models\Features;

use App\Models\CartEntity;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['status'];
    protected $hidden = ['created_at','id'];

    public function scopeCurrentActiveCart() {
        return $this->where('status','active');
    }

    public function itemList() {
        return $this->hasMany(CartEntity::class);
    }

    public function entityToCart(User $user, Entity $item, Cart $cart) {
        $newCartEntity = new CartEntity(['last_price',$item->price]);
        return $cart->save([$newCartEntity]);
    }
    
    public function addToCart(Entity $entity) {
        return $this->itemList()->create([
            'entity_id'=>$entity->id,
            'last_price'=>$entity->price
        ]);
    }
    function createTransaction() {
        
    }
}

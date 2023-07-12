<?php

namespace App\Models;

use App\Models\Features\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartEntity extends Model
{
    use HasFactory;

    protected $fillable = ['entity_id','quantity','last_price'];
    protected $hidden = ['entity_id','updated_at','cart_id'];

    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    public function cart() {
        return $this->belongsTo(Cart::class);
    }
}

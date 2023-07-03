<?php

namespace App\Models;

use App\Models\Features\Address;
use App\Models\Features\Cart;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $with = ['user:uuid','cart:uuid','address:id,address_full'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }
}

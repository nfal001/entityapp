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

    // const UPDATED_AT = 'last_activity';

    /**
     * after fresh migration, remove user_id from $fillable
     */
    protected $fillable = ['user_id','cart_id','address_id','payment_status','order_status','total_price'];
    protected $with = ['user:id,name','cart','address'];
    protected $hidden = ['cart_id','user_id','address_id'];

    /**
     * Draft
     */

    //  eager load 
    // ->load(
    //     [
    //         'address'=>['city:id,name','province:id,name','district:id,name']
    //     ]
    // );

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

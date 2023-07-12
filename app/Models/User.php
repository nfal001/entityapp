<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Features\Address;
use App\Models\Features\Cart;
use App\Models\Features\UserInfo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $primaryKey = 'id';
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    // protected $with = ['userStatus:id,status'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'user_status',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * select One Address, then use it to index, update or delete them
     */
    public function address() {
        return $this->hasOne(Address::class,"user_id");
    }

    // public function draftActiveCart() {
    //     return $this->carts()->one()->save()
    // }
    
    /**
     * List Of Address
     */
    public function addresses() {
        return $this->hasMany(Address::class);
    }

    /**
     * Select Choosen Address
     */
    public function choosenAddress() {
        return $this->hasOne(Address::class)->where('addresses.is_choosen_address',true);
    }

    /**
     * Get User Info
     */
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    /**
     * Get Transaction Info
     */
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get User Active Cart, (can only have one)
     */
    public function activeCart() {
        return $this->hasOne(Cart::class)->where('status','active');
    }

    /**
     * Get Carts
     */
    public function cart() {
        return $this->hasOne(Cart::class);
    }

    /**
     * Get All Carts
     */
    public function carts() {
        return $this->hasMany(Cart::class);
    }

    /**
     * UserStatus
     */
    public function userStatus() {
        return $this->belongsTo(UserStatus::class,'user_status','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = FALSE;

    protected $fillable = [
        'image_proof',
        'payment_total',
        'payment_callback',
        'note'
    ];
}

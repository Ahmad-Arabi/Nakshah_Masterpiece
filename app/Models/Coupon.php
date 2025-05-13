<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

   protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'valid_from',
        'valid_to',
        'is_active',
        'is_featured',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

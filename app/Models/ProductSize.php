<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'stock',
    ];

    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = strtoupper($value);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

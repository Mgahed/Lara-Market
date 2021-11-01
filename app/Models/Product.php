<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'category',
        'quantity',
        'price_of_buy',
        'price_of_sell',
        'size',
        'product_size_id'
    ];

    public function productsize()
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }

    public function pendingorder()
    {
        return $this->hasMany(PendingOrder::class, 'product_id', 'id');
    }
}

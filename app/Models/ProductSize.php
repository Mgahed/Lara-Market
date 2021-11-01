<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode_s',
        'quantity_s',
        'barcode_m',
        'quantity_m',
        'barcode_l',
        'quantity_l'
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'product_size_id', 'id');
    }
}

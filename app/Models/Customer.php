<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number'
    ];

    public function pendingorder()
    {
        return $this->hasMany(PendingOrder::class, 'user_id', 'id');
    }
    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
    public function debt()
    {
        return $this->hasMany(Debt::class, 'customer_id', 'id');
    }
}

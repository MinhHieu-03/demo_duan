<?php

// app/Models/OrderItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_name', 'product_price', 'quantity'];

    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}


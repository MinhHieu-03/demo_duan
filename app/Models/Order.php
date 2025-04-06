<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Định nghĩa quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products() 
    { 
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price'); 
    }

    // Khai báo quan hệ One-to-Many với OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id'); // Đảm bảo có đủ tham số
    }
    
    public function paymentReturn(Request $request)
{
    if ($request->vnp_ResponseCode == "00") {
        $order = Order::where('id', $request->vnp_TxnRef)->first();
        if ($order) {
            $order->update(['status' => 'paid']);
        }
        return redirect()->route('orders.success')->with('success', 'Thanh toán thành công!');
    } else {
        return redirect()->route('orders.failed')->with('error', 'Thanh toán thất bại!');
    }

}
}

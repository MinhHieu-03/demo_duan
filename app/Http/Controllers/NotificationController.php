<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function read($id)
{
    $notification = auth()->user()->notifications()->find($id);

    if ($notification) {
        $notification->markAsRead();


        // Nếu trong dữ liệu notification có URL, redirect đến đó
        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
        }

        // Nếu thông báo có category_id, điều hướng đến trang danh mục
        if (isset($notification->data['category_id'])) {
            return redirect('/categories/' . $notification->data['category_id']);
        }

        // Nếu là admin -> điều hướng đến danh sách tất cả đơn hàng (bao gồm chưa duyệt)
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.orders.index'); 
        }

        // Nếu là người dùng -> hiển thị tất cả đơn hàng của họ, kể cả đơn chưa duyệt
        return redirect()->route('my.orders');
    }

    return redirect()->back();
}

    
}

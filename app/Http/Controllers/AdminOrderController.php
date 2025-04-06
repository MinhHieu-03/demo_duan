<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Thêm dòng này để import DB
use App\Notifications\OrderUserNotification;
use App\Models\User;
use App\Notifications\OrderApprovedNotification;


class AdminOrderController extends Controller
{
    // duyệt đơn hàng dành cho admin
    
    public function index()
{
    // Lấy tất cả đơn hàng (bao gồm pending, approved, rejected)
    $orders = Order::orderBy('created_at', 'desc')->get();

    return view('admin.orders.index', compact('orders'));
}


    //cập nhật trang thái đơn hàng admin
    public function approve($id)
{
    // Cập nhật trạng thái đơn hàng thành 'approved'
    $order = Order::findOrFail($id);
    $order->status = 'approved';
    $order->save();

    // Gửi thông báo cho người dùng về việc đơn hàng đã được duyệt
    $user = User::find($order->user_id);
    if ($user) {
        $user->notify(new OrderApprovedNotification($order));
    }

    // Tính toán và lưu doanh thu
    $this->updateRevenue($order);

    return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được duyệt!');
}

    public function reject($id)
    {
        // Cập nhật trạng thái đơn hàng thành 'rejected'
        $order = Order::findOrFail($id);
        $order->status = 'rejected';
        $order->save();

        return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng đã bị từ chối!');
    }

    // Hàm tính toán doanh thu khi duyệt đơn hàng
    private function updateRevenue(Order $order)
    {
        // Kiểm tra nếu đơn hàng đã được duyệt và tính doanh thu
        if ($order->status === 'approved') {
            $totalPrice = $order->total_price;

            // Lưu doanh thu vào báo cáo hoặc bất kỳ nơi nào bạn cần
            // Ví dụ: bạn có thể lưu vào một bảng báo cáo doanh thu hoặc ghi nhận vào biến tổng
            DB::table('revenue_reports')->insert([
                'order_id' => $order->id,
                'total_revenue' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

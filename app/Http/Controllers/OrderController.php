<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\User;
use App\Notifications\OrderNotification;

class OrderController extends Controller
{
    public function orderSuccess()
    {
        return view('orders.success');
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống, không thể thanh toán!');
        }

        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $hasLaptop = false;

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'product_price' => $item['price'],
                'original_price' => $item['original_price'] ?? $item['price'],
                'quantity' => $item['quantity'],
            ]);

            if (stripos($item['name'], 'laptop') !== false) {
                $hasLaptop = true;
            }
        }

        if ($hasLaptop) {
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new OrderNotification($order));
            }
        }

        session()->forget('cart');

        return redirect()->route('orders.success')->with('success', 'Đặt hàng thành công! Đơn hàng của bạn đang chờ xử lý.');
    }

    public function cancelOrder($id)
{
    $order = Order::find($id);

    if (!$order) {
        return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
    }

    // Kiểm tra trạng thái đơn hàng
    if ($order->status !== 'pending') {
        return redirect()->back()->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái chờ.');
    }

    // Cập nhật trạng thái đơn hàng thành "canceled"
    $order->status = 'canceled';
    $order->save();

    return redirect()->back()->with('success', 'Đơn hàng đã bị hủy.');
}


    public function store(Request $request)
{
    // Tạo đơn hàng mới
    $order = Order::create([
        'user_id' => auth()->id(),
        'total_price' => $request->total_price,
        'status' => 'pending',
    ]);

    // Thêm sản phẩm vào order_items
    foreach ($request->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_name' => $item['name'],
            'product_price' => $item['price'],
            'quantity' => $item['quantity'],
        ]);
    }

    // Kiểm tra nếu có sản phẩm laptop thì gửi thông báo
    $containsLaptop = OrderItem::where('order_id', $order->id)
        ->where('product_name', 'LIKE', '%Laptop%') // Kiểm tra từ khóa
        ->exists();

    if ($containsLaptop) {
        // Gửi thông báo đến admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new OrderNotification($order));
        }
    }

    return redirect()->back()->with('success', 'Đặt hàng thành công!');
}

public function printInvoice($orderId)
{
    $order = Order::with('orderItems')->findOrFail($orderId);

    // Render view với dữ liệu đơn hàng
    $pdf = Pdf::loadView('orders.invoice', compact('order'));

    return $pdf->download('invoice-' . $order->id . '.pdf'); // Tải về file PDF
}
public function success()
    {
        return view('orders.success')->with('message', 'Thanh toán thành công!');
    }

    public function failed()
    {
        return view('orders.failed')->with('message', 'Thanh toán thất bại!');
    }
}

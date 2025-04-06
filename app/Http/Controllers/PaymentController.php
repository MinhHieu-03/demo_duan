<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
    }

    // Tính tổng tiền
    $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

    // Tạo mã đơn hàng động (chỉ để gửi cho VNPay, chưa lưu DB)
    $vnp_TxnRef = time(); // Dùng timestamp để tạo mã đơn hàng duy nhất

    // Cấu hình VNPay
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = route('vnpay.return'); // VNPay sẽ gọi lại URL này sau khi thanh toán
    $vnp_TmnCode = "2YDT3Q4O"; // Mã website tại VNPay
    $vnp_HashSecret = "XA460OFWKJ9XU9AER6FRYCMN4PY07QO4"; // Chuỗi bí mật

    $vnp_OrderInfo = "Thanh toán đơn hàng #" . $vnp_TxnRef;
    $vnp_OrderType = "billPayment";
    $vnp_Amount = $totalPrice * 100; // VNPay yêu cầu số tiền tính bằng VND * 100
    $vnp_Locale = "vn";
    $vnp_BankCode = "NCB";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    ];

    ksort($inputData);
    $query = "";
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        $hashdata .= ($hashdata ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }

    return redirect($vnp_Url);
}

public function vnpay_return(Request $request)
{
    $vnp_ResponseCode = $request->input('vnp_ResponseCode'); // Mã phản hồi từ VNPay
    $vnp_TxnRef = $request->input('vnp_TxnRef'); // Mã đơn hàng

    if ($vnp_ResponseCode == "00") {
        // ✅ Thanh toán thành công -> Lưu đơn hàng
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Tính tổng tiền
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // Lưu đơn hàng
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Lưu từng sản phẩm trong đơn hàng
        foreach ($cart as $slug => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'product_price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Gửi thông báo cho admin khi có đơn hàng mới
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\OrderPaidNotification($order));
        }
        
        // Xóa giỏ hàng sau khi tạo đơn hàng
        session()->forget('cart');

        return redirect()->route('orders.success')->with('success', 'Thanh toán thành công! Đơn hàng của bạn đang chờ duyệt.');
    } else {
        // ❌ Hủy thanh toán -> Không lưu đơn hàng, chỉ chuyển đến danh sách đơn hàng
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'))->with('error', 'Bạn đã hủy thanh toán!');
    }
}

}
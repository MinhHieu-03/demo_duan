@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Chi Tiết Đơn Hàng - {{ $buyerName }}</h2>
    <div class="mb-3"> 
        <a href="{{ route('admin.revenueReport') }}" class="btn btn-secondary">Quay lại</a> 
    </div>

    <table class="table table-striped table-bordered mt-3">
        <thead class="thead-light">
            <tr>
                <th>Mã Đơn</th>
                <th>Ngày Đặt</th>
                <th>Tên Người Mua</th>
                <th>Địa chỉ</th>
                <th>Số Điện Thoại</th>
                <th>Tên Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->buyer_name }}</td>
                <td>{{ $order->buyer_address ?? 'Chưa cập nhật' }}</td>
                <td>{{ $order->buyer_phone ?? 'Chưa cập nhật' }}</td>
                <td>{{ $order->product_name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ number_format($order->product_price, 0, ',', '.') }} VNĐ</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

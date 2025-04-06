@extends('layouts.admin')

@section('content')
<h1 class="d-flex justify-content-center">Danh sách đơn hàng</h1>


    <table class="table table-striped table-bordered mt-3">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Địa chỉ</th> <!-- Thêm cột địa chỉ -->
                <th>Điện thoại</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th> <!-- Cột trạng thái -->
                <th>Thao tác</th> <!-- Cột thao tác cho nút duyệt và từ chối -->
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->user->address }}</td> <!-- Hiển thị địa chỉ -->
                    <td>
                        @if ($order->user->role === 'customer')
                            {{ $order->user->phone_number }}
                        @else
                            <!-- Không hiển thị hoặc hiển thị trống nếu không phải khách hàng -->
                            -
                        @endif
                    </td>
                    <td>
                        @foreach ($order->items as $item)
                            {{ $item->product_name }} <br>
                        @endforeach
                    </td>


                    <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <span class="badge 
                            @if ($order->status == 'approved') bg-success 
                            @elseif ($order->status == 'rejected') bg-danger 
                            @else bg-warning 
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        @if ($order->status === 'pending')
                        <div class="d-flex flex-column justify-content-start">
                            <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this order?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm mb-2">Duyệt</button>
                            </form>
                            <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this order?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
                            </form>
                        </div>
                        @elseif ($order->status === 'approved')
                        <span class="badge text-bg-success">Đã duyệt</span>
                        @elseif ($order->status === 'rejected')
                        <span class="badge text-bg-danger">Đã từ chối</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

<style>
    .btn-sm-small {
        font-size: 0.25rem;
        padding: 0.2rem 0.3rem;
    }
</style>

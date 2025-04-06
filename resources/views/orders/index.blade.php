@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5 min-vh-100">
    <h2 class="text-center">Lịch sử đơn hàng</h2>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if(isset($orders) && count($orders) > 0)
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover w-100">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tên sản phẩm</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @foreach ($order->items as $item)
                                {{ $item->product_name }} <br>
                            @endforeach
                        </td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                        <td>
                            @if ($order->status === 'pending')
                                <span class="badge text-bg-warning">Chờ duyệt</span>
                            @elseif ($order->status === 'approved')
                                <span class="badge text-bg-success">Đã duyệt</span>
                            @else
                                <span class="badge text-bg-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            @if ($order->status === 'pending')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">Hủy đơn</button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Không thể hủy</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        

    @else
        <p class="text-center mt-4">Bạn chưa có đơn hàng nào.</p>
    @endif

</div>
@endsection

<style>
    .input-group {
        margin-top: 17px;
    }
</style>

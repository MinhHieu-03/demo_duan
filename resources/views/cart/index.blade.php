@extends('layouts.app')

@section('content')
<div class="container mt-5 min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-10"> 
            <div class="card shadow-lg border-0 rounded-4"> 
                <div class="card-body p-4">
                    @if (empty($cart))
                        <div class="text-center py-5">
                            <h4 class="text-muted">Giỏ hàng của bạn đang trống</h4>
                        </div>
                    @else
                    <h2 class="text-center mb-4 fw-bold" style="color: #8C367B;">Giỏ hàng của bạn</h2>

                        <div class="table-responsive">
                            <table class="table align-middle text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành Tiền</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $id => $item)
                                        <tr class="border-bottom">
                                            <td>
                                                <img src="{{  $item['image'] }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 100px; height: 100px; object-fit: cover;">
                                            </td>
                                            <td class="fw-semibold">{{ $item['name'] }}</td>
                                            <td class="text-danger fw-bold">{{ number_format($item['price'], 0, ',', '.') }} VND</td>
                                            <td>
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline-flex align-items-center">
                                                    @csrf
                                                    <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm rounded-circle">-</button>
                                                    <input type="text" name="quantity" value="{{ $item['quantity'] }}" class="form-control text-center mx-2" style="width: 50px;" readonly>
                                                    <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm rounded-circle">+</button>
                                                </form>
                                            </td>
                                            <td class="fw-bold">
                                                @if(isset($item['original_price']) && $item['original_price'] > $item['price'])
                                                    <del class="text-muted">{{ number_format($item['original_price'], 0, ',', '.') }} VND</del><br>
                                                    <span class="text-danger">{{ number_format($item['price'], 0, ',', '.') }} VND</span>
                                                @else
                                                    <span>{{ number_format($item['price'], 0, ',', '.') }} VND</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Nút xóa tất cả -->
                            <div class="d-flex justify-content-end mt-3">
                                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa tất cả</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Thanh toán -->
        <div class="col-md-10 mt-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-4">
                    @if (!empty($cart))
                        <h3 class="mb-3">Tổng tiền: <strong class="text-danger">{{ number_format(calculateTotal($cart), 0, ',', '.') }} VND</strong></h3>
                        
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary ">Thanh toán khi nhận hàng</button>
                            </form>
                            <form action="{{ url('/vnpay_payment') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary " name='redirect'>Thanh toán qua VNPay</button>
                            </form>
                            
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    function calculateTotal($cart) {
        return array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    }
@endphp

<style>
    .input-group {
            margin-top: 17px;
        }
        .table-responsive {
        overflow-x: auto;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: scale(1.05);
    }
    .btn-primary {
            border: 2px solid #8C367B !important;
            color: #8C367B !important;
            background-color: white !important; /* Đảm bảo nền ban đầu là trắng */
            transition: all 0.3s ease-in-out; /* Hiệu ứng chuyển đổi mượt mà */
            color: white;
        }

        .btn-primary:hover {
            background-color: #8C367B !important;
            color: white !important;
            transform: scale(1.05); /* Làm nút to lên một chút khi hover */
        }
        .btn-primary:focus {
            box-shadow: 0 0 0 0.25rem rgba(140, 54, 123, 0.5); /* Tạo hiệu ứng focus */
        }
</style>
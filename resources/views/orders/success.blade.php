@extends('layouts.app')

@section('content')

<div class="container text-center py-5 min-vh-100">
    <h1 class="text-thanks" style="color: #8C367B;">Cảm ơn bạn đã đặt hàng!</h1>
    <p class="fs-5">Đơn hàng của bạn đang được xử lý</p>
    <p class="fs-5">Vui lòng quay lại trong 2-5 phút để kiểm tra</p>
    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-primarys me-2">Trang chủ</a>
        <a href="{{ route('my.orders') }}" class="btn btn-outline-primarys">Xem đơn hàng</a>
    </div>
</div>

@endsection
<style>
    .input-group {
            margin-top: 17px;
        }
        .btn-primarys {
    background-color: #8C367B !important;
    border-color: #8C367B !important;
    color: white !important;
}

.btn-primarys:hover {
    background-color: #A0408C !important;
}

.btn-outline-primarys {
    border-color: #8C367B !important;
    color: #8C367B !important;
    
}

.btn-outline-primarys:hover {
    background-color: #8C367B !important;
    color: white !important;
}


</style>
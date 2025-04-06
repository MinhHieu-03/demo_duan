@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Báo Cáo Doanh Thu</h2>

    <!-- Form lọc -->
    <form action="{{ route('admin.revenueReport') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="start_date">Chọn Ngày Bắt Đầu:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>

        <div class="form-group">
            <label for="end_date">Chọn Ngày Kết Thúc:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Lọc</button>

        <!-- Nút In Báo Cáo -->
        <a href="{{ route('admin.printRevenueReport', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
        class="btn btn-success mt-3">
            In Báo Cáo PDF
        </a>

    </form>

    <!-- Bảng doanh thu -->
    <table class="table table-striped table-bordered mt-3">
        <thead class="thead-light">
            <tr>
                <th>Ngày</th>
                <th>Người Mua</th>
                
                <th>Doanh Thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenues as $revenue)
            <tr>
                <td>{{ $revenue->time }}</td>
                <td>
                    <a href="{{ route('admin.orderDetails', ['buyerName' => $revenue->buyer_name]) }}">
                        {{ $revenue->buyer_name }}
                    </a>
                </td>
                
                <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Tổng doanh thu:</th>
                <th>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

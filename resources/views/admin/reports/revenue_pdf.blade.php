<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Doanh Thu</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Báo Cáo Doanh Thu</h2>
    <p><strong>Thời gian:</strong> {{ $startDate }} - {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Người Mua</th>
                <th>Số Đơn Hàng</th>
                <th>Doanh Thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenues as $revenue)
            <tr>
                <td>{{ $revenue->time }}</td>
                <td>{{ $revenue->buyer_name }}</td>
                <td>{{ $revenue->total_orders }}</td>
                <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Tổng doanh thu:</th>
                <th>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>

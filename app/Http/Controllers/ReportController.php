<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Thống kê doanh thu trên giao diện admin
    public function revenueReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Nếu không có ngày lọc, mặc định lấy trong tháng hiện tại
        if (!$startDate || !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }

        // Truy vấn dữ liệu
        $revenues = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                DB::raw('DATE(orders.created_at) as time'),
                'users.name as buyer_name',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_price) as total_revenue')
            )
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'approved')
            ->groupBy('time', 'users.name')
            ->orderBy('time', 'desc')
            ->get();

        $totalRevenue = $revenues->sum('total_revenue');

        return view('admin.dashboard', compact('revenues', 'totalRevenue', 'startDate', 'endDate'));
    }

    // Xuất báo cáo PDF theo dữ liệu đã lọc
    public function printRevenueReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Nếu không có ngày lọc, mặc định lấy trong tháng hiện tại
        if (!$startDate || !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }

        // Truy vấn đúng dữ liệu đã lọc
        $revenues = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                DB::raw('DATE(orders.created_at) as time'),
                'users.name as buyer_name',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_price) as total_revenue')
            )
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'approved')
            ->groupBy('time', 'users.name')
            ->orderBy('time', 'desc')
            ->get();

        $totalRevenue = $revenues->sum('total_revenue');

        // Xuất file PDF
        $pdf = Pdf::loadView('admin.reports.revenue_pdf', compact('revenues', 'totalRevenue', 'startDate', 'endDate'));

        return $pdf->download("bao-cao-doanh-thu-{$startDate}_to_{$endDate}.pdf");
    }
}

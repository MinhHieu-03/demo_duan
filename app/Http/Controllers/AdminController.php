<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order; // Thêm dòng này để import model Order
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Carbon\Carbon;

class AdminController extends Controller
{
    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả danh mục
        return view('admin.categories.index', compact('categories')); // Trả về view
    }

    // Hiển thị form tạo danh mục
    public function create()
    {
        return view('categories.create'); // Trả về view tạo danh mục
    }

    // Lưu danh mục mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Các trường khác nếu có...
        ]);

        Category::create($request->all()); // Tạo danh mục mới
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo!'); // Chuyển hướng về danh sách
    }
    
    // Hiển thị chi tiết danh mục
    public function show($id)
    {
        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        return view('admin.categories.show', compact('category')); // Trả về view chi tiết danh mục
    }

    // Hiển thị form chỉnh sửa danh mục
    public function edit($id)
    {
        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        return view('admin.categories.edit', compact('category')); // Trả về view chỉnh sửa danh mục
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Các trường khác nếu có...
        ]);

        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        $category->update($request->all()); // Cập nhật danh mục
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật!'); // Chuyển hướng về danh sách
    }
    
    // Xóa danh mục
    public function destroy($id)
    {
        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        $category->delete(); // Xóa danh mục
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa!'); // Chuyển hướng về danh sách
    }

    //thống kê dành cho admin
    public function revenueReport(Request $request)
    {
        // Lấy các tham số ngày bắt đầu và ngày kết thúc từ request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Nếu không có ngày bắt đầu và ngày kết thúc, lấy tất cả
        if (!$startDate && !$endDate) {
            $revenues = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select(
                    DB::raw('DATE(orders.created_at) as time'),
                    'users.name as buyer_name',
                    DB::raw('COUNT(orders.id) as total_orders'),
                    DB::raw('SUM(orders.total_price) as total_revenue')
                )
                ->where('orders.status', 'approved')  // Lọc chỉ những đơn hàng đã duyệt
                ->groupBy('time', 'users.name')
                ->orderBy('time', 'desc')
                ->get();
        } else {
            // Nếu có ngày bắt đầu và ngày kết thúc, lọc theo khoảng thời gian
            $revenues = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select(
                    DB::raw('DATE(orders.created_at) as time'),
                    'users.name as buyer_name',
                    DB::raw('COUNT(orders.id) as total_orders'),
                    DB::raw('SUM(orders.total_price) as total_revenue')
                )
                ->whereBetween('orders.created_at', [$startDate, $endDate])  // Lọc theo khoảng thời gian
                ->where('orders.status', 'approved')  // Lọc chỉ những đơn hàng đã duyệt
                ->groupBy('time', 'users.name')
                ->orderBy('time', 'desc')
                ->get();
        }

        // Tính tổng doanh thu
        $totalRevenue = $revenues->sum('total_revenue');

        return view('admin.dashboard', compact('revenues', 'totalRevenue'));
    }
    
    //admin xem chi tiết đơn hàng người dùng dã mua
    public function orderDetails($buyerName)
{
    // Lấy thông tin đơn hàng đã được duyệt của người mua
    $orders = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->select(
            'orders.id as order_id',
            'orders.created_at as order_date',
            'users.name as buyer_name',
            'users.address as buyer_address',
            'users.phone_number as buyer_phone',
            'order_items.product_name',
            'order_items.quantity',
            'order_items.product_price',
            DB::raw('(order_items.quantity * order_items.product_price) as total_price') // Tính tổng giá trị từng sản phẩm
        )
        ->where('users.name', $buyerName)
        ->where('orders.status', 'approved')
        ->orderBy('orders.created_at', 'desc')
        ->get();

    // Tính tổng doanh thu từ các đơn hàng đã duyệt
    $totalRevenue = $orders->sum('total_price');

    return view('admin.order_details', compact('orders', 'buyerName', 'totalRevenue'));
}


    //danh sách duyệt đơn hàng dành cho admin
    public function showOrders()
    {
        // Lấy tất cả đơn hàng từ database
        $users = User::all();
        $orders = Order::all(); // Hoặc sử dụng phương thức phân trang nếu cần
        // Trả về view với danh sách đơn hàng
        return view('admin.orders.index', compact('orders', 'users'));

    }

    //logout admin
    public function logout()
    {
        Auth::logout();
        session()->invalidate(); 
        session()->regenerateToken(); 

        return redirect('/login')->with('success', 'Bạn đã đăng xuất thành công!');
    }

}

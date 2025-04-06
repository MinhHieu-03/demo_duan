<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index()
    {
        return view('admin.index'); // View trang chủ admin
    }

    public function showProducts()
    {
        return view('admin.products'); // View quản lý sản phẩm
    }

    // app/Http/Controllers/AdminController.php

    public function showCategories()
    {
        return view('admin.categories.index'); // Kiểm tra tên view
    }


    public function showOrders()
    {
        return view('admin.orders'); // View quản lý đơn hàng
    }
}

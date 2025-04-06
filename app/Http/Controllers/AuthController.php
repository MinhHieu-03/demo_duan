<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'phone_number' => 'required|string|max:15', // Xác thực số điện thoại
        'address' => 'required|string|max:255',
    ]);

    // Tạo người dùng mới
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Mã hóa mật khẩu
        'address' => $request['address'], // Lưu địa chỉ
        'phone_number' => $request['phone_number'], 
        'role' => 'customer', // Hoặc bạn có thể chỉ định giá trị khác nếu cần
    ]);

    // Chuyển hướng về trang đăng nhập với thông báo thành công
    return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
}

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        // Kiểm tra xem người dùng có phải là admin không
        if (Auth::user()->role === 'admin') {
            return redirect()->route('categories.index'); // Redirect đến danh sách categories
        }
        // Redirect đến một trang khác cho người dùng thông thường (nếu cần)
        return redirect()->route('home'); // Hoặc một route khác cho người dùng thông thường
    }

    return back()->withErrors(['email' => 'email hoặc mật khẩu không đúng! vui lòng nhập lại!']); // Thông báo lỗi
}


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

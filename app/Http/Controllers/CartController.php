<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\OrderNotification;

class CartController extends Controller
{
    public function add(Request $request, $slug)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        // Tìm sản phẩm theo slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Tính giá sản phẩm (nếu có giảm giá)
        $price = $category->sale_price ?? $category->price;

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        if (isset($cart[$slug])) {
            $cart[$slug]['quantity']++;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $cart[$slug] = [
                'name' => $category->name,
                'price' => $price,
                'original_price' => $category->price,
                'quantity' => 1,
                'image' => $category->image
            ];
        }

        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);

        // Nếu là "Mua Ngay", chuyển đến trang giỏ hàng
        if ($request->has('buy_now')) {
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        }

        // Nếu không, quay lại trang trước
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }


    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function update(Request $request, $slug)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$slug])) {
            if ($request->input('action') === 'increase') {
                $cart[$slug]['quantity']++;
            } elseif ($request->input('action') === 'decrease') {
                if ($cart[$slug]['quantity'] > 1) {
                    $cart[$slug]['quantity']--;
                } else {
                    unset($cart[$slug]);
                }
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được xóa.');
    }

}

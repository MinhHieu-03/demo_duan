<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryImage;

class CategoryController extends Controller
{
    // Hiển thị danh sách các category
    public function index(Request $request)
    {
        $query = $request->input('query');
    
        // Nếu có từ khóa tìm kiếm, lọc sản phẩm theo tên hoặc mô tả
        if ($query) {
            $categories = Category::where('name', 'like', '%' . $query . '%')
                                  ->orWhere('description', 'like', '%' . $query . '%')
                                  ->get();
        } else {
            // Nếu không có từ khóa, lấy tất cả và sắp xếp sản phẩm mới nhất lên đầu
            $categories = Category::orderBy('created_at', 'desc')->get();
        }
    
        return view('categories.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm các sản phẩm phù hợp với từ khóa
        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'slug', 'name', 'image', 'description', 'price', 'sale_price', 'status') // Lấy các cột cần thiết
            ->get();

        // Lọc sản phẩm giảm giá và không giảm giá
        $discountedProducts = $categories->filter(function ($category) {
            return !is_null($category->sale_price) && $category->sale_price < $category->price; // Chỉ lấy sản phẩm có giá sale < giá gốc
        });

        $regularProducts = $categories->filter(function ($category) {
            return is_null($category->sale_price) || $category->sale_price >= $category->price;
        });

        return view('categories.search', compact('categories', 'discountedProducts', 'regularProducts'));
    }

    // Hiển thị form thêm category
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'sale_price' => 'nullable|numeric|lt:price', // Sale price must be less than the original price
            'status' => 'required|string|in:Còn hàng,Hết hàng', // Trạng thái bắt buộc
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Tạo danh mục sản phẩm
        $category = new Category();
        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::slug($request->name, '-');
        $category->price = $request->price;
        $category->description = $request->description;
        $category->sale_price = $request->sale_price; // Nếu không có sale_price, sẽ được lưu là null
        $category->status = $request->status; // Trạng thái sản phẩm

        // Xử lý ảnh (nếu có)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories'), $imageName);
            $category->image = 'uploads/categories/' . $imageName;
        }

        // Lưu danh mục vào cơ sở dữ liệu
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Hiển thị form sửa category
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Cập nhật category
    public function update(Request $request, $id)
    {
        // Tìm danh mục theo ID
        $category = Category::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',  // Validate trường sale_price (giảm giá)
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Cập nhật thông tin cơ bản
        $category->name = $request->name;
        $category->description = $request->description;
        $category->price = $request->price;
        $category->slug = Str::slug($category->name, '-');
        $category->sale_price = $request->sale_price;  // Cập nhật giá giảm
        $category->status = $request->status; // Cập nhật status sản phẩm

        // Nếu có hình ảnh mới được tải lên
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
                unlink(public_path('uploads/categories/' . $category->image)); // Xóa ảnh cũ
            }

            // Lưu ảnh mới vào thư mục public/uploads/categories
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Đổi tên file tránh trùng lặp
            $image->move(public_path('uploads/categories'), $imageName); // Lưu ảnh vào thư mục public/uploads/categories

            // Cập nhật đường dẫn ảnh trong CSDL
            $category->image = 'uploads/categories/' . $imageName; // Lưu đường dẫn ảnh vào database
        }

        // Lưu thay đổi vào CSDL
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    // Xóa category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Xóa hình ảnh nếu có
        if ($category->image && Storage::exists('public/' . $category->image)) {
            Storage::delete('public/' . $category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được xóa!');
    }

    // Xử lý upload hình ảnh
    private function handleImageUpload($request)
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('images', 'public');
        }
        return null;
    }

    public function filterByCategory($name)
    {
        // Tìm danh mục theo tên
        $categories = Category::where('name', 'LIKE', "%{$name}%")->get();

        return view('categories.view', compact('categories', 'name'));
    }

    public function show($category)
    {
        // Kiểm tra xem category là ID hay Slug
        $category = Category::with('comments')
            ->where('id', $category)
            ->orWhere('slug', $category)
            ->firstOrFail();

        $user = auth()->user();

        // Nếu là admin, chuyển hướng đến trang quản lý bình luận
        if ($user && $user->role === 'admin') {
            return view('admin.comments.index', compact('category', 'user'));
        }

        // Nếu là người dùng bình thường, giữ nguyên trang hiển thị sản phẩm
        return view('categories.show', compact('category', 'user'));
    }

    public function showDiscountedProducts(Request $request)
    {
        $limit = 8; // số sản phẩm hiển thị ban đầu
        $discountedProducts = Category::whereNotNull('sale_price')
            ->latest()
            ->take($limit)
            ->get();
    
        $regularProducts = Category::whereNull('sale_price')
            ->latest()
            ->take($limit)
            ->get();
    
        return view('home', compact('discountedProducts', 'regularProducts'));
    }
    
    public function loadMore(Request $request)
    {
        $offset = $request->offset ?? 0;
        $type = $request->type; // 'discounted' hoặc 'regular'
    
        $query = Category::query();
        if ($type === 'discounted') {
            $query->whereNotNull('sale_price');
        } else {
            $query->whereNull('sale_price');
        }
    
        $products = $query->latest()
            ->skip($offset)
            ->take(6)
            ->get();
    
        return response()->json([
            'html' => view('partials.product-items', ['products' => $products])->render()
        ]);
    }
    
}

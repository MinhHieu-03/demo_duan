<?php

namespace App\Http\Controllers;

use App\Models\Category; // Đảm bảo bạn đã import model Category
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showDiscountedProducts(Request $request)
    {
        $limit = 8;
    
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
        $type = $request->type ?? 'regular';
    
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
    
        $html = view('partials.product-items', ['products' => $products])->render();
    
        return response()->json(['html' => $html]);
    }
    
    
}

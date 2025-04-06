@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Tiêu đề kết quả tìm kiếm -->
    <h5>Kết quả tìm kiếm cho "{{ request('query') }}"</h5>

    <!-- Kiểm tra nếu không có sản phẩm nào tìm thấy -->
    @if ($categories->isEmpty())
        <p class="text-center mt-5">Không có sản phẩm nào phù hợp với từ khóa "{{ request('query') }}".</p>
    @else
        <!-- Hiển thị danh sách sản phẩm -->
        <div class="row-product-section">
            @foreach ($categories as $category)
                <div class="col-item {{ $category->status === 'Hết hàng' ? 'out-of-stock' : '' }}">
                    <!-- Hình ảnh sản phẩm -->
                    @if ($category->image)
                        <a href="{{ route('categories.show', $category->slug) }}" class="{{ $category->status === 'Hết hàng' ? 'disabled-link' : '' }}">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                        </a>
                    @else
                        <p class="text-center">Không có hình ảnh</p>
                    @endif

                    <div class="product-attribute">
                        <!-- Tên sản phẩm -->
                        <a href="{{ route('categories.show', $category->slug) }}" class="product-title {{ $category->status === 'Hết hàng' ? 'text-muted' : '' }}">
                            {{ $category->name }}
                        </a>

                        <!-- Mô tả sản phẩm -->
                        <div class="text-attribute">
                            <span>{{ Str::limit(strip_tags($category->description), 87) }}</span>
                        </div>

                        <!-- Giá sản phẩm, bao gồm cả giảm giá nếu có -->
                        @if(!is_null($category->sale_price) && $category->sale_price < $category->price)
                            <p>
                                <del class="text-muted">{{ number_format($category->price) }} VND</del>
                                <span class="text-danger fw-bold">{{ number_format($category->sale_price) }} VND</span>
                            </p>
                        @else
                            <p class="fw-bold">{{ number_format($category->price) }} VND</p>
                        @endif

                        <!-- Form thêm vào giỏ hàng -->
                        @if ($category->status !== 'Hết hàng')
                            <form action="{{ route('cart.add', $category->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-block">Thêm vào giỏ hàng</button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-block" disabled>Hết hàng</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection



<style>
    .row-product-section {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        text-align: center;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        padding: 40px;
        margin-top: 5px;
    }

    .col-item {
        border-radius: 5px;
        padding: 20px;
        margin: 15px;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        margin-top: 5px;
    }

    .col-item:hover {
        transform: scale(1.05);
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    }

    .product-attribute {
        margin-top: 25px;
        font-size: 13px;
    }

    .product-title {
        color: black;
        font-size: 17px;
        font-weight: 500;
        text-decoration: none;
    }

    .text-attribute {
        color: 0px 8px 16px rgba(254, 67, 67, 0.2);
    }

    p {
        font-style: italic;
        font-weight: bold;
        font-size: 18px;
        color: red;
    }

    img {
        max-width: 100%;
        height: auto;
    }
    .text-attribute span {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    }
    .btn-outline-primary {
            border: 2px solid #8C367B !important;
            color: #8C367B !important;
            background-color: white !important; /* Đảm bảo nền ban đầu là trắng */
            transition: all 0.3s ease-in-out; /* Hiệu ứng chuyển đổi mượt mà */
        }

        .btn-outline-primary:hover {
            background-color: #8C367B !important;
            color: white !important;
            transform: scale(1.05); /* Làm nút to lên một chút khi hover */
        }
        .btn-outline-primary:focus {
            box-shadow: 0 0 0 0.25rem rgba(140, 54, 123, 0.5); /* Tạo hiệu ứng focus */
        }
       /* Ngừng cho phép click vào sản phẩm hết hàng */
        .out-of-stock {
            opacity: 0.5;
            pointer-events: none; /* Vô hiệu hóa tất cả các sự kiện chuột */
        }

        /* Lớp disabled-link để vô hiệu hóa các liên kết */
        .disabled-link {
            pointer-events: none; /* Vô hiệu hóa click vào liên kết */
            text-decoration: none; /* Bỏ gạch chân khi hết hàng */
        }

        /* Thêm màu sắc để dễ nhận biết sản phẩm hết hàng */
        .out-of-stock .product-title {
            color: #6c757d; /* Màu nhạt cho sản phẩm hết hàng */
        }

        .out-of-stock .btn-outline-primary {
            pointer-events: none; /* Vô hiệu hóa các nút "Thêm vào giỏ hàng" */
        }

</style>
 
@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Banner Carousel -->
<div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner ">
        <div class="carousel-item active">
            <div class="d-flex">
                <a href="{{ route('categories.show', 44) }}" class="w-50 p-1">
                    <img class="d-block w-100 rounded" src="{{ asset('uploads/banner/def17561b525b3da25dedbf1d7cd352e.png') }}" alt="Banner 1">
                </a>
                <a href="{{ route('categories.show', 44) }}" class="w-50 p-1">
                    <img class="d-block w-100 rounded" src="{{ asset('uploads/banner/00f6e44e8cd5eeb32a2eb4e55862c7dd.png') }}" alt="Banner 2">
                </a>
            </div>
        </div>
        <div class="carousel-item">
            <div class="d-flex">
                <a href="{{ route('categories.show', 51) }}" class="w-50 p-1">
                    <img class="d-block w-100 rounded" src="{{ asset('uploads/banner/1c853b193d08dd63bb55bd38b299e93d.png') }}" alt="Banner 3">
                </a>
                <a href="{{ route('categories.show', 44) }}" class="w-50 p-1">
                    <img class="d-block w-100 rounded" src="{{ asset('uploads/banner/def17561b525b3da25dedbf1d7cd352e.png') }}" alt="Banner 4">
                </a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>

<!-- Sản phẩm giảm giá -->
<div class="row">
    <div class="heading-line"><h2>SẢN PHẨM GIẢM GIÁ</h2></div>
    <div class="row-product-section">
        @foreach ($discountedProducts as $category)
            <div class="col-item {{ $category->status === 'Hết hàng' ? 'product-out-of-stock' : 'product-in-stock' }}">
                {{-- Hình ảnh --}}
                @if ($category->status !== 'Hết hàng')
                    <a href="{{ route('categories.show', $category->slug) }}">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                    </a>
                @else
                    <div style="position: relative;">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="opacity-50">
                        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold bg-danger p-1 px-2 rounded">Hết hàng</div>
                    </div>
                @endif

                <div class="product-attribute">
                    {{-- Tên sản phẩm --}}
                    @if ($category->status !== 'Hết hàng')
                        <a href="{{ route('categories.show', $category->slug) }}" class="product-title">{{ $category->name }}</a>
                    @else
                        <span class="product-title text-muted">{{ $category->name }} (Hết hàng)</span>
                    @endif

                    {{-- Mô tả --}}
                    <div class="text-attribute">
                        <span>{{ Str::limit(strip_tags($category->description), 87) }}</span>
                    </div>

                    {{-- Giá --}}
                    @if($category->sale_price && $category->sale_price < $category->price)
                        <p>
                            <del>{{ number_format($category->price) }} VND</del>
                            <span class="text-danger">{{ number_format($category->sale_price) }} VND</span>
                        </p>
                    @else
                        <p>{{ number_format($category->price) }} VND</p>
                    @endif

                    {{-- Thêm vào giỏ hàng hoặc thông báo hết hàng --}}
                    @if ($category->status !== 'Hết hàng')
                        <form action="{{ route('cart.add', $category->slug) }}" method="POST">
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
</div>


<!-- Sản phẩm thông thường (không giảm giá) -->
<div class="row">
    <div class="heading-line"><h2>CÁC SẢN PHẨM KHÁC</h2></div>
    <div class="row-product-section" id="regular-product-list">
        @include('partials.product-items', ['products' => $regularProducts])
    </div>
    <div class="text-center mt-3">
        <button id="load-more-regular" class="btn btn-outline-primary" data-offset="6">Xem thêm</button>
    </div>
</div>


@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const slider = document.querySelector(".banner-slider");
    const images = document.querySelectorAll(".banner-slider img");
    let index = 0;
    const imageWidth = images[0].offsetWidth + 10; // Chiều rộng ảnh + gap (10px)

    setInterval(() => {
            index++;
            if (index >= images.length) { // Khi chạy hết ảnh, quay lại ảnh đầu
                index = 0;
            }
            slider.style.transform = `translateX(${-index * imageWidth}px)`;
        }, 4000); // Chuyển ảnh sau mỗi 4 giây
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1800
        });
    @endif
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const loadMoreLink = document.getElementById('load-more-regular');
    
    if (loadMoreLink) { // Kiểm tra phần tử tồn tại
        loadMoreLink.addEventListener('click', function (event) {
            event.preventDefault(); // Ngăn không cho link chuyển hướng (mặc định của thẻ <a>)

            const link = this;
            let offset = parseInt(link.getAttribute('data-offset'));

            fetch(`/load-more?type=regular&offset=${offset}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html.trim()) {
                        document.getElementById('regular-product-list').insertAdjacentHTML('beforeend', data.html);
                        link.setAttribute('data-offset', offset + 6);
                    } else {
                        link.remove(); // Không còn sản phẩm thì ẩn nút
                    }
                })
                .catch(error => console.error('Lỗi khi tải thêm sản phẩm:', error));
        });
    }
});

</script>


<style>
        .row-product-section {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Chia làm 4 cột */
            text-align: center; /* Căn giữa nội dung */
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 40px;
            
        }

        .col-item {
            border-radius: 5px;
            padding: 20px;
            margin: 15px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            
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
            color: #999;
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

        h2 {
            font-family: 'Times New Roman', serif;
        }
        .heading-line {
            
            margin: 0px 0; /* Khoảng cách phía trên và dưới */
            text-align: center; /* Căn giữa nội dung */
            position: relative; /* Để định vị đường kẻ */
        }
        .heading-line h2 {
            display: inline-block; /* Để tiêu đề nằm giữa */
            position: relative; /* Để định vị đường kẻ dưới tiêu đề */
            padding: 10px 20px; /* Khoảng cách xung quanh tiêu đề */
            background: #ffffff; /* Màu nền cho tiêu đề */
            z-index: 1; /* Đưa tiêu đề lên trên đường kẻ */
            color: #b39851; /* Màu chữ (thay đổi màu ở đây) */
        }
        .heading-line::after {
            content: ""; /* Nội dung rỗng cho pseudo-element */
            position: absolute; /* Định vị tuyệt đối */
            left: 0; /* Bắt đầu từ bên trái */
            right: 0; /* Kết thúc bên phải */
            top: 50%; /* Đặt ở giữa chiều cao */
            height: 2px; /* Chiều cao của đường kẻ */
            background-color: #B0976D; /* Màu của đường kẻ */
            z-index: 0; /* Đưa đường kẻ xuống dưới tiêu đề */
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
        .product-title, .btn-outline-primary {
            pointer-events: auto; /* Mặc định cho sản phẩm có sẵn */
        }

        .product-title.text-muted, .btn-secondary {
            pointer-events: none; /* Vô hiệu hóa click cho sản phẩm hết hàng */
        }

        .product-out-of-stock {
            opacity: 0.5;
            pointer-events: none; /* Vô hiệu hóa click */
        }

        .product-in-stock {
            opacity: 1;
        }

    </style>
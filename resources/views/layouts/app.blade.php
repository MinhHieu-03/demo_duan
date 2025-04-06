<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Your Application')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0f0f0; /* Màu xám nền ngoài */
        }
        .container {
            background-color: white; /* Nền trắng cho phần nội dung */
            padding: 20px;
            border-radius: 10px; /* Bo góc nhẹ cho đẹp */
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .navbar {
            background-color: #8C367B !important; /* Màu nền tím hồng */
        }

        /* Màu chữ trắng để dễ đọc */
        .navbar-nav .nav-link, 
        .navbar-brand {
            color: #FFFFFF !important; 
        }

        /* Hiệu ứng hover - vàng nhạt */
        .navbar-nav .nav-link:hover {
            color: #FFE066 !important;
            transition: all 0.5s;
        }

        /* Nút tìm kiếm nổi bật */
        .input-group .form-control {
            background-color: #8C367B;
            color: #FFFFFF;
            border: 1px solid #FFE066;
            height: 36px; /* Điều chỉnh chiều cao */
            padding: 5px 10px; /* Giảm padding */
            font-size: 14px; /* Thu nhỏ chữ nếu cần */
        }

        .input-group {
            margin-top: 17px;
        }

        .input-group .btn {
            background-color: #FFE066;
            color: #8C367B;
            height: 36px; /* Đồng bộ chiều cao với ô nhập */
            padding: 5px 10px;
        }

        .input-group .btn:hover {
            background-color: #FFD43B;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Đổi màu placeholder thành trắng */
        ::placeholder { 
            color: white !important; 
            opacity: 1; /* Đảm bảo màu hiển thị rõ ràng */
        }

        /* Badge thông báo */
        .badge-light {
            background: #ffc107;
            color: #333;
            font-size: 0.8rem;
            padding: 5px 8px;
            border-radius: 10px;
        }

        /* Định dạng cho chữ nhỏ */
        .text-muted {
            font-size: 0.8rem;
            color: #666 !important;
        }

        /* Giúp dropdown hiển thị đúng */
        .navbar-nav {
            display: block;
        }

        .ms-3 a {
            text-decoration: none; /* Bỏ gạch chân */
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .ms-3 a:hover {
            color: #ffcc00 !important; /* Màu vàng khi hover */
            transform: scale(1.1); /* Hiệu ứng phóng to nhẹ */
        }
        .dropdown-submenu {
            position: relative;
        }
        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
            display: none;
            position: absolute;
        }
        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }
        .dropdown-item img {
            margin-left: 10px;
        }
        .dropdowns:hover > .dropdown-menu {
            display: block;
        }
        .text-decoration-none{
            color: #8C367B;
        }
    </style>

</head>
<body>
    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <!-- Logo -->
            <h2><a class="navbar-brand text-white">LAPTOP 19 STORE</a></h2>

            <!-- Toggle Button cho màn hình nhỏ -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu chính -->
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav mx-auto d-flex justify-content-center align-items-center">
                    <!-- Home Link -->
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="{{ route('home') }}">
                            <i class="fas fa-home me-2"></i> Trang chủ
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-th-large"></i> Danh mục
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <!-- Hãng -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">Hãng</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Dell') }}">Dell <img width="25" height="25" src="{{ asset('uploads/categories/Dell_cate_thumb_ea17554f71.png') }}" alt="Dell"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Asus') }}">Asus <img width="25" height="25" src="{{ asset('uploads/categories/asus_cate_thumb_d68adeadd5.png') }}" alt="Asus"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'HP') }}">HP <img width="25" height="25" src="{{ asset('uploads/categories/hp_victus_cate_thumb_b1463370e0 (1).png') }}" alt="HP"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Lenovo') }}">Lenovo <img width="25" height="25" src="{{ asset('uploads/categories/lenovo_legion_gaming_cate_thumb_190fd329d7.png') }}" alt="Lenovo"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Gaming') }}">Gaming <img width="25" height="25" src="{{ asset('uploads/categories/msi-thin-15-b12ucx-i5-2046vn-thumb-600x600.jpg') }}" alt="Gaming"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Acer') }}">Acer <img width="25" height="25" src="{{ asset('uploads/categories/Acer_cate_thumb_84b37b3b6f.png') }}" alt="Acer"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Macbook') }}">Macbook <img width="25" height="25" src="{{ asset('uploads/categories/Apple_macbook_cate_thumb_cbe3eadf9e.png') }}" alt="Macbook"></a></li>
                                </ul>
                            </li>
                            
                            <!-- Phụ kiện -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">Phụ kiện</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Chuột') }}">Chuột <img width="25" height="25" src="{{ asset('uploads/categories/tải xuống.png') }}" alt="Chuột"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Bàn phím') }}">Bàn phím <img width="25" height="25" src="{{ asset('uploads/categories/icon_ban_phim_co_c8ed3b2e8f.png') }}" alt="Bàn phím"></a></li>
                                    <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('category.filter', 'Túi') }}">Túi <img width="25" height="25" src="{{ asset('uploads/categories/Tui-laptop-Stargo-Ledger.webp') }}" alt="Túi"></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="{{ route('laptop.introduction') }}">
                            <i class="fas fa-info-circle me-2"></i> Về chúng tôi
                        </a>
                    </li>

                    <!-- Tìm kiếm -->
                    <li class="">
                        <form action="{{ route('search') }}" method="GET" class="">
                            <div class="input-group ">
                                <input type="text" name="query" class="form-control" placeholder="Tìm kiếm sản phẩm..." aria-label="Tìm kiếm">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>

                    <!-- Hồ sơ người dùng -->
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="{{ route('user.profile') }}">
                            <i class="fas fa-user me-2"></i> Tài khoản
                        </a>
                    </li>

                    <ul class="navbar-nav ml-auto">
                    @auth
                        <li class="nav-item dropdowns">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <i class="fas fa-bell"></i> <!-- Icon chuông -->
                                <span class="badge badge-light">{{ auth()->user()->unreadNotifications->count() }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @forelse (auth()->user()->unreadNotifications as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="dropdown-item">
                                        {{ $notification->data['message'] }}
                                        <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>
                                @empty
                                    <a href="#" class="dropdown-item">Không có thông báo</a>
                                @endforelse
                            </div>
                        </li>
                    @endauth
                </ul>
                
                    <!-- Kiểm tra trạng thái đăng nhập -->
                    <li class="nav-item">
                        @if (Auth::check())
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger nav-link d-flex align-items-center" style="border: none; background: none; color: white; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                </button>
                            </form>
                        @else
                            <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                            </a>
                        @endif
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" href="{{ route('messages.index') }}">
                            <i class="fas fa-envelope me-2"></i> Đổi trả
                        </a>
                    </li>
                </ul>
                
                

                <!-- Giỏ hàng -->
                <div class="ms-3">
                    @auth
                        <a href="{{ route('cart.index') }}" class="text-white d-flex align-items-center">
                        <i class="fas fa-shopping-cart" style="font-size: 1.5rem;"></i>
                        Giỏ hàng<span class="ms-2"></span>
                        </a>
                    @else
                    <a href="{{ route('login') }}" class="text-white d-flex align-items-center">
                        <i class="fas fa-shopping-cart" style="font-size: 1.5rem;"></i>
                        <span class="ms-2"></span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Footer hỗ trợ -->
    <footer class=" py-4">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4 ">
                <!-- Cột 1: Liên hệ -->
                <div class="col">
                    <h5 class="fw-bold border-bottom pb-2"><i class="fas fa-headset me-2"></i>LIÊN HỆ</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-store me-2"></i> Laptop - Store</li>
                        <li><i class="fas fa-phone-alt me-2"></i> Tư vấn: <a href="tel:0987654321" class=" text-decoration-none">098.765.43.21</a></li>
                        <li><i class="fas fa-envelope me-2"></i> Email: <a href="mailto:laptopstore@gmail.com" class=" text-decoration-none">laptopstore@gmail.com</a></li>
                    </ul>
                </div>

                <!-- Cột 2: Hỗ trợ -->
                <div class="col">
                    <h5 class="fw-bold border-bottom pb-2"><i class="fas fa-info-circle me-2"></i>HỖ TRỢ</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class=" text-decoration-none footer-link">Giới thiệu</a></li>
                        <li><a href="#" class=" text-decoration-none footer-link">Liên hệ</a></li>
                        <li><a href="#" class=" text-decoration-none footer-link">Khuyến mãi</a></li>
                        <li><a href="#" class=" text-decoration-none footer-link">Phương thức thanh toán</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Mua hàng -->
                <div class="col">
                    <h5 class="fw-bold border-bottom pb-2"><i class="fas fa-shopping-cart me-2"></i>MUA HÀNG</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class=" text-decoration-none footer-link">Giỏ hàng</a></li>
                        <li><a href="#" class=" text-decoration-none footer-link">Đổi trả sản phẩm</a></li>
                        <li><a href="#" class=" text-decoration-none footer-link">Giao hàng tại Hà Nội</a></li>
                        <li><a href="#" class=" text-decoration-none footer-link">Giao hàng toàn quốc</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Theo dõi chúng tôi -->
                <div class="col">
                    <h5 class="fw-bold border-bottom pb-2"><i class="fas fa-share-alt me-2"></i>THEO DÕI CHÚNG TÔI</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class=" fs-4"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class=" fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class=" fs-4"><i class="fab fa-twitter"></i></a>
                        <a href="#" class=" fs-4"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- Bản quyền -->
            <div class="text-center mt-4 border-top pt-3">
                <p class="mb-0">© 2025 Laptop Store. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

     <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<style>
    /* Cố định sidebar */
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: #343a40;
        padding-top: 20px;
        color: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar h2 {
        text-align: center;
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 30px;
    }

    .sidebar .nav-link {
        color: white;
        padding: 12px 20px;
        display: block;
        font-size: 1.1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover {
        background: #495057;
        text-decoration: none;
        border-radius: 5px;
    }

    .content {
        margin-left: 270px;
        padding: 20px;
    }

    /* Badge thông báo */
    .badge-light {
        background: #ffc107;
        color: #333;
        font-size: 0.9rem;
        padding: 6px 10px;
        border-radius: 10px;
    }

    /* Định dạng cho chữ nhỏ */
    .text-muted {
        font-size: 0.85rem;
        color: #666 !important;
    }

    /* Giúp dropdown hiển thị đúng */
    .navbar-nav .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 220px;
            position: fixed;
            left: -220px;
            transition: left 0.3s ease;
        }

        .sidebar.show {
            left: 0;
        }

        .content {
            margin-left: 0;
        }

        .sidebar-toggler {
            display: block;
        }
    }

    /* Toggler button */
    .sidebar-toggler {
        display: none;
        font-size: 1.5rem;
        background-color: #343a40;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 50%;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1000;
    }
</style>
<body>
    <button class="sidebar-toggler" onclick="toggleSidebar()">☰</button>

    <div class="d-flex">
        <!-- Sidebar Menu -->
        <div class="sidebar">
            <h2>ADMIN MENU</h2>
            <ul class="nav flex-column">
                <li><a href="{{ url('/admin/revenue-report') }}" class="nav-link font-weight-bold">📊 Quản lý Thống kê</a></li>
                <li><a href="{{ url('/categories') }}" class="nav-link font-weight-bold">📦 Quản lý Sản phẩm</a></li>
                <li><a href="{{ url('/admin/orders') }}" class="nav-link">🛒 Quản lý Đơn hàng</a></li>
                <li><a href="{{ route('admin.messages.index') }}" class="nav-link">✉️ Tin nhắn</a></li>
                
                <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            Thông báo
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

                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-danger border-0 bg-transparent">
                            🚪 Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Nội dung chính -->
        <div class="content w-100">
            <main>
                @yield('content')
            </main>

            <footer>
                <p>© 2024 ADMIN</p>
            </footer>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
    </script>
</body>
</html>

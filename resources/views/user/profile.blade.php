@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    @if (Auth::check())
        <div class="card p-4 shadow-lg" style="max-width: 500px; width: 100%; border-radius: 15px;">
            <h3 class="text-center mb-4">Thông Tin Khách Hàng</h3>

            <form action="{{ route('user.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tên -->
                <div class="mb-3 position-relative">
                    <label class="form-label fw-bold">Tên:</label>
                    <div class="input-group">
                        <span id="name" class="form-control bg-light border-0 text-dark" >{{ Auth::user()->name }}</span>
                        <input type="text" id="edit-name" name="name" value="{{ Auth::user()->name }}" class="form-control visually-hidden">
                        <button type="button" id="edit-name-btn" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <!-- Địa chỉ -->
                <div class="mb-3 position-relative">
                    <label class="form-label fw-bold">Địa chỉ:</label>
                    <div class="input-group">
                        <span id="address" class="form-control bg-light border-0 text-dark">{{ Auth::user()->address }}</span>
                        <input type="text" id="edit-address" name="address" value="{{ Auth::user()->address }}" class="form-control visually-hidden">
                        <button type="button" id="edit-address-btn" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <!-- Số điện thoại -->
                <div class="mb-3 position-relative">
                    <label class="form-label fw-bold">Số điện thoại:</label>
                    <div class="input-group">
                        <span id="phone" class="form-control bg-light border-0 text-dark">{{ Auth::user()->phone_number }}</span>
                        <input type="text" id="edit-phone" name="phone_number" value="{{ Auth::user()->phone_number }}" class="form-control visually-hidden">
                        <button type="button" id="edit-phone-btn" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <!-- Nút lưu -->
                <div class="text-center">
                    <button type="submit" id="save-btn" class="btn btn-success visually-hidden">Lưu</button>
                </div>
            </form>

            <!-- Các nút điều hướng -->
            <div class="mt-4 text-center">
                <a href="{{ url('/cart') }}" class="btn btn-info">🛒 Giỏ Hàng</a>
                <a href="{{ route('my.orders') }}" class="btn btn-secondary">📦 Đơn Hàng</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">🚪 Đăng xuất</button>
                </form>
            </div>

            <!-- Đổi mật khẩu -->
            <h2 class="text-center mt-4">Đổi Mật Khẩu</h2>

            @if (session('success'))
                <div class="alert alert-success ">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger ">
                    <ul class="mb-0 ">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card p-4 mt-3 shadow-sm " style="border-radius: 10px;">
                <form action="{{ route('user.update.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Đổi mật khẩu -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mật khẩu:</label>
                        <div class="input-group">
                            <span id="password" class="form-control bg-light border-0">********</span>
                            <input type="password" id="current-password" name="current_password" class="form-control visually-hidden mt-2" placeholder="Mật khẩu hiện tại" required>
                            <input type="password" id="new-password" name="new_password" class="form-control visually-hidden mt-2" placeholder="Mật khẩu mới" required>
                            <input type="password" id="confirm-password" name="new_password_confirmation" class="form-control visually-hidden mt-2" placeholder="Xác nhận mật khẩu mới" required>
                            <button type="button" id="edit-password-btn" class="btn btn-outline-primary">
                                <i class="fas fa-key"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Nút lưu -->
                    <div class="text-center">
                        <button type="submit" id="save-password-btn" class="btn btn-success visually-hidden">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
        <div class="text-center">
            <h3>Bạn chưa đăng nhập</h3>
            <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Đăng ký</a>
        </div>
    @endif
</div>

<!-- Script xử lý sửa thông tin -->
<script>
    function toggleEdit(field) {
        document.getElementById(field).classList.add('visually-hidden');
        document.getElementById(`edit-${field}`).classList.remove('visually-hidden');
        document.getElementById('save-btn').classList.remove('visually-hidden');
    }

    document.getElementById('edit-name-btn').addEventListener('click', () => toggleEdit('name'));
    document.getElementById('edit-address-btn').addEventListener('click', () => toggleEdit('address'));
    document.getElementById('edit-phone-btn').addEventListener('click', () => toggleEdit('phone'));

    document.getElementById('edit-password-btn').addEventListener('click', function() {
        document.getElementById('password').classList.add('visually-hidden');
        ['current-password', 'new-password', 'confirm-password'].forEach(id => {
            document.getElementById(id).classList.remove('visually-hidden');
        });
        document.getElementById('save-password-btn').classList.remove('visually-hidden');
    });
</script>
@endsection
<style>
    .input-group {
            margin-top: 17px;
        }
</style>
@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 fw-bold">Đăng ký tài khoản</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label"><i class="fas fa-user"></i> Họ và tên</label>
                            <div class="input-group ">
                                <input id="name" type="text" name="name" class="form-control bg-white border-dark " required  placeholder="Nhập tên của bạn">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                            <div class="input-group">
                                <input id="email" type="email" name="email" class="form-control bg-white border-dark" required placeholder="Nhập email">
                            </div>
                        </div>

                        <div class="col-md-6 position-relative">
                            <label for="password" class="form-label"><i class="fas fa-lock"></i> Mật khẩu</label>
                            <div class="input-group">
                                <input id="password" type="password" name="password" class="form-control bg-white border-dark" required placeholder="Nhập mật khẩu">
                                <button type="button" class="btn btn-outline-secondary toggle-password bg-white" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 position-relative">
                            <label for="password_confirmation" class="form-label"><i class="fas fa-key"></i> Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control bg-white border-dark" required placeholder="Nhập lại mật khẩu">
                                <button type="button" class="btn btn-outline-secondary toggle-password bg-white" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="address" class="form-label"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                            <div class="input-group">
                                <input id="address" type="text" name="address" class="form-control bg-white border-dark" required placeholder="Nhập địa chỉ">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="phone_number" class="form-label"><i class="fas fa-phone"></i> Số điện thoại</label>
                            <div class="input-group">
                                <input id="phone_number" type="text" name="phone_number" class="form-control bg-white border-dark" required pattern="[0-9]{10,11}" placeholder="Nhập số điện thoại">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-3 text-white" style="background-color: brown; border: none;">Đăng ký ngay</button>
                        </div>

                        <p class="text-center mt-3">
                            Đã có tài khoản? 
                            <a href="{{ route('login') }}" class="text-primary fw-bold" style="text-decoration: none;">Đăng nhập</a>
                        </p>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript để bật/tắt hiển thị mật khẩu --}}
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            let target = document.getElementById(this.dataset.target);
            if (target.type === "password") {
                target.type = "text";
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                target.type = "password";
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });
</script>
@endsection
<style>
    .input-group {
        margin-top: 17px;
    }
    
    input::placeholder {
    color: black !important;
    }

    input {
        color: black !important;
    }

    .toggle-password {
        color: black !important;
    }

</style>
@extends('layouts.app')

@section('content')
<div class=" d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 fw-bold">Đăng Nhập</h2>

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

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                        <div class="input-group">
                            <input id="email" type="email" name="email" class="form-control" required placeholder="Nhập email">
                        </div>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label"><i class="fas fa-lock"></i> Mật khẩu</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg w-100 mt-3 text-white" style="background-color: brown; border: none;">Đăng Nhập</button>

                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Đăng ký tài khoản</a> |
                        <a href="#" class="text-danger text-decoration-none">Quên mật khẩu?</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript để hiện/ẩn mật khẩu --}}
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
    .form-control {
        background-color: white !important;
        border: 1px solid black !important;
        color: black !important;
    }
    .form-control::placeholder {
        color: #333 !important;
        opacity: 0.7;
    }
    .input-group .btn-outline-secondary {
        border: 1px solid black;
    }
    .toggle-password {
        background-color: transparent !important;
        color: black !important;
    }
</style>
@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6">
            @if ($category->image)
                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded shadow">
            @else
                <p class="text-danger">Không có hình ảnh</p>
            @endif
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $category->name }}</h2>
            <strong>Chi tiết:</strong>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{!! $category->description !!}</li>
            </ul>
            @if($category->sale_price && $category->sale_price < $category->price)
                <p class="fw-bold mt-3">
                    <del class="text-muted">{{ number_format($category->price) }} VND</del>
                    <span class="text-danger">{{ number_format($category->sale_price) }} VND</span>
                </p>
            @else
                <p class="fw-bold mt-3 text-danger">Giá: {{ number_format($category->price) }} VND</p>
            @endif

            <!-- Nhóm nút mua hàng -->
            <div class="btn-group" role="group">
                <form action="{{ route('cart.add', $category->slug) }}" method="POST" class="me-2">
                    @csrf
                    <input type="hidden" name="buy_now" value="1">
                    <button type="submit" class="btn btn-successs">Mua Ngay</button>
                </form>

                <form action="{{ route('cart.add', $category->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Phần Bình luận -->
    <div class="row mt-5">
        <div class="col-md-5">
            <h3 class="fw-bold">Bình luận</h3>
            @if ($category->comments->count() > 0)
                <div class="list-group">
                    @foreach($category->comments as $comment)
                        <div class="list-group-item">
                            <strong class="d-block">{{ $comment->name }}</strong>
                            <p class="mb-1 text-danger">{{ $comment->comment }}</p>
                            <small class="text-muted">{{ $comment->created_at }}</small>
                            @if ($comment->admin_reply)
                                <div class="border-start border-primary ps-3 mt-2 bg-light">
                                    <strong>Admin Phản Hồi:</strong>
                                    <p>{{ $comment->admin_reply }}</p>
                                </div>
                            @endif

                            @if (auth()->check() && auth()->user()->isAdmin())
                                <form action="{{ route('comments.reply', $comment->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <label for="admin_reply" class="form-label">Phản Hồi:</label>
                                    <textarea class="form-control" id="admin_reply" name="admin_reply" rows="2" required>{{ old('admin_reply') }}</textarea>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Gửi Phản Hồi</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-danger">Không có bình luận nào</p>
            @endif
        </div>

        <!-- Thêm bình luận -->
        <div class="col-md-7">
            <h3 class="fw-bold">Thêm bình luận:</h3>
            <form action="{{ route('comments.store', $category->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Tên:</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ auth()->check() ? auth()->user()->name : 'Khách' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Bình luận:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primarys">Gửi</button>
            </form>
        </div>
    </div>
</div>
@endsection
<style>
    .input-group {
        margin-top: 17px;
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
        .btn-successs {
            background-color: #8C367B !important;
            color: white !important;
        }
        .btn-successs:hover {
            background-color: #8C367B !important;
            color: white !important;
            transform: scale(1.05); /* Làm nút to lên một chút khi hover */
        }

        .btn-primarys {
            background-color: #8C367B !important;
            color: white !important;
        }
        .btn-primarys:hover {
            background-color: #8C367B !important;
            color: white !important;
            transform: scale(1.05); /* Làm nút to lên một chút khi hover */
        }
</style>
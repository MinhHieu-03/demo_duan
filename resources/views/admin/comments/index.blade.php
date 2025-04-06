@extends('layouts.admin')

@section('content')
<div class="container mt-5 mb-5">
    <!-- Thông tin sản phẩm -->
    <div class="row">
        <div class="col-md-6">
            @if ($category && $category->image)
                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid">
            @else
                <p>Không có hình ảnh</p>
            @endif
        </div>
        <div class="col-md-6">
            @if ($category)
                <h2>{{ $category->name }}</h2>
                <strong>Chi tiết:</strong>
                <ul>
                    <li>{!! $category->description !!}</li>
                </ul>
                <p><strong>Giá:</strong> {{ number_format($category->price) }} VND</p>
            @else
                <p>Sản phẩm không tồn tại.</p>
            @endif
        </div>
    </div>

    <!-- Phần bình luận -->
    <div class="row mt-5">
        <div class="col-md-12 review">
            <h3>Bình luận</h3>
            @if ($category && $category->comments && $category->comments->count() > 0)
                @foreach($category->comments as $comment)
                    <div class="card mb-2">
                        <div class="card-body">
                            <strong>{{ optional($comment->user)->name ?? $comment->name ?? 'Khách' }}</strong>
                            <p>{{ $comment->comment }}</p>
                            <small>{{ $comment->created_at->format('d/m/Y H:i') }}</small>

                            @if ($comment->admin_reply)
                                <div class="admin-reply">
                                    <strong>Admin Phản Hồi:</strong>
                                    <p>{{ $comment->admin_reply }}</p>
                                </div>
                            @endif

                            @if (auth()->check() && auth()->user()->isAdmin())
                                <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="admin_reply_{{ $comment->id }}" class="form-label">Phản Hồi:</label>
                                        <textarea class="form-control" id="admin_reply_{{ $comment->id }}" name="admin_reply" rows="2" required>{{ old('admin_reply') }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Gửi Phản Hồi</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p>Không có bình luận nào</p>
            @endif

            <!-- Form thêm bình luận -->
            <div class="add-review mt-4">
                <h3>Thêm bình luận:</h3>
                <form action="{{ route('comments.store', $category->id ?? 0) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ auth()->check() ? auth()->user()->name : 'Khách' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Bình luận:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required>{{ old('comment') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- CSS Styles -->
<style>
    /* Căn chỉnh khoảng cách cho container */
    .container {
        margin-top: 50px;
        margin-bottom: 50px;
    }

    /* Phong cách cho phần bình luận */
    .review {
        margin-top: 20px;
    }
    .review h3 {
        margin-bottom: 20px;
    }

    /* Phong cách cho thẻ card */
    .card {
        margin-bottom: 15px;
    }

    .card-body {
        padding: 15px;
    }

    .card-body strong {
        display: block;
        margin-bottom: 5px;
    }

    .card-body p {
        margin-bottom: 5px;
    }

    .card-body small {
        display: block;
        margin-top: 5px;
        color: gray;
    }

    /* Phong cách cho phần phản hồi của admin */
    .admin-reply {
        margin-top: 15px;
        padding: 10px;
        background-color: #f8f9fa;
        border-left: 3px solid #007bff;
    }

    /* Phong cách cho form thêm bình luận */
    .add-review {
        margin-top: 30px;
    }

    .add-review h3 {
        margin-bottom: 15px;
    }

    .add-review .form-control {
        margin-bottom: 10px;
    }

    .add-review button {
        margin-top: 10px;
    }
</style>

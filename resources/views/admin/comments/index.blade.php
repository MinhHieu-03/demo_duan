@extends('layouts.admin')

@section('content')
<div class="container mt-5 mb-5">
    <!-- Tiêu đề -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Quản lý bình luận</h2>
            <p class="text-muted text-center">Danh sách các bình luận từ khách hàng</p>
        </div>
    </div>

    <!-- Bình luận mới nhất -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h4 class="mb-3">Bình luận mới nhất</h4>
            @if ($newComments && $newComments->count() > 0)
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Bình luận</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newComments as $index => $comment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ optional($comment->user)->name ?? $comment->name ?? 'Khách' }}</td>
                                <td>{{ $comment->category->name ?? 'Không xác định' }}</td>
                                <td>
                                    @if (!empty($comment->category->image))
                                        <img src="{{ asset($comment->category->image) }}" 
                                            alt="{{ $comment->category->name }}" 
                                            class="img-thumbnail" 
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $comment->comment }}</td>
                                <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <!-- Nút phản hồi -->
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal_{{ $comment->id }}">Phản hồi</button>

                                    
                                </td>
                            </tr>

                            <!-- Modal phản hồi -->
                            <div class="modal fade" id="replyModal_{{ $comment->id }}" tabindex="-1" aria-labelledby="replyModalLabel_{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="replyModalLabel_{{ $comment->id }}">Phản hồi bình luận</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="admin_reply_{{ $comment->id }}" class="form-label">Nội dung phản hồi:</label>
                                                    <textarea class="form-control" id="admin_reply_{{ $comment->id }}" name="admin_reply" rows="3" required>{{ old('admin_reply', $comment->admin_reply) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-muted">Không có bình luận mới.</p>
            @endif
        </div>
    </div>

    <!-- Bình luận đã phản hồi -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="mb-3">Bình luận đã phản hồi</h4>
            @if ($repliedComments && $repliedComments->count() > 0)
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Bình luận</th>
                            <th>Ngày tạo</th>
                            <th>Phản hồi của Admin</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repliedComments as $index => $comment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ optional($comment->user)->name ?? $comment->name ?? 'Khách' }}</td>
                                <td>{{ $comment->category->name ?? 'Không xác định' }}</td>
                                
                                <td>
                                    @if (!empty($comment->category->image))
                                        <img src="{{ asset($comment->category->image) }}" 
                                            alt="{{ $comment->category->name }}" 
                                            class="img-thumbnail" 
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $comment->comment }}</td>
                                <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="bg-light p-2 rounded">
                                        {{ $comment->admin_reply }}
                                    </div>
                                </td>
                                <td>
                                    <!-- Nút phản hồi -->
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal_{{ $comment->id }}">Phản hồi</button>
                                    <!-- Nút xóa -->
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">Xóa</button>
                                    </form>
                                    
                                </td>
                            </tr>
                            <!-- Modal phản hồi -->
                            <div class="modal fade" id="replyModal_{{ $comment->id }}" tabindex="-1" aria-labelledby="replyModalLabel_{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="replyModalLabel_{{ $comment->id }}">Phản hồi bình luận</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="admin_reply_{{ $comment->id }}" class="form-label">Nội dung phản hồi:</label>
                                                    <textarea class="form-control" id="admin_reply_{{ $comment->id }}" name="admin_reply" rows="3" required>{{ old('admin_reply', $comment->admin_reply) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-muted">Không có bình luận đã phản hồi.</p>
            @endif
        </div>
    </div>
</div>
@endsection

<!-- CSS Styles -->
<style>
    .table th, .table td {
        vertical-align: middle;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #343a40;
        color: white;
    }

    .modal-footer .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .modal-footer .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

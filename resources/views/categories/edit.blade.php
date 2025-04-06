@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <!-- Phần tiêu đề -->
        <div class="col-lg-4 col-md-5 col-12 text-center mb-4">
            <h2 class="fw-bold text-dark">Chỉnh Sửa Sản Phẩm</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary mt-3">← Quay lại</a>
        </div>

        <!-- Phần form nhập -->
        <div class="col-lg-6 col-md-7 col-12">
            <div class="card shadow p-4">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên sản phẩm:</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-bold">Giá:</label>
                            <input type="number" class="form-control" name="price" id="price" value="{{ $category->price }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sale_price" class="form-label fw-bold">Giá giảm (nếu có):</label>
                            <input type="number" class="form-control" name="sale_price" id="sale_price" value="{{ $category->sale_price ?? '' }}" placeholder="Nhập giá giảm">
                        </div>
                    </div>

                    <!-- Trường trạng thái (Còn hàng / Hết hàng) -->
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Trạng thái:</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Còn hàng" {{ $category->status === 'Còn hàng' ? 'selected' : '' }}>Còn hàng</option>
                            <option value="Hết hàng" {{ $category->status === 'Hết hàng' ? 'selected' : '' }}>Hết hàng</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả:</label>
                        <textarea class="form-control" name="description" id="description" rows="3" required>{{ $category->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh hiện tại:</label><br>
                        @if ($category->image)
                            <div class="text-center">
                                <img src="{{ asset($category->image) }}" class="img-thumbnail" width="120" height="120" alt="{{ $category->name }}">
                            </div>
                        @else
                            <p>Không có hình ảnh</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Chọn hình ảnh mới:</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100">Cập Nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

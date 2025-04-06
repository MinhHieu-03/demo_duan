@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <!-- Phần tiêu đề -->
        <div class="col-lg-4 col-md-5 col-12 text-center mb-4">
            <h2 class="fw-bold text-dark">Thêm sản phẩm</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary mt-3">← Quay lại</a>
        </div>

        <!-- Phần form nhập -->
        <div class="col-lg-6 col-md-7 col-12">
            <div class="card shadow p-4">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên sản phẩm:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-bold">Giá:</label>
                            <input type="number" class="form-control" name="price" value="{{ old('price') }}" required>
                            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sale_price" class="form-label fw-bold">Giá giảm (nếu có):</label>
                            <input type="number" class="form-control" name="sale_price" value="{{ old('sale_price') }}" placeholder="Nhập giá giảm">
                            @error('sale_price')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Trạng thái:</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Còn hàng" {{ old('status') == 'Còn hàng' ? 'selected' : '' }}>Còn hàng</option>
                            <option value="Hết hàng" {{ old('status') == 'Hết hàng' ? 'selected' : '' }}>Hết hàng</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Hình ảnh:</label>
                        <input type="file" class="form-control" name="image">
                        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100">Lưu sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

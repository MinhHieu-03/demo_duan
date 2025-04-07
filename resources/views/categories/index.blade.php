@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="d-flex justify-content-center">DANH SÁCH SẢN PHẨM</h1>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Form tìm kiếm bên trái -->
            <form id="searchForm" action="{{ route('categories.index') }}" method="GET" class="mb-0" style="max-width: 300px; width: 100%;">
                <div class="input-group">
                    <input id="searchInput" type="text" name="query" class="form-control" placeholder="Tìm kiếm sản phẩm..." aria-label="Tìm kiếm" value="{{ request('query') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Nút thêm sản phẩm bên phải -->
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                Thêm sản phẩm
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Giá</th>
                    <th>Giá giảm</th> <!-- Cột giá giảm -->
                    <th>Trạng thái</th> <!-- Thêm cột Status -->
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</a></td>
                        <td>{{ $category->description }}</td>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset($category->image) }}" class="img-thumbnail" width="100" height="100" alt="{{ $category->name }}">
                            @else
                                <p>Không có hình ảnh</p>
                            @endif
                        </td>
                        <td>{{ number_format($category->price, 0, ',', '.') }} VND</td>
                        
                        <!-- Hiển thị giá giảm nếu có -->
                        <td>
                            @if ($category->sale_price)
                                {{ number_format($category->sale_price, 0, ',', '.') }} VND
                            @else
                                <p>Không có giảm giá</p>
                            @endif
                        </td>

                        <!-- Hiển thị trạng thái -->
                        <td>{{ $category->status }}</td> <!-- Hiển thị cột Status -->

                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Ngăn hành vi mặc định
                searchForm.submit(); // Gửi form tìm kiếm
            }
        });
    });
</script>

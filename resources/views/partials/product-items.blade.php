@foreach ($products as $product)
    <div class="col-item {{ $product->status === 'Hết hàng' ? 'product-out-of-stock' : 'product-in-stock' }}">
        {{-- Hình ảnh --}}
        @if ($product->status !== 'Hết hàng')
            <a href="{{ route('categories.show', $product->slug) }}">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            </a>
        @else
            <div style="position: relative;">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="opacity-50">
                <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold bg-danger p-1 px-2 rounded">Hết hàng</div>
            </div>
        @endif

        <div class="product-attribute">
            {{-- Tên sản phẩm --}}
            @if ($product->status !== 'Hết hàng')
                <a href="{{ route('categories.show', $product->slug) }}" class="product-title">{{ $product->name }}</a>
            @else
                <span class="product-title text-muted">{{ $product->name }} (Hết hàng)</span>
            @endif

            {{-- Mô tả --}}
            <div class="text-attribute">
                <span>{{ Str::limit(strip_tags($product->description), 87) }}</span>
            </div>

            {{-- Giá --}}
            @if($product->sale_price && $product->sale_price < $product->price)
                <p>
                    <del>{{ number_format($product->price) }} VND</del>
                    <span class="text-danger">{{ number_format($product->sale_price) }} VND</span>
                </p>
            @else
                <p>{{ number_format($product->price) }} VND</p>
            @endif

            {{-- Nút thêm giỏ hàng --}}
            @if ($product->status !== 'Hết hàng')
                <form action="{{ route('cart.add', $product->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-block">Thêm vào giỏ hàng</button>
                </form>
            @else
                <button class="btn btn-secondary btn-block" disabled>Hết hàng</button>
            @endif
        </div>
    </div>
@endforeach

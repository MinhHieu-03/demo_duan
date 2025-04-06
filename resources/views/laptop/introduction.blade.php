@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <!-- Hình ảnh bên trái -->
            <div class="col-md-6 d-flex justify-content-center">
                <img src="{{ asset('uploads/banner/asus-voice-up_1280x805-800-resize.jpg') }}" 
                     alt="Laptop" 
                     class="img-fluid rounded shadow-lg w-100" 
                     style="max-height: 400px; object-fit: cover;">
            </div>

            <!-- Nội dung giới thiệu bên phải -->
            <div class="col-md-6">
                <h1 class="fw-bold">Giới thiệu về Laptop Store</h1>
                <p class="text-muted">
                    Chào mừng bạn đến với <strong>Laptop Store</strong> – địa chỉ tin cậy dành cho những ai đang tìm kiếm laptop chất lượng cao với giá cả hợp lý.
                </p>
                <p><strong>"Chất lượng tạo niềm tin"</strong> – Chúng tôi cam kết sản phẩm chính hãng, bảo hành uy tín và dịch vụ tận tình.</p>
                <p>Hàng ngàn khách hàng trên khắp cả nước đã tin tưởng chọn Laptop Store, từ sinh viên đến doanh nghiệp.</p>
            </div>
        </div>

        <!-- Thông tin sản phẩm và khách hàng -->
        <div class="row g-4 mt-5">
            <div class="col-md-6">
                <h2 class="fw-bold"><i class="fas fa-laptop me-2"></i>Các dòng sản phẩm đã bán:</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">✅ Laptop văn phòng: <strong>Dell, HP, Lenovo, Asus</strong></li>
                    <li class="list-group-item">✅ Laptop gaming: <strong>Acer Predator, MSI, ROG,...</strong></li>
                    <li class="list-group-item">✅ Laptop đồ họa: <strong>MacBook, Dell XPS,...</strong></li>
                    <li class="list-group-item">✅ Phụ kiện laptop: <strong>Chuột, bàn phím, balo, RAM, SSD</strong></li>
                </ul>
            </div>

            <div class="col-md-6">
                <h2 class="fw-bold"><i class="fas fa-users me-2"></i>Khách hàng tin tưởng:</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">✔️ Hơn <strong>10.000 khách hàng</strong> đã mua hàng.</li>
                    <li class="list-group-item">✔️ Hợp tác cùng <strong>doanh nghiệp, trường học</strong>.</li>
                    <li class="list-group-item">✔️ Được đánh giá <strong>5 sao</strong> nhờ sản phẩm chính hãng.</li>
                </ul>
            </div>
        </div>

        <!-- Thông tin liên hệ -->
        <div class="row mt-5 text-center">
            <div class="col-12">
                <h3><i class="fas fa-map-marker-alt"></i> <strong>123 Cầu Diễn</strong></h3>
                <h3><i class="fas fa-phone"></i> <strong>098 765 43 21</strong></h3>
                <h3>
                    <i class="fas fa-globe"></i> 
                    <a href="http://www.laptopstore.vn" target="_blank" class="text-decoration-none fw-bold text-primary">
                        www.laptopstore.vn
                    </a>
                </h3>
            </div>
        </div>
    </div>
@endsection
<style>
    .input-group {
            margin-top: 17px;
        }
</style>
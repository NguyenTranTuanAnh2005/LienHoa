<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<!-- Import Font -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .package-detail-container {
        font-family: 'Nunito', sans-serif;
    }
    
    .package-content {
        color: #4b5563;
        font-size: 1.05rem;
        line-height: 1.8;
    }
    
    /* Tuỳ chỉnh hiển thị nội dung từ TinyMCE */
    .package-content ul {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .package-content li {
        margin-bottom: 0.75rem;
    }
    .package-content p {
        margin-bottom: 1rem;
    }
    .package-content h1, .package-content h2, .package-content h3, .package-content h4 {
        color: #0d5c75;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    
    /* Sticky Card Style */
    .booking-card {
        background-color: #f0fdfa; /* Màu xanh nhạt */
        border-radius: 20px;
        position: sticky;
        top: 100px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
    }
    
    .booking-card .hospital-name {
        color: #0d5c75;
        font-weight: 700;
    }
    
    .btn-booking {
        background-color: #008b8b; /* Xanh ngọc đậm */
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-booking:hover {
        background-color: #006666;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 139, 139, 0.4);
    }
</style>

<div class="container my-5 package-detail-container">
    <!-- Breadcrumb (Tùy chọn) -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" class="text-decoration-none" style="color: #0d5c75;">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chi tiết gói khám</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Cột Trái: Nội dung chi tiết (Giới thiệu) -->
        <div class="col-lg-7 col-xl-8 pe-lg-5 mb-5 mb-lg-0">
            <h2 class="fw-bold mb-4" style="color: #0d5c75;">Giới thiệu</h2>
            
            <div class="package-content">
                <?php if (!empty($package['chi_tiet'])): ?>
                    <!-- Nội dung HTML từ CSDL -->
                    <?= $package['chi_tiet'] ?>
                <?php else: ?>
                    <!-- Fallback nếu gói khám chưa có nội dung chi tiết -->
                    <p><?= nl2br(htmlspecialchars($package['mo_ta'])) ?></p>
                    <p class="text-muted fst-italic mt-4">Nội dung chi tiết cho gói khám này đang được cập nhật...</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cột Phải: Thẻ Sticky Book Lịch -->
        <div class="col-lg-5 col-xl-4">
            <div class="card border-0 booking-card p-4 p-md-5">
                <div class="card-body p-0">
                    <!-- Tên gói khám -->
                    <h3 class="fw-bold mb-4 lh-base" style="color: #0d5c75;">
                        <?= htmlspecialchars($package['ten_goi']) ?>
                    </h3>
                    
                    <!-- Thông tin bệnh viện -->
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-geo-alt text-secondary fs-5 me-3"></i>
                        <div>
                            <span class="text-secondary me-2">Bệnh viện:</span>
                            <span class="hospital-name fs-6">Bệnh viện Liên Hoa</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-tag text-secondary fs-5 me-3"></i>
                        <div>
                            <span class="text-secondary me-2">Giá gói:</span>
                            <span class="hospital-name fs-5"><?= number_format($package['gia_tien'], 0, ',', '.') ?> VNĐ</span>
                        </div>
                    </div>

                    <!-- Nút Đặt lịch hẹn -->
                    <a href="<?= BASE_URL ?>/booking/package?package_id=<?= $package['id'] ?>" class="btn w-100 rounded-pill btn-booking py-3 px-4 fw-bold d-flex justify-content-between align-items-center fs-5">
                        <span>Đặt gói khám</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
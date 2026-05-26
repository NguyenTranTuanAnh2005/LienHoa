<?php include APP_DIR . '/views/layouts/header.php'; ?>

<style>
    /* CSS dành riêng cho trang thành công để tạo hiệu ứng hóa đơn */
    .invoice-wrapper {
        background-color: #f0f2f5;
        padding: 40px 0;
        min-height: 80vh;
    }
    .invoice-container { 
        max-width: 850px; 
        margin: 0 auto; 
        background: #fff; 
        padding: 40px; 
        border: 1px solid #dee2e6; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        position: relative;
    }
    .hospital-brand-title { color: #0d5c75; font-weight: 700; text-transform: uppercase; }
    .invoice-header-table { width: 100%; margin-bottom: 20px; }
    .qr-box { text-align: right; }
    .qr-box img { width: 90px; border: 1px solid #eee; padding: 5px; }
    
    /* Đường kẻ chấm chấm giống hóa đơn thật */
    .dotted-line { border-bottom: 1px dotted #ccc; padding: 8px 0; display: flex; justify-content: space-between; }
    .data-label { color: #555; }
    .data-value { font-weight: 600; color: #000; }

    /* Khung số thứ tự nổi bật */
    .highlight-box { 
        border: 2px solid #0d5c75; 
        padding: 25px; 
        text-align: center; 
        margin: 30px 0;
        border-radius: 8px;
        background-color: #f8fbfc;
    }

    @media print {
        .no-print, nav, footer { display: none !important; }
        .invoice-wrapper { padding: 0; background: none; }
        .invoice-container { border: none; box-shadow: none; width: 100%; max-width: 100%; }
    }
</style>

<div class="invoice-wrapper">
    <div class="container">
        <!-- Nút thao tác nhanh -->
        <div class="no-print text-center mb-4">
            <button onclick="window.print()" class="btn btn-outline-primary px-4 rounded-pill me-2">
                <i class="bi bi-printer me-2"></i>In phiếu khám
            </button>
            <a href="<?= BASE_URL ?>/" class="btn btn-primary px-4 rounded-pill" style="background-color: #0d5c75;">
                Quay lại trang chủ
            </a>
        </div>

        <div class="invoice-container">
            <!-- Phần đầu: Thông tin bệnh viện -->
            <table class="invoice-header-table">
    <tr>
        <td style="width: 70px;">
            <i class="bi bi-hospital" style="font-size: 50px; color: #0d5c75;"></i>
        </td>
        <td>
            <h4 class="hospital-brand-title mb-0">Bệnh viện Liên Hoa</h4>
            <p class="text-muted small mb-0">Hệ thống Y tế Chất lượng cao - Tinh hoa Y đức</p>
        </td>
        <td class="qr-box">
            <?php $bookingCode = 'GK' . date('Y') . str_pad($booking['id'] ?? 0, 4, '0', STR_PAD_LEFT); ?>
            <small class="d-block text-muted">Mã phiếu: <strong><?= $bookingCode ?></strong></small>
            <!-- Thẻ <img> đã được xóa bỏ tại đây -->
        </td>
    </tr>
</table>

            <hr>

            <!-- Tiêu đề chính -->
            <div class="text-center my-4">
                <h3 class="fw-bold mb-1">PHIẾU ĐĂNG KÝ GÓI KHÁM</h3>
                <p class="text-muted">Ngày <?= date('d/m/Y', strtotime($booking['ngay_tao'] ?? 'now')) ?> | Trạng thái: <span class="text-danger fw-bold">ĐÃ XÁC NHẬN</span></p>
            </div>

            <!-- Thông tin bệnh nhân -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="dotted-line"><span class="data-label">Họ và tên:</span> <span class="data-value"><?= mb_strtoupper($booking['ten_benh_nhan'] ?? '') ?></span></div>
                    <div class="dotted-line"><span class="data-label">Ngày sinh:</span> <span class="data-value"><?= date('d-m-Y', strtotime($booking['ngay_sinh'] ?? 'now')) ?></span></div>
                    <div class="dotted-line"><span class="data-label">Số điện thoại:</span> <span class="data-value"><?= $booking['so_dien_thoai'] ?? '' ?></span></div>
                </div>
                <div class="col-md-6">
                    <div class="dotted-line"><span class="data-label">Giới tính:</span> <span class="data-value"><?= $booking['gioi_tinh'] ?? '' ?></span></div>
                    <div class="dotted-line"><span class="data-label">Đối tượng:</span> <span class="data-value">Đăng ký Online (Gói khám)</span></div>
                    <div class="dotted-line"><span class="data-label">CCCD/CMND:</span> <span class="data-value"><?= $booking['cccd'] ?? '---' ?></span></div>
                </div>
            </div>

            <!-- Phần quan trọng nhất -->
            <div class="highlight-box">
                <h5 class="text-secondary mb-3">ĐỊA ĐIỂM KHÁM: <span class="text-dark fw-bold"><?= $booking['co_so_kham'] ?? 'Bệnh Viện Liên Hoa' ?></span></h5>
                <h4 class="mb-2">Ngày khám: <span class="text-primary"><?= date('d-m-Y', strtotime($booking['ngay_hen'] ?? 'now')) ?></span></h4>
                <div class="display-6 fw-bold mt-3 text-dark">Gói: <?= $booking['ten_goi_kham'] ?? '' ?></div>
                <p class="mt-2 mb-0 text-muted">Giá: <?= number_format($booking['gia_tien'] ?? 0, 0, ',', '.') ?> VND</p>
            </div>

            <!-- Chữ ký -->
            <div class="row mt-5 text-center">
                <div class="col-6">
                    <p class="mb-5">Bệnh nhân</p>
                    <p class="mt-4 fw-bold"><?= $booking['ten_benh_nhan'] ?? '' ?></p>
                </div>
                <div class="col-6">
                    <p class="mb-0 text-muted small">Thời gian in: <?= date('H:i d/m/Y') ?></p>
                    <p class="mb-5">Người thu (Ký tên)</p>
                    <p class="mt-4 fw-bold">BỆNH VIỆN LIÊN HOA</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_DIR . '/views/layouts/footer.php'; ?>

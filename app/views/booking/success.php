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
        margin: 25px 0;
        border-radius: 8px;
        background-color: #f8fbfc;
    }

    /* Bảng chi phí tối giản */
    .cost-summary {
        background: #fafafa;
        border-radius: 8px;
        padding: 15px;
        margin: 20px 0;
    }

    @media print {
        .no-print, nav, footer { display: none !important; }
        .invoice-wrapper { padding: 0; background: none; }
        .invoice-container { border: none; box-shadow: none; width: 100%; max-width: 100%; }
    }
</style>

<div class="invoice-wrapper">
    <div class="container">
        <div class="no-print text-center mb-4">
            <button onclick="window.print()" class="btn btn-outline-primary px-4 rounded-pill me-2">
                <i class="bi bi-printer me-2"></i>In phiếu khám
            </button>
            <a href="<?= BASE_URL ?>/" class="btn btn-primary px-4 rounded-pill" style="background-color: #0d5c75;">
                Quay lại trang chủ
            </a>
        </div>

        <div class="invoice-container">
            <table class="invoice-header-table">
                <tr>
                    <td style="width: 70px;">
                        <i class="bi bi-flower1" style="font-size: 50px; color: #0d5c75;"></i>
                    </td>
                    <td>
                        <h4 class="hospital-brand-title mb-0">Bệnh viện Liên Hoa</h4>
                        <p class="text-muted small mb-0">Hệ thống Y tế Chất lượng cao - Tinh hoa Y đức</p>
                    </td>
                    <td class="qr-box">
                        <?php $bookingCode = 'DL' . date('Y') . str_pad($booking['id'] ?? 0, 4, '0', STR_PAD_LEFT); ?>
                        <small class="d-block text-muted">Mã phiếu: <strong><?= $bookingCode ?></strong></small>
                    </td>
                </tr>
            </table>

            <hr>

            <div class="text-center my-4">
                <h3 class="fw-bold mb-1">PHIẾU ĐĂNG KÝ KHÁM BỆNH</h3>
                <p class="text-muted">
    Ngày <?= date('d/m/Y', strtotime($booking['ngay_tao'] ?? 'now')) ?> | 
    Trạng thái: <span class="text-warning fw-bold">CHỜ XÁC NHẬN</span>
</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="dotted-line"><span class="data-label">Họ và tên:</span> <span class="data-value"><?= mb_strtoupper($booking['ten_benh_nhan'] ?? '') ?></span></div>
                    <div class="dotted-line"><span class="data-label">Ngày sinh:</span> <span class="data-value"><?= date('d-m-Y', strtotime($booking['ngay_sinh'] ?? 'now')) ?></span></div>
                    <div class="dotted-line"><span class="data-label">Số điện thoại:</span> <span class="data-value"><?= $booking['so_dien_thoai'] ?? '' ?></span></div>
                </div>
                <div class="col-md-6">
                    <div class="dotted-line"><span class="data-label">Giới tính:</span> <span class="data-value"><?= $booking['gioi_tinh'] ?? '' ?></span></div>
                    <div class="dotted-line"><span class="data-label">Đối tượng:</span> <span class="data-value">Đăng ký Online</span></div>
                    <div class="dotted-line"><span class="data-label">CCCD/CMND:</span> <span class="data-value"><?= $booking['cccd'] ?? '---' ?></span></div>
                </div>
            </div>

            <div class="cost-summary">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="data-label" style="width: 30%;">Tên gói khám:</td>
                            <td class="data-value"><?= htmlspecialchars($booking['chuyen_khoa'] ?? 'Khám tổng quát') ?></td>
                        </tr>
                        <tr>
                            <td class="data-label">Giá tiền:</td>
                            <td class="text-danger fw-bold fs-5">
                                <?= number_format($booking['gia_goi'] ?? 150000, 0, ',', '.') ?>đ
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="highlight-box">
                <h5 class="text-secondary mb-3">ĐỊA ĐIỂM KHÁM: <span class="text-dark fw-bold"><?= $booking['co_so_kham'] ?? 'Cơ sở chính' ?></span></h5>
                <h4 class="mb-2">Ngày khám: <span class="text-primary"><?= date('d-m-Y', strtotime($booking['ngay_hen'] ?? 'now')) ?></span></h4>
                <div class="display-5 fw-bold mt-3 text-dark">STT: <?= $booking['stt'] ?? rand(10, 99) ?></div>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-6">
                    <p class="mb-5 italic">Bệnh nhân</p>
                    <p class="mt-4 fw-bold"><?= $booking['ten_benh_nhan'] ?? '' ?></p>
                </div>
                <div class="col-6">
                    <p class="mb-0 text-muted small italic">Thời gian in: <?= date('H:i d/m/Y') ?></p>
                    <p class="mb-5">Người thu (Ký tên)</p>
                    <p class="mt-4 fw-bold">BỆNH VIỆN LIÊN HOA</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_DIR . '/views/layouts/footer.php'; ?>
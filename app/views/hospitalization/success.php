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
                <i class="bi bi-printer me-2"></i>In phiếu đăng ký
            </button>
            <a href="<?= BASE_URL ?>/" class="btn btn-primary px-4 rounded-pill" style="background-color: #0d5c75;">
                Quay lại trang chủ
            </a>
        </div>

        <div class="invoice-container">
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
                        <?php $bookingCode = 'NV' . date('Y') . str_pad($hospitalization['id'] ?? 0, 4, '0', STR_PAD_LEFT); ?>
                        <small class="d-block text-muted">Mã phiếu: <strong><?= $bookingCode ?></strong></small>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= urlencode($bookingCode) ?>" alt="QR">
                    </td>
                </tr>
            </table>

            <hr>

            <div class="text-center my-4">
                <h3 class="fw-bold mb-1">PHIẾU ĐĂNG KÝ NHẬP VIỆN</h3>
                <p class="text-muted">Ngày <?= date('d/m/Y', strtotime($hospitalization['created_at'] ?? 'now')) ?> | Trạng thái: <span class="text-warning fw-bold">ĐANG CHỜ DUYỆT</span></p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="dotted-line"><span class="data-label">Họ và tên:</span> <span class="data-value"><?= mb_strtoupper($hospitalization['patient_name'] ?? '') ?></span></div>
                    <div class="dotted-line"><span class="data-label">Mã bệnh nhân:</span> <span class="data-value"><?= $hospitalization['patient_id'] ?? '---' ?></span></div>
                    <div class="dotted-line"><span class="data-label">Số điện thoại:</span> <span class="data-value"><?= $hospitalization['phone'] ?? '' ?></span></div>
                </div>
                <div class="col-md-6">
                    <div class="dotted-line"><span class="data-label">Khoa/Phòng:</span> <span class="data-value"><?= $hospitalization['department'] ?? '' ?></span></div>
                    <div class="dotted-line"><span class="data-label">CCCD/CMND:</span> <span class="data-value"><?= $hospitalization['cccd'] ?? '---' ?></span></div>
                    <div class="dotted-line"><span class="data-label">Lý do nhập viện:</span> <span class="data-value"><?= $hospitalization['reason'] ?? '---' ?></span></div>
                </div>
            </div>

            <div class="cost-summary">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="data-label" style="width: 30%;">Loại phòng:</td>
                            <td class="data-value"><?= htmlspecialchars($hospitalization['room_type'] ?? 'Phòng thường') ?></td>
                        </tr>
                        <tr>
                            <td class="data-label">Đơn giá phòng:</td>
                            <td class="text-danger fw-bold fs-5">
                                <?= number_format($hospitalization['tong_tien'] ?? 800000, 0, ',', '.') ?>đ/ngày
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="highlight-box">
                <h5 class="text-secondary mb-3">ĐỊA ĐIỂM: <span class="text-dark fw-bold">Khu đăng ký nhập viện - Tầng 1 Bệnh viện Liên Hoa</span></h5>
                <h4 class="mb-2">Ngày dự kiến nhập viện: <span class="text-primary"><?= date('H:i d-m-Y', strtotime($hospitalization['admission_date'] ?? 'now')) ?></span></h4>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-6">
                    <p class="mb-5">Bệnh nhân / Người nhà</p>
                    <p class="mt-4 fw-bold"><?= $hospitalization['patient_name'] ?? '' ?></p>
                </div>
                <div class="col-6">
                    <p class="mb-0 text-muted small">Thời gian in: <?= date('H:i d/m/Y') ?></p>
                    <p class="mb-5">Cán bộ tiếp nhận (Ký tên)</p>
                    <p class="mt-4 fw-bold">BỆNH VIỆN LIÊN HOA</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_DIR . '/views/layouts/footer.php'; ?>
<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<style>
    .invoice-wrapper {
        background-color: var(--bg-light); /* Màu nền an tĩnh từ style.css */
        padding: 30px 0 80px 0;
        min-height: 100vh;
    }
    
    .invoice-paper {
        width: 100%;
        max-width: 850px;
        margin: 0 auto;
        background: #ffffff;
        padding: 50px 60px;
        border-radius: 20px; /* Bo góc đồng bộ với .feature-card */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); /* Shadow nhẹ từ theme */
        border-top: 6px solid var(--primary-color);
        position: relative;
    }

    .brand-logo-container {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--primary-color);
    }

    .brand-logo-container i {
        font-size: 2.5rem;
        color: var(--primary-color);
    }

    .invoice-badge-status {
        background: rgba(27, 188, 160, 0.15); /* Màu info-color nhạt */
        color: var(--info-color);
        padding: 6px 15px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Bảng hóa đơn tối giản theo phong cách Medical */
    .table-medical thead th {
        background-color: #f8fbfa !important;
        color: var(--primary-color);
        border-bottom: 2px solid var(--info-color) !important;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .digital-sign-box {
        border: 2px dashed var(--info-color);
        padding: 15px;
        border-radius: 12px;
        display: inline-block;
        background: #f0fdfa;
    }

    @media print {
        header, footer, .no-print { display: none !important; }
        .invoice-wrapper { padding: 0; background: #fff; }
        .invoice-paper { box-shadow: none; border: none; padding: 0; }
    }
</style>

<div class="invoice-wrapper">
    <div class="container mb-3 no-print animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-center" style="max-width: 850px; margin: 0 auto;">
            <a href="<?= BASE_URL ?>/invoice" class="text-decoration-none text-muted small hover-link">
                <i class="bi bi-arrow-left"></i> Quay lại tra cứu
            </a>
            <button onclick="window.print()" class="btn btn-booking-nav btn-sm px-4">
                <i class="bi bi-printer me-2"></i> IN HÓA ĐƠN
            </button>
        </div>
    </div>

    <div class="invoice-paper animate-fade-in-up">
        <div class="row mb-5">
            <div class="col-md-7">
                <div class="brand-logo-container mb-3">
                    <i class="bi bi-flower1"></i>
                    <span class="fs-3 fw-black text-uppercase">
                        <span data-lang="brand">Bệnh viện Đa khoa</span>
                        <span class="text-info" data-lang="brand_sub"> LIÊN HOA</span>
                    </span>
                </div>
                <div class="ms-1 text-hospital-blue-light small">
                    <p class="mb-1 fw-bold">BỆNH VIỆN ĐA KHOA LIÊN HOA</p>
                    <p class="mb-1"><i class="bi bi-geo-alt"></i> 123 Đường Điện Biên Phủ, Quận 3, TP.HCM</p>
                    <p class="mb-0"><i class="bi bi-globe"></i> lienhoamedical.com.vn | MST: 0101234567</p>
                </div>
            </div>
            <div class="col-md-5 text-end">
                <h2 class="fw-black text-hospital-blue mb-1">HÓA ĐƠN</h2>
                <div class="invoice-badge-status d-inline-block mb-3">HÓA ĐƠN ĐIỆN TỬ</div>
                <p class="mb-0 small">Số: <strong class="text-danger"><?= $data['so_hoa_don'] ?? '0000123' ?></strong></p>
                
                <?php 
                    $maTraCuuGoc = $data['ma_tra_cuu'] ?? 'HD-2026-0001';
                    
                    // Nếu mã tra cứu chứa định dạng cũ dạng HD-XXXX-XXXX, tiến hành format sạch dấu gạch nối và thay tiền tố thành BN
                    if (strpos($maTraCuuGoc, 'HD-') !== false) {
                        // Loại bỏ tiền tố HD- và các dấu gạch ngang còn lại
                        $cleanNumbers = str_replace(['HD-', '-'], '', $maTraCuuGoc);
                        // Ghép tiền tố mới BN thành cấu trúc BN2026001
                        $maTraCuuMoi = 'BN' . $cleanNumbers;
                    } else {
                        $maTraCuuMoi = $maTraCuuGoc;
                    }
                ?>
                <p class="mb-0 small text-muted">Mã tra cứu: <strong class="text-primary"><?= htmlspecialchars($maTraCuuMoi) ?></strong></p>
            </div>
        </div>

        <div class="text-center mb-5">
            <h3 class="fw-bold text-hospital-blue" style="letter-spacing: 1px;">HÓA ĐƠN GIÁ TRỊ GIA TĂNG</h3>
            <p class="text-muted small italic">(Bản thể hiện dữ liệu điện tử)</p>
            <p class="fw-bold">Ngày <?= date('d/m/Y', strtotime($data['ngay_lap'] ?? 'now')) ?></p>
        </div>

        <div class="table-responsive">
            <table class="table table-medical mb-4">
                <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Nội dung dịch vụ khám bệnh</th>
                        <th class="text-center">ĐVT</th>
                        <th class="text-end">Thành tiền (VND)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $truocThue = $data['tong_tien'] ?? 0;
                    // Dịch vụ y tế (khám, chữa bệnh) không chịu thuế GTGT
                    $tong = $truocThue;
                    $services = $data['services'] ?? [];
                    
                    if (empty($services)) {
                        echo '<tr>
                            <td class="text-center">01</td>
                            <td class="fw-bold">Tổng hợp dịch vụ kỹ thuật & Thuốc điều trị</td>
                            <td class="text-center">Lần</td>
                            <td class="text-end">' . number_format($truocThue, 0, ',', '.') . '</td>
                        </tr>';
                    } else {
                        $stt = 1;
                        foreach ($services as $svc) {
                            $giaTruocThue = $svc['thanh_tien'] ?? 0;
                            echo '<tr>
                                <td class="text-center">' . str_pad($stt, 2, '0', STR_PAD_LEFT) . '</td>
                                <td class="fw-bold">' . htmlspecialchars($svc['ten_dich_vu'] ?? 'Dịch vụ') . ' <span class="badge bg-light text-secondary ms-1 border" style="font-size: 0.65rem;">KCT</span></td>
                                <td class="text-center">' . ($svc['so_luong'] ?? 1) . ' Lần</td>
                                <td class="text-end">' . number_format($giaTruocThue, 0, ',', '.') . '</td>
                            </tr>';
                            $stt++;
                        }
                    }
                    ?>
                    <tr style="height: 150px;"><td></td><td></td><td></td><td></td></tr>
                </tbody>
                <tfoot class="border-top">
                    <tr>
                        <td colspan="3" class="text-end py-2 fw-bold small">Cộng tiền dịch vụ:</td>
                        <td class="text-end py-2 fw-bold"><?= number_format($truocThue, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end py-2 fw-bold small">Thuế suất GTGT (Không chịu thuế):</td>
                        <td class="text-end py-2 fw-bold">\</td>
                    </tr>
                    <tr class="fs-5">
                        <td colspan="3" class="text-end py-3 text-uppercase fw-black text-hospital-blue">Tổng tiền thanh toán:</td>
                        <td class="text-end py-3 fw-black text-danger"><?= number_format($tong, 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row mt-5">
            <div class="col-6 text-center">
                <p class="fw-bold text-hospital-blue mb-5">NGƯỜI MUA HÀNG</p>
                <div class="mt-5 text-muted small">(Ký, ghi rõ họ tên)</div>
            </div>
            <div class="col-6 text-center">
                <p class="fw-bold text-hospital-blue mb-3">NGƯỜI BÁN HÀNG</p>
                <div class="digital-sign-box animate-fade-in-up">
                    <p class="mb-1 fw-black small" style="color: var(--primary-color);">BỆNH VIỆN LIÊN HOA</p>
                    <p class="mb-1 text-danger fw-bold small"><i class="bi bi-shield-check"></i> ĐÃ KÝ ĐIỆN TỬ</p>
                    <p class="mb-0 text-muted" style="font-size: 10px;">Thời gian: <?= date('d/m/Y H:i:s') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
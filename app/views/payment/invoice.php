<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<style>
    :root {
        --lh-primary: #0d6efd;
        --lh-secondary: #f8f9fa;
    }
    
    .invoice-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .invoice-header {
        border-bottom: 2px solid var(--lh-primary);
        padding-bottom: 1.5rem;
    }
    
    .invoice-logo i {
        font-size: 2.5rem;
        color: var(--lh-primary);
    }
    
    .hospital-title {
        color: var(--lh-primary);
        font-weight: 800;
        letter-spacing: 0.5px;
    }
    
    .invoice-table th {
        background-color: var(--lh-secondary) !important;
        color: #333 !important;
        font-weight: 600;
    }
    
    .total-row {
        background-color: rgba(13, 110, 253, 0.05) !important;
        font-size: 1.1rem;
    }
    
    .action-buttons .btn {
        min-width: 150px;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-container, .invoice-container * {
            visibility: visible;
        }
        .invoice-container {
            position: absolute;
            left: 0;
            top: 0;
            box-shadow: none;
            width: 100%;
        }
        .action-buttons, header, footer, .navbar {
            display: none !important;
        }
        /* Keep colors for print */
        .invoice-header {
            border-bottom: 2px solid #0d6efd !important;
        }
        .hospital-title {
            color: #0d6efd !important;
            -webkit-print-color-adjust: exact;
        }
        .invoice-table th {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
        }
        .total-row {
            background-color: rgba(13, 110, 253, 0.05) !important;
            -webkit-print-color-adjust: exact;
        }
        .text-danger {
            color: #dc3545 !important;
            -webkit-print-color-adjust: exact;
        }
        .text-success {
            color: #198754 !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<main class="flex-grow-1 bg-light py-5">
    <div class="container">
        
        <div class="invoice-container p-4 p-md-5 mb-4">
            
            <!-- Header Hóa Đơn -->
            <div class="invoice-header d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start mb-4">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="invoice-logo me-3">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <div>
                        <h3 class="hospital-title mb-0">BỆNH VIỆN LIÊN HOA</h3>
                        <p class="text-muted small mb-0">Chăm sóc tận tâm, Nâng tầm sức khỏe</p>
                        <p class="text-muted small mb-0">123 Đường Sức Khỏe, Quận Y Tế, TP. HCM</p>
                    </div>
                </div>
                <div class="text-center text-md-end">
                    <h2 class="fw-bold text-uppercase mb-1">HÓA ĐƠN ĐIỆN TỬ</h2>
                    <p class="mb-0 fw-bold text-danger">Mã HĐ: <?= htmlspecialchars($invoiceData['patient_info']['ma_hoa_don'] ?? '') ?></p>
                    <p class="text-muted small mb-0">Ngày lập: <?= htmlspecialchars($invoiceData['patient_info']['ngay_lap'] ?? '') ?></p>
                </div>
            </div>

            <!-- Thông tin bệnh nhân -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Thông Tin Bệnh Nhân</h5>
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 120px;">Họ và tên:</td>
                                <td class="fw-bold text-uppercase"><?= htmlspecialchars($invoiceData['patient_info']['ten_benh_nhan'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Mã bệnh nhân:</td>
                                <td class="fw-bold"><?= htmlspecialchars($invoiceData['patient_info']['ma_benh_nhan'] ?? '') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 text-md-end mt-4 mt-md-0">
                    <div class="bg-light p-3 rounded-3 d-inline-block text-start border">
                        <p class="mb-1 text-muted small"><i class="bi bi-patch-check-fill text-success me-1"></i>Trạng thái giao dịch</p>
                        <h5 class="text-success fw-bold mb-0">ĐÃ THANH TOÁN THÀNH CÔNG</h5>
                    </div>
                </div>
            </div>

            <!-- Chi tiết viện phí -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered invoice-table mb-0 align-middle">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 5%">STT</th>
                            <th class="text-start">Tên Dịch Vụ / Khám Bệnh</th>
                            <th style="width: 10%">SL</th>
                            <th style="width: 20%">Đơn giá (VND)</th>
                            <th style="width: 20%">Thành tiền (VND)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($invoiceData['services'])): ?>
                            <?php foreach ($invoiceData['services'] as $index => $service): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <span class="fw-bold"><?= htmlspecialchars($service['ten_dich_vu'] ?? '') ?></span>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($service['so_luong'] ?? 1) ?></td>
                                    <td class="text-end"><?= number_format($service['don_gia'] ?? 0, 0, ',', '.') ?></td>
                                    <td class="text-end fw-bold"><?= number_format($service['thanh_tien'] ?? 0, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Không có chi tiết dịch vụ</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="4" class="text-end fw-bold text-uppercase py-3">Tổng cộng:</td>
                            <td class="text-end fw-bold text-danger fs-5 py-3">
                                <?= number_format($invoiceData['tong_tien'] ?? 0, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Chữ ký -->
            <div class="row mt-5 mb-3 text-center">
                <div class="col-6">
                    <p class="fw-bold mb-5">Người nộp tiền</p>
                    <p class="text-muted small">(Ký, ghi rõ họ tên)</p>
                </div>
                <div class="col-6">
                    <p class="mb-1">Ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></p>
                    <p class="fw-bold mb-5">Người lập phiếu</p>
                    <p class="text-muted small">(Ký, ghi rõ họ tên)</p>
                    <p class="fw-bold">Bệnh Viện Liên Hoa</p>
                </div>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="text-center action-buttons mt-4">
            <button onclick="window.print()" class="btn btn-outline-primary fw-bold py-2 px-4 me-2 shadow-sm rounded-pill">
                <i class="bi bi-printer-fill me-2"></i> In Hóa Đơn
            </button>
            <a href="<?= BASE_URL ?>/payment" class="btn btn-success fw-bold py-2 px-4 shadow-sm rounded-pill">
                <i class="bi bi-check-circle-fill me-2"></i> Xác Nhận Hoàn Tất
            </a>
        </div>

    </div>
</main>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<main class="flex-grow-1 bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">Chọn Tài Khoản Ngân Hàng Bệnh Viện</h4>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <p class="text-muted mb-1">Mã hồ sơ/Bệnh nhân</p>
                            <h5 class="fw-bold"><?= htmlspecialchars($code ?? 'BN2026002') ?></h5>
                            <hr class="mx-5">
                            <p class="text-muted mb-1">Số tiền cần thanh toán</p>
                            <h3 class="text-danger fw-bold"><?= number_format($data['tong_tien'] ?? 0, 0, ',', '.') ?> VND</h3>
                        </div>

                        <div class="list-group shadow-sm rounded-3">
                            <?php $payCode = urlencode($code ?? ''); ?>

                            <a href="<?= BASE_URL ?>/payment/checkout?code=<?= $payCode ?>&method=vpbank" 
                               class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-start-0 border-end-0">
                                <div class="bg-light rounded-3 p-2 text-success">
                                    <i class="bi bi-bank fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark">VPBank</div>
                                    <small class="text-muted">Ngân hàng TMCP Việt Nam Thịnh Vượng</small>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>

                            <a href="<?= BASE_URL ?>/payment/checkout?code=<?= $payCode ?>&method=vcb" 
                               class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-start-0 border-end-0">
                                <div class="bg-light rounded-3 p-2 text-primary">
                                    <i class="bi bi-bank fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark">Vietcombank</div>
                                    <small class="text-muted">Ngân hàng TMCP Ngoại Thương</small>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>

                            <a href="<?= BASE_URL ?>/payment/checkout?code=<?= $payCode ?>&method=mbbank" 
                               class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-start-0 border-end-0">
                                <div class="bg-light rounded-3 p-2 text-info">
                                    <i class="bi bi-bank2 fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark">MB Bank</div>
                                    <small class="text-muted">Ngân hàng TMCP Quân Đội</small>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>

                            <a href="<?= BASE_URL ?>/payment/checkout?code=<?= $payCode ?>&method=tcb" 
                               class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-start-0 border-end-0">
                                <div class="bg-light rounded-3 p-2 text-danger">
                                    <i class="bi bi-credit-card fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark">Techcombank</div>
                                    <small class="text-muted">Ngân hàng Kỹ Thương</small>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                        </div>

                        <div class="text-center mt-4">
                            <a href="<?= BASE_URL ?>/payment" class="text-muted text-decoration-none small">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại tra cứu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
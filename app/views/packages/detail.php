<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-4 text-center">
                    <h2 class="fw-bold mb-0"><?= htmlspecialchars($package['ten_goi']) ?></h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <span class="badge bg-light text-primary fs-5 p-3 rounded-pill">
                            Giá gói: <?= number_format($package['gia_tien'], 0, ',', '.') ?> VNĐ
                        </span>
                    </div>
                    
                    <h5 class="fw-bold"><i class="bi bi-info-circle me-2"></i>Mô tả chi tiết:</h5>
                    <p class="text-muted fs-5 lh-lg"><?= nl2br(htmlspecialchars($package['mo_ta'])) ?></p>
                    
                    <hr class="my-4">
                    
                    <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                        <a href="<?= BASE_URL ?>/package" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                            Quay lại danh sách
                        </a>
                        <a href="<?= BASE_URL ?>/booking/package?package_id=<?= $package['id'] ?>" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                            Đặt gói khám
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
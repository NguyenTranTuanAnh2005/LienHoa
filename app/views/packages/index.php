<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container my-5 px-md-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #0d5c75;" data-lang="page_pkg_title">Gói Khám Sức Khoẻ Định Kỳ</h1>
        <div class="mx-auto my-3" style="width: 60px; height: 4px; background-color: #0d5c75; border-radius: 2px;"></div>
        <p class="lead text-muted mx-auto" style="max-width: 700px;" data-lang="page_pkg_subtitle">
            Lựa chọn gói khám lâm sàng chuyên sâu theo chuẩn y tế, tối ưu chi phí và theo dõi toàn diện cơ thể.
        </p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (!empty($packages)): ?>
            <?php foreach ($packages as $pkg): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 package-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 70px; height: 70px; background-color: rgba(13, 92, 117, 0.05);">
                                <i class="bi bi-heart-pulse fs-1" style="color: #0d5c75;"></i>
                            </div>

                            <h4 class="card-title fw-bold mb-3" style="color: #0d3b4b; min-height: 54px;" data-translate-text="true">
                                <?= htmlspecialchars($pkg['ten_goi']) ?>
                            </h4>

                            <h2 class="fw-bold mb-4" style="color: #0d5c75;">
                                <?= number_format($pkg['gia_tien'], 0, ',', '.') ?> <small class="fs-6">VNĐ</small>
                            </h2>

                            <p class="card-text text-muted mb-4 small" style="min-height: 70px; text-align: justify;" data-translate-text="true">
                                <?= htmlspecialchars($pkg['mo_ta']) ?>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 pb-4 pt-0 px-4 text-center">
                            <a href="<?= BASE_URL ?>/booking/package?package_id=<?= $pkg['id'] ?>" 
                               class="btn btn-primary rounded-pill w-100 py-2 fw-bold shadow-sm transition-btn">
                                <i class="bi bi-calendar-check me-2"></i><span data-lang="btn_book_pkg">ĐẶT GÓI NÀY</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 py-5 text-center text-muted bg-white rounded-4 shadow-sm w-100 border border-dashed">
                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                <h4 class="fw-normal" data-lang="pkg_empty_title">Hiện chưa có gói khám nào được thiết lập.</h4>
                <p data-lang="pkg_empty_subtitle">Vui lòng quay lại sau hoặc liên hệ hỗ trợ.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* CSS Nâng cao để giao diện mượt mà hơn */
.package-card {
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    border: 1px solid rgba(0,0,0,0.05) !important;
}

.package-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(13, 92, 117, 0.12) !important;
    border-color: #0d5c75 !important;
}

.transition-btn {
    background-color: #0d5c75;
    border: none;
    transition: all 0.3s ease;
}

.transition-btn:hover {
    background-color: #0a4659;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(13, 92, 117, 0.2);
}

/* Tinh chỉnh tiêu đề card */
.card-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
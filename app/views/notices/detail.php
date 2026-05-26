<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<style>
    :root {
        --lh-primary: #0d5c75;
        --lh-primary-light: #f4fafc;
        --lh-accent: #26c4f1;
        --lh-text-dark: #1e293b;
        --lh-danger: #dc3545;
        --lh-danger-light: #fff5f5;
    }

    .notice-detail-container {
        color: var(--lh-text-dark);
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .notice-header-badge {
        background-color: rgba(13, 92, 117, 0.1);
        color: var(--lh-primary);
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 50px;
        display: inline-block;
    }

    .notice-title {
        color: var(--lh-primary);
        font-weight: 800;
        line-height: 1.3;
    }

    /* Khung cẩm nang hành động */
    .action-box {
        border-left: 4px solid var(--lh-primary);
        background-color: var(--lh-primary-light);
        border-radius: 0 16px 16px 0;
        padding: 20px;
        margin-bottom: 25px;
    }

    .action-item {
        background: #ffffff;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 12px;
        border: 1px solid rgba(13, 92, 117, 0.08);
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    /* Khung khuyến cáo khẩn cấp từ bác sĩ */
    .warning-box {
        background-color: var(--lh-danger-light);
        border: 1px dashed rgba(220, 53, 69, 0.3);
        border-radius: 16px;
        padding: 25px;
        margin-top: 35px;
        position: relative;
    }

    .warning-title {
        color: var(--lh-danger);
        font-weight: 700;
        font-size: 1.15rem;
    }

    .warning-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px;
        border-top: 4px solid var(--lh-danger);
        height: 100%;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.05);
    }

    .warning-card.success-top {
        border-top-color: #198754;
    }

    .quote-footer {
        background: linear-gradient(135deg, var(--lh-primary) 0%, #083b4b 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 20px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Sidebar bổ sung kiến thức */
    .sidebar-sticky {
        position: sticky;
        top: 100px;
    }

    .info-widget {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        background: #ffffff;
    }
</style>

<div class="container my-5 notice-detail-container">
    <div class="row g-5">
        <div class="col-12 col-lg-8">
            
            <div class="mb-4">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    <span class="notice-header-badge text-uppercase fs-7"><?= htmlspecialchars($item['category'] ?? 'Thông báo chung') ?></span>
                    <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> <?= isset($item['created_at']) ? date('d/m/Y', strtotime($item['created_at'])) : '' ?></span>
                </div>
                <h1 class="notice-title mb-4"><?= htmlspecialchars($item['title'] ?? '') ?></h1>
                <?php if (!empty($item['summary'])): ?>
                <div class="p-3 bg-light rounded-3 border-start border-3 border-secondary text-muted fst-italic">
                    <strong>Tóm tắt:</strong> <?= htmlspecialchars($item['summary']) ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="article-content mt-4">
                <?php if (!empty($item['image'])): ?>
                    <img src="<?= BASE_URL ?>/public/uploads/notices/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="img-fluid rounded-4 mb-4 shadow-sm" style="width: 100%; max-height: 450px; object-fit: cover;">
                <?php endif; ?>
                
                <div style="font-size: 1.05rem; line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($item['content'] ?? '')) ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="sidebar-sticky">
                <div class="info-widget bg-light border-0 shadow-sm mb-4">
                    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-hospital me-2"></i>Bệnh viện Đa khoa Liên Hoa</h5>
                    <p class="small text-muted">Với đội ngũ y bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại, chúng tôi luôn cam kết mang đến dịch vụ chăm sóc sức khỏe tốt nhất cho bạn và gia đình.</p>
                    <a href="<?= BASE_URL ?>/booking" class="btn btn-outline-primary btn-sm rounded-pill mt-2 w-100">Đặt Lịch Ngay</a>
                </div>
                
                <div class="info-widget shadow-sm border-0">
                    <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-telephone-fill text-danger me-2"></i>Hỗ Trợ Khẩn Cấp</h5>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-danger">1900 8888</div>
                            <small class="text-muted">Trực cấp cứu 24/7</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
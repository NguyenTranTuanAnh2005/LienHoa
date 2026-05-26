<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary" data-lang="notice_title">Tin Tức & Thông Báo</h1>
        <p class="lead text-muted" data-lang="notice_subtitle">Cập nhật những tin tức y tế mới nhất và thông báo quan trọng từ bệnh viện.</p>
    </div>

    <div class="row g-4">
        <?php if (!empty($notices)): ?>
            <?php foreach ($notices as $item): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden transition-hover">
                        <div class="position-relative">
                            <?php 
                                $imagePath = !empty($item['image']) && $item['image'] !== 'default-notice.png' ? BASE_URL . '/public/uploads/notices/' . $item['image'] : 'https://via.placeholder.com/400x250?text=Lien+Hoa+Hospital';
                            ?>
                            <img src="<?= $imagePath ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($item['title'] ?? 'Tin tức') ?>" 
                                 style="height: 200px; object-fit: cover;">
                            
                            <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-info text-dark" data-translate-text="true">
                                <?= htmlspecialchars($item['category'] ?? 'Thông báo') ?>
                            </span>
                        </div>

                        <div class="card-body p-4">
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i> <?= isset($item['created_at']) ? date('d/m/Y', strtotime($item['created_at'])) : date('d/m/Y') ?>
                            </small>
                            <h5 class="card-title fw-bold mt-2 mb-3 text-dark" data-translate-text="true">
                                <?= htmlspecialchars($item['title'] ?? 'Không có tiêu đề') ?>
                            </h5>
                            <p class="card-text text-muted small" data-translate-text="true">
                                <?= htmlspecialchars($item['summary'] ?? 'Đang cập nhật nội dung tóm tắt...') ?>
                            </p>
                        </div>

                        <div class="card-footer bg-transparent border-0 pb-4 pt-0">
                            <a href="<?= BASE_URL ?>/notice/detail/<?= $item['id'] ?>" 
                               class="btn btn-link text-primary fw-bold p-0 text-decoration-none">
                               <span data-lang="btn_view_detail">VUI LÒNG CHỜ</span> <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 py-5 text-center text-muted bg-light rounded-3">
                <h4 class="fw-normal" data-lang="notice_empty">Hiện chưa có thông báo nào mới.</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* Hiệu ứng mượt mà */
.transition-hover { transition: all 0.3s ease; }
.transition-hover:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; 
}
.card-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 3rem;
}
</style>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
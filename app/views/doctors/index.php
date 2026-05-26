<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<style>
    /* Phong cách Modern đồng bộ với trang chủ */
    .doctor-card-modern {
        background: #fff;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        overflow: hidden;
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .doctor-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .doctor-img-wrap {
        width: 100%;
        height: 280px; /* Chiều cao cố định cho ảnh */
        overflow: hidden;
    }
    .doctor-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Đảm bảo ảnh không bị méo */
    }
    .doctor-card-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .doctor-badge {
        display: inline-block;
        background: #eef6ff;
        color: #0d6efd;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .doctor-name { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
    .doctor-desc { color: #64748b; font-size: 0.9rem; margin-bottom: 15px; line-height: 1.6; }
    .doctor-card-link { color: #0d6efd; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; margin-top: auto; }
</style>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="text-primary fw-bold">Đội Ngũ Bác Sĩ Của Chúng Tôi</h1>
        <div class="mx-auto bg-primary mb-3" style="height: 3px; width: 50px;"></div>
        <p class="text-muted lead">Gặp gỡ các chuyên gia, y bác sĩ đầu ngành đang làm việc tại bệnh viện.</p>
    </div>
    
    <div class="row g-4">
        <?php if (!empty($doctors) && is_array($doctors)): ?>
            <?php foreach ($doctors as $doctor): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="doctor-card-modern">
                        <div class="doctor-img-wrap">
                            <img src="<?= BASE_URL ?>/public/uploads/doctors/<?= !empty($doctor['hinh_anh']) ? htmlspecialchars($doctor['hinh_anh']) : 'default-doctor.png' ?>" 
                                 onerror="this.src='<?= BASE_URL ?>/assets/images/<?= !empty($doctor['hinh_anh']) ? htmlspecialchars($doctor['hinh_anh']) : 'default-doctor.png' ?>'; this.onerror=null;"
                                 alt="<?= htmlspecialchars($doctor['ho_ten']) ?>">
                        </div>
                        <div class="doctor-card-body">
                            <span class="doctor-badge"><?= htmlspecialchars($doctor['chuyen_khoa'] ?? 'Đa Khoa') ?></span>
                            <h3 class="doctor-name">BS. <?= htmlspecialchars($doctor['ho_ten']) ?></h3>
                            <div class="doctor-desc">
                                <?= htmlspecialchars(mb_strimwidth($doctor['tieu_su'] ?? 'Chuyên gia giàu kinh nghiệm tại bệnh viện Liên Hoa.', 0, 100, "...")) ?>
                            </div>
                            <a href="<?= BASE_URL ?>/doctor/detail/<?= $doctor['id'] ?>" class="doctor-card-link">
                                Xem chi tiết <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Hiện chưa có dữ liệu bác sĩ.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
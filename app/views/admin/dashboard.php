<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container py-5 min-vh-100">
    <div class="row mb-4">
        <div class="col-12">
            
            <h1 class="fw-bold text-primary mb-3">
                <i class="bi bi-speedometer2 me-2"></i>Trang Quản Trị (Admin Dashboard)
            </h1>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <h5 class="card-title text-muted mb-4">
                        Xin chào Admin: 
                        <strong class="text-dark">
                            <?= htmlspecialchars($_SESSION['full_name'] ?? 'Quản trị viên') ?>
                        </strong>
                    </h5>

                    <div class="row g-4">

                        <div class="col-md-6 col-lg-3">
    <div
        class="card h-100 border-0 bg-light rounded-4 text-center p-4"
        style="transition: 0.3s; cursor: pointer;"
        onmouseover="this.classList.add('shadow')"
        onmouseout="this.classList.remove('shadow')"
        onclick="window.location.href='<?= BASE_URL ?>/admin/patient'"
    >
        <i class="bi bi-people-fill fs-1 text-primary mb-3"></i>
        <h4 class="fw-bold">Bệnh nhân</h4>
        <p class="text-muted mb-0">Quản lý hồ sơ</p>
    </div>
</div>

                        <div class="col-md-6 col-lg-3">
                            <div
                                class="card h-100 border-0 bg-light rounded-4 text-center p-4"
                                style="transition: 0.3s; cursor: pointer;"
                                onmouseover="this.classList.add('shadow')"
                                onmouseout="this.classList.remove('shadow')"
                                onclick="window.location.href='<?= BASE_URL ?>/admin/package'"
                            >
                                <i class="bi bi-box-seam fs-1 text-success mb-3"></i>
                                <h4 class="fw-bold">Gói khám</h4>
                                <p class="text-muted mb-0">Quản lý gói khám</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div
                                class="card h-100 border-0 bg-light rounded-4 text-center p-4"
                                style="transition: 0.3s; cursor: pointer;"
                                onmouseover="this.classList.add('shadow')"
                                onmouseout="this.classList.remove('shadow')"
                                onclick="window.location.href='<?= BASE_URL ?>/admin/bookings'"
                            >
                                <i class="bi bi-calendar-check fs-1 text-warning mb-3"></i>
                                <h4 class="fw-bold">Đặt lịch</h4>
                                <p class="text-muted mb-0">Quản lý các lịch khám</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div
                                class="card h-100 border-0 bg-light rounded-4 text-center p-4"
                                style="transition: 0.3s; cursor: pointer;"
                                onmouseover="this.classList.add('shadow')"
                                onmouseout="this.classList.remove('shadow')"
                                onclick="window.location.href='<?= BASE_URL ?>/admin/doctormanagement'"
                            >
                                <i class="bi bi-person-badge-fill fs-1 text-danger mb-3"></i>
                                <h4 class="fw-bold">Bác sĩ</h4>
                                <p class="text-muted mb-0">Quản lý bác sĩ</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div
                                class="card h-100 border-0 bg-light rounded-4 text-center p-4"
                                style="transition: 0.3s; cursor: pointer;"
                                onmouseover="this.classList.add('shadow')"
                                onmouseout="this.classList.remove('shadow')"
                                onclick="window.location.href='<?= BASE_URL ?>/admin/revenue'"
                            >
                                <i class="bi bi-graph-up-arrow fs-1 text-dark mb-3" style="color: #6f42c1 !important;"></i>
                                <h4 class="fw-bold">Báo cáo</h4>
                                <p class="text-muted mb-0">Doanh thu gói khám</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
    <div
        class="card h-100 border-0 bg-light rounded-4 text-center p-4"
        style="transition: 0.3s; cursor: pointer;"
        onmouseover="this.classList.add('shadow')"
        onmouseout="this.classList.remove('shadow')"
        onclick="window.location.href='<?= BASE_URL ?>/admin/labtest'"
    >
        <i class="bi bi-droplet-fill fs-1 mb-3" style="color: #007bff !important;"></i>
        <h4 class="fw-bold">Xét nghiệm</h4>
        <p class="text-muted mb-0">Quản lý các xét nghiệm</p>
    </div>
</div>

                    </div> </div>
            </div>

        </div>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
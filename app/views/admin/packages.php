<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container py-5 min-vh-100">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="fw-bold text-info mb-0"><i class="bi bi-box-seam me-2"></i>Quản lý Gói Khám</h1>
            <p class="text-muted mt-2">Danh sách bệnh nhân đăng ký các gói khám sức khỏe thể chất</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="<?= BASE_URL ?>/packagemanagement" class="btn btn-primary rounded-pill px-4 me-2">
                <i class="bi bi-list-task me-2"></i>Danh Sách Gói Khám
            </a>
            <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Quay lại Dashboard
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-info text-info">
                        <tr>
                            <th class="py-3 px-4">Mã BN</th>
                            <th class="py-3">Tên Bệnh Nhân</th>
                            <th class="py-3">Liên Hệ</th>
                            <th class="py-3">Gói Khám Đăng Ký</th>
                            <th class="py-3">Chi Phí</th>
                            <th class="py-3">Thời Gian Hẹn</th>
                            <th class="py-3 text-center">Trạng Thái</th>
                            <th class="py-3 px-4 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($packageBookings)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                    Chưa có dữ liệu đăng ký gói khám nào.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($packageBookings as $booking): ?>
                                <tr>
                                    <td class="px-4 fw-bold text-dark">
                                        <?= !empty($booking['ma_benh_nhan']) ? htmlspecialchars($booking['ma_benh_nhan']) : '<span class="text-muted small">Khách vãng lai</span>' ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($booking['ten_benh_nhan'] ?? '') ?></div>
                                        <small class="text-muted">Giới tính: <?= htmlspecialchars($booking['gioi_tinh'] ?? 'N/A') ?></small>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-telephone-fill small text-muted me-1"></i><?= htmlspecialchars($booking['so_dien_thoai'] ?? '') ?></div>
                                        <?php if (!empty($booking['email'])): ?>
                                            <div class="small"><i class="bi bi-envelope-fill text-muted me-1"></i><?= htmlspecialchars($booking['email'] ?? '') ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-success rounded-pill px-3 py-1 mb-1">Gói khám</span>
                                        <div class="small fw-bold text-secondary"><?= htmlspecialchars($booking['ten_goi_kham'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <strong class="text-danger">
                                            <?= number_format($booking['gia_tien'] ?? 0, 0, ',', '.') ?> đ
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-danger">
                                            <?= date('H:i', strtotime($booking['ngay_hen'])) ?>
                                        </div>
                                        <div class="small text-muted">
                                            <?= date('d/m/Y', strtotime($booking['ngay_hen'])) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $statusClass = 'bg-secondary';
                                            $statusText = 'Không xác định';
                                            switch($booking['trang_thai']) {
                                                case 'dang_cho': 
                                                    $statusClass = 'bg-warning text-dark'; 
                                                    $statusText = 'Đang chờ'; 
                                                    break;
                                                case 'da_xac_nhan': 
                                                    $statusClass = 'bg-primary'; 
                                                    $statusText = 'Đã xác nhận'; 
                                                    break;
                                                case 'hoan_thanh': 
                                                    $statusClass = 'bg-success'; 
                                                    $statusText = 'Hoàn thành'; 
                                                    break;
                                                case 'da_huy': 
                                                    $statusClass = 'bg-danger'; 
                                                    $statusText = 'Đã hủy'; 
                                                    break;
                                            }
                                        ?>
                                        <span class="badge rounded-pill <?= $statusClass ?> px-3 py-2" id="status-badge-<?= $booking['id'] ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Cập nhật
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(<?= $booking['id'] ?>, 'dang_cho')"><i class="bi bi-hourglass-split me-2 text-warning"></i>Đang chờ</a></li>
                                                <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(<?= $booking['id'] ?>, 'da_xac_nhan')"><i class="bi bi-check-circle me-2 text-primary"></i>Đã xác nhận</a></li>
                                                <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(<?= $booking['id'] ?>, 'hoan_thanh')"><i class="bi bi-star-fill me-2 text-success"></i>Hoàn thành</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item py-2 text-danger" href="#" onclick="updateStatus(<?= $booking['id'] ?>, 'da_huy')"><i class="bi bi-x-circle me-2"></i>Hủy đơn</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    async function updateStatus(id, newStatus) {
        try {
            if (newStatus === 'da_huy') {
                const result = await Swal.fire({
                    title: 'Xác nhận hủy đơn?',
                    text: "Bạn có chắc chắn muốn hủy đơn đăng ký gói khám này không?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Đồng ý hủy',
                    cancelButtonText: 'Đóng'
                });
                if (!result.isConfirmed) return;
            }

            const res = await fetch('<?= BASE_URL ?>/admin/updateBookingStatus', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: newStatus })
            });

            const data = await res.json();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Đã cập nhật!',
                    text: 'Trạng thái đơn đăng ký đã được thay đổi.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire('Lỗi!', data.error || 'Cập nhật thất bại.', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Lỗi!', 'Không thể kết nối với máy chủ.', 'error');
        }
    }
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
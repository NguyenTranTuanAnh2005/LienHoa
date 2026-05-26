<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container py-5 min-vh-100">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="fw-bold text-info mb-0"><i class="bi bi-flask me-2"></i>Quản lý Xét Nghiệm</h1>
            <p class="text-muted mt-2">Danh sách bệnh nhân đăng ký các dịch vụ xét nghiệm</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
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
                            <th class="py-3">Loại Xét Nghiệm</th>
                            <th class="py-3">Ngày Lấy Mẫu</th>
                            <th class="py-3">Ghi chú</th>
                            <th class="py-3 text-center">Trạng Thái</th>
                            <th class="py-3 px-4 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($labTests)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-flask fs-1 d-block mb-3 opacity-50"></i>
                                    Chưa có dữ liệu đăng ký xét nghiệm nào.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($labTests as $test): ?>
                                <tr>
                                    <td class="px-4 fw-bold text-dark"><?= htmlspecialchars($test['user_id'] ?? 'N/A') ?></td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($test['patient_name'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-1"><?= htmlspecialchars($test['test_type'] ?? '') ?></span>
                                    </td>
                                    <td>
                                        <div class="fw-medium"><?= date('d/m/Y', strtotime($test['sample_date'])) ?></div>
                                    </td>
                                    <td class="text-muted small" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= htmlspecialchars($test['notes'] ?? 'Không có') ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $statusClass = 'bg-secondary';
                                            $statusText = 'Không xác định';
                                            switch($test['status']) {
                                                case 'pending': 
                                                    $statusClass = 'bg-warning text-dark'; $statusText = 'Đang chờ'; break;
                                                case 'processing': 
                                                    $statusClass = 'bg-primary'; $statusText = 'Đang xử lý'; break;
                                                case 'completed': 
                                                    $statusClass = 'bg-success'; $statusText = 'Hoàn thành'; break;
                                                case 'cancelled': 
                                                    $statusClass = 'bg-danger'; $statusText = 'Đã hủy'; break;
                                            }
                                        ?>
                                        <span class="badge rounded-pill <?= $statusClass ?> px-3 py-2">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">Cập nhật</button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(<?= $test['id'] ?>, 'pending')"><i class="bi bi-hourglass-split me-2 text-warning"></i>Đang chờ</a></li>
                                                <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(<?= $test['id'] ?>, 'processing')"><i class="bi bi-gear me-2 text-primary"></i>Đang xử lý</a></li>
                                                <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(<?= $test['id'] ?>, 'completed')"><i class="bi bi-check2-circle me-2 text-success"></i>Hoàn thành</a></li>
                                                <li><a class="dropdown-item py-2 text-danger" href="#" onclick="updateStatus(<?= $test['id'] ?>, 'cancelled')"><i class="bi bi-x-circle me-2"></i>Hủy đơn</a></li>
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
            const res = await fetch('<?= BASE_URL ?>/admin/updateLabStatus', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: newStatus })
            });

            const data = await res.json();
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Đã cập nhật!', timer: 1000, showConfirmButton: false })
                    .then(() => window.location.reload());
            } else {
                Swal.fire('Lỗi!', 'Cập nhật thất bại.', 'error');
            }
        } catch (err) {
            Swal.fire('Lỗi!', 'Không thể kết nối máy chủ.', 'error');
        }
    }
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
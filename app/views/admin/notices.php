<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container py-5 min-vh-100">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-2" style="color: #0dcaf0;">
                <i class="bi bi-newspaper me-2"></i>
                Quản Lý Tin Tức & Thông Báo
            </h1>
            <p class="text-muted mb-0">
                Quản lý các bài đăng tin tức và thông báo của bệnh viện
            </p>
        </div>

        <button class="btn rounded-pill px-4 py-2 fw-semibold shadow-sm" style="background: #0dcaf0; color: white; border: none;" onclick="openAddModal()">
            <i class="bi bi-plus-circle-fill me-2"></i>
            Thêm Bài Đăng Mới
        </button>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #ffffff;">
        <div class="px-4 py-3" style="background: linear-gradient(135deg, #0dcaf0, #0aa2c0);">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-white fw-bold mb-0">
                    <i class="bi bi-list-task me-2"></i>
                    Danh Sách Bài Đăng
                </h5>
                <span class="badge bg-light text-info px-3 py-2">
                    <?= count($notices ?? []) ?> bài đăng
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead style="background: #e9f9fd;">
                        <tr>
                            <th class="py-3 px-4 text-secondary">ID</th>
                            <th class="py-3 text-secondary">Tiêu Đề</th>
                            <th class="py-3 text-secondary">Danh Mục</th>
                            <th class="py-3 text-secondary">Ngày Tạo</th>
                            <th class="py-3 text-center text-secondary">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($notices)): ?>
                        <?php foreach ($notices as $notice): ?>
                            <tr class="border-top" style="transition: 0.2s;" onmouseover="this.style.background='#f5fdff'" onmouseout="this.style.background='white'">
                                <td class="fw-bold px-4">#<?= htmlspecialchars($notice['id']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($notice['image'])): ?>
                                            <img src="<?= BASE_URL ?>/public/uploads/notices/<?= htmlspecialchars($notice['image']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" class="me-3">
                                        <?php else: ?>
                                            <div class="rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(13,202,240,0.15); color: #0dcaf0; font-size: 20px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold text-dark" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <?= htmlspecialchars($notice['title']) ?>
                                            </div>
                                            <small class="text-muted"><?= htmlspecialchars($notice['summary'] ?? '') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2" style="background: rgba(13,202,240,0.15); color: #0dcaf0; font-size: 13px;">
                                        <?= htmlspecialchars($notice['category'] ?? 'Thông báo chung') ?>
                                    </span>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($notice['created_at'])) ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm rounded-pill px-3" style="background: #0dcaf0; color: white;" onclick='openEditModal(<?= json_encode($notice, JSON_UNESCAPED_UNICODE) ?>)'>
                                            <i class="bi bi-pencil-square me-1"></i>Sửa
                                        </button>
                                        <a href="<?= BASE_URL ?>/admin/deleteNotice/<?= $notice['id'] ?>" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('Bạn có chắc muốn xóa bài đăng này?')">
                                            <i class="bi bi-trash me-1"></i>Xóa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox" style="font-size: 70px; color: #0dcaf0; opacity: 0.5;"></i>
                                    <h5 class="mt-3 text-muted">Chưa có bài đăng nào</h5>
                                    <p class="text-muted mb-0">Hãy thêm bài đăng đầu tiên vào hệ thống</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="noticeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #0dcaf0, #0aa2c0);">
                <h4 class="modal-title fw-bold text-white" id="modalTitle">Thêm Bài Đăng</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="noticeForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="noticeId">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tiêu đề bài đăng</label>
                        <input type="text" name="title" id="title" class="form-control rounded-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Danh mục</label>
                        <select name="category" id="category" class="form-select rounded-3 py-2">
                            <option value="Thông báo chung">Thông báo chung</option>
                            <option value="Tin tức y tế">Tin tức y tế</option>
                            <option value="Sự kiện">Sự kiện</option>
                            <option value="Dịch vụ mới">Dịch vụ mới</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tóm tắt</label>
                        <textarea name="summary" id="summary" class="form-control rounded-3 py-2" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nội dung chi tiết</label>
                        <textarea name="content" id="content" class="form-control rounded-3 py-2" rows="6"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hình ảnh (Tuỳ chọn)</label>
                        <input type="file" name="image" id="image" class="form-control rounded-3 py-2" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn rounded-pill px-4 text-white" style="background: #0dcaf0;">
                        <i class="bi bi-save me-2"></i>Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let noticeModal;
document.addEventListener('DOMContentLoaded', function() {
    noticeModal = new bootstrap.Modal(document.getElementById('noticeModal'));
});

function openAddModal() {
    document.getElementById('modalTitle').innerText = 'Thêm Bài Đăng Mới';
    document.getElementById('noticeForm').action = '<?= BASE_URL ?>/admin/storeNotice';
    document.getElementById('noticeForm').reset();
    document.getElementById('noticeId').value = '';
    document.getElementById('content').value = '';
    noticeModal.show();
}

function openEditModal(notice) {
    document.getElementById('modalTitle').innerText = 'Chỉnh Sửa Bài Đăng';
    document.getElementById('noticeForm').action = '<?= BASE_URL ?>/admin/updateNotice';
    document.getElementById('noticeId').value = notice.id;
    document.getElementById('title').value = notice.title;
    document.getElementById('category').value = notice.category || 'Thông báo chung';
    document.getElementById('summary').value = notice.summary || '';
    document.getElementById('content').value = notice.content || '';
    document.getElementById('image').value = '';
    noticeModal.show();
}
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>

<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<!-- Import Font Lexend -->
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Custom Styling */
    :root {
        --package-primary: #0d5c75;
        --package-primary-hover: #0a4659;
    }
    
    .text-package-primary {
        color: var(--package-primary) !important;
    }
    
    .bg-package-primary {
        background-color: var(--package-primary) !important;
        color: white;
    }
    
    .btn-package-primary {
        background-color: var(--package-primary);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-package-primary:hover {
        background-color: var(--package-primary-hover);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 92, 117, 0.2);
    }

    .btn-outline-package {
        border-color: var(--package-primary);
        color: var(--package-primary);
    }

    .btn-outline-package:hover {
        background-color: var(--package-primary);
        color: white;
    }

    .table-package th {
        background-color: var(--package-primary) !important;
        color: white !important;
        font-weight: 500;
        border-bottom: none;
    }
    
    .card-custom {
        border-radius: 15px !important;
    }
    
    .rounded-pill-start {
        border-top-left-radius: 50rem !important;
        border-bottom-left-radius: 50rem !important;
    }
    
    .rounded-pill-end {
        border-top-right-radius: 50rem !important;
        border-bottom-right-radius: 50rem !important;
    }
</style>

<div class="container my-5" style="font-family: 'Lexend', 'Inter', sans-serif;">
    <div class="row mb-4 align-items-center">
        <!-- Tiêu đề -->
        <div class="col-md-4 mb-3 mb-md-0">
            <h2 class="text-package-primary fw-bold mb-0">Danh Sách Gói Khám</h2>
            <p class="text-muted small mt-1 mb-0">Quản lý thông tin các gói khám</p>
        </div>
        
        <!-- Công cụ (Search + Nút Thêm) -->
        <div class="col-md-8 d-flex gap-3 justify-content-md-end flex-wrap flex-md-nowrap">
            <div class="input-group shadow-sm" style="max-width: 350px;">
                <input type="text" id="searchInput" class="form-control rounded-pill-start border-end-0 py-2" placeholder="Tìm tên gói hoặc mô tả...">
                <button class="btn btn-outline-secondary rounded-pill-end border-start-0 py-2 px-3 bg-white" id="btnSearch" type="button">
                    <i class="bi bi-search text-package-primary"></i>
                </button>
            </div>
            
            <button class="btn btn-package-primary btn-lg rounded-pill px-4 text-nowrap fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#packageModal" id="btnAddPackage">
                <i class="bi bi-plus-circle me-2"></i>Thêm gói khám mới
            </button>
        </div>
    </div>

    <!-- Danh sách Gói khám -->
    <div class="card shadow-sm border-0 card-custom overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-package align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-3 px-4" style="width: 80px;">ID</th>
                            <th class="py-3" style="width: 25%;">Tên gói</th>
                            <th class="py-3" style="width: 35%;">Mô tả</th>
                            <th class="py-3" style="width: 15%;">Giá tiền</th>
                            <th class="py-3 px-4 text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="packageTableBody">
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="spinner-border text-package-primary mb-3" role="status"></div>
                                <div>Đang tải dữ liệu...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm / Sửa Gói khám -->
<div class="modal fade" id="packageModal" tabindex="-1" style="font-family: 'Lexend', 'Inter', sans-serif;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-package-primary py-3">
                <h5 class="modal-title fw-bold" id="packageModalTitle">Thêm gói khám mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <form id="packageForm">
                    <input type="hidden" id="packageId">
                    <div class="row g-4">
                        <!-- Tên gói -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Tên gói <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-sm border-0" id="tenGoi" placeholder="Nhập tên gói" required>
                        </div>
                        
                        <!-- Giá tiền -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Giá tiền (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control rounded-3 py-2 shadow-sm border-0" id="giaTien" placeholder="Ví dụ: 500000" required>
                        </div>
                        
                        <!-- Mô tả -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Mô tả</label>
                            <textarea class="form-control rounded-3 py-2 shadow-sm border-0" id="moTa" rows="3" placeholder="Nhập mô tả gói khám..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-medium border shadow-sm" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-package-primary rounded-pill px-5 fw-medium shadow-sm" id="btnSavePackage">Lưu thông tin</button>
            </div>
        </div>
    </div>
</div>

<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Định nghĩa URL kết nối API
    const API_URL = '<?= BASE_URL ?>/packagemanagement';
    let packageModal;
    
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    };

    // Hàm tải dữ liệu danh sách gói khám
    async function loadPackages(search = '') {
        try {
            const timestamp = new Date().getTime();
            const res = await fetch(`${API_URL}/apiList?search=${encodeURIComponent(search)}&_t=${timestamp}`);
            const result = await res.json();
            
            const tbody = document.getElementById('packageTableBody');
            tbody.innerHTML = '';
            
            if (result.success && result.data.length > 0) {
                result.data.forEach(d => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-4 fw-bold text-dark align-middle">${d.id}</td>
                        <td class="align-middle">
                            <div class="fw-bold text-dark">${d.ten_goi}</div>
                        </td>
                        <td class="align-middle"><div class="text-wrap" style="max-height: 3rem; overflow: hidden; text-overflow: ellipsis;">${d.mo_ta || '<span class="text-muted">Không có mô tả</span>'}</div></td>
                        <td class="align-middle fw-semibold text-danger">${formatCurrency(d.gia_tien || 0)}</td>
                        <td class="px-4 text-end align-middle">
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-sm btn-warning text-dark rounded-pill px-3 fw-medium btn-edit" data-id="${d.id}">
                                    <i class="bi bi-pencil-square me-1"></i>Sửa
                                </button>
                                <button class="btn btn-sm btn-danger text-white rounded-pill px-3 fw-medium btn-delete" data-id="${d.id}">
                                    <i class="bi bi-trash me-1"></i>Xóa
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>Chưa có gói khám nào</td></tr>`;
            }
        } catch (err) {
            console.error('Error fetching packages:', err);
            alert('Lỗi tải dữ liệu: Vui lòng nhấn Ctrl + F5 để làm mới trình duyệt hoàn toàn!');
        }
    }

    // Khởi tạo trang
    document.addEventListener('DOMContentLoaded', () => {
        packageModal = new bootstrap.Modal(document.getElementById('packageModal'));
        
        loadPackages(); // Tải danh sách gói khám
        
        // Bắt sự kiện tìm kiếm
        document.getElementById('btnSearch').addEventListener('click', () => {
            loadPackages(document.getElementById('searchInput').value);
        });
        document.getElementById('searchInput').addEventListener('keypress', (e) => {
            if(e.key === 'Enter') loadPackages(e.target.value);
        });

        // Bắt sự kiện nhấn nút Thêm Gói Khám
        document.getElementById('btnAddPackage').addEventListener('click', () => {
            document.getElementById('packageForm').reset();
            document.getElementById('packageId').value = '';
            document.getElementById('packageModalTitle').innerText = 'Thêm gói khám mới';
        });

        // Bắt sự kiện nhấn Lưu Thông Tin
        document.getElementById('btnSavePackage').addEventListener('click', async () => {
            const id = document.getElementById('packageId').value;
            const tenGoi = document.getElementById('tenGoi').value.trim();
            const giaTien = document.getElementById('giaTien').value;

            if (!tenGoi || giaTien === '') {
                alert('Vui lòng nhập Tên gói và Giá tiền!');
                return;
            }

            const btnSave = document.getElementById('btnSavePackage');
            const originalText = btnSave.innerHTML;
            btnSave.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...`;
            btnSave.disabled = true;

            const data = {
                ten_goi: tenGoi,
                mo_ta: document.getElementById('moTa').value.trim(),
                gia_tien: parseInt(giaTien, 10) || 0
            };

            const url = id ? `${API_URL}/update/${id}` : `${API_URL}/store`;
            const method = id ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await res.json();
                
                if (result.success) {
                    packageModal.hide();
                    loadPackages(document.getElementById('searchInput').value);
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: result.message || 'Đã lưu thành công.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    alert(result.error || 'Có lỗi xảy ra trong quá trình lưu dữ liệu!');
                }
            } catch (err) {
                console.error(err);
                alert('Lỗi kết nối tới máy chủ!');
            } finally {
                btnSave.innerHTML = originalText;
                btnSave.disabled = false;
            }
        });

        // Ủy quyền sự kiện cho nút Sửa và Xóa
        document.getElementById('packageTableBody').addEventListener('click', async (e) => {
            const btnEdit = e.target.closest('.btn-edit');
            const btnDelete = e.target.closest('.btn-delete');

            // Xử lý Click SỬA
            if (btnEdit) {
                const id = btnEdit.dataset.id;
                
                const originalHtml = btnEdit.innerHTML;
                btnEdit.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
                btnEdit.disabled = true;

                try {
                    const res = await fetch(`${API_URL}/show/${id}`);
                    const result = await res.json();
                    if (result.success) {
                        const d = result.data;
                        document.getElementById('packageId').value = d.id;
                        document.getElementById('tenGoi').value = d.ten_goi;
                        document.getElementById('giaTien').value = d.gia_tien || 0;
                        document.getElementById('moTa').value = d.mo_ta || '';
                        
                        document.getElementById('packageModalTitle').innerText = 'Cập nhật gói khám';
                        packageModal.show();
                    }
                } catch (err) {
                    console.error(err);
                    alert('Lỗi tải dữ liệu!');
                } finally {
                    btnEdit.innerHTML = originalHtml;
                    btnEdit.disabled = false;
                }
            }

            // Xử lý Click XÓA
            if (btnDelete) {
                const id = btnDelete.dataset.id;
                
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: "Hành động này sẽ xóa gói khám vĩnh viễn!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Vâng, xóa nó!',
                    cancelButtonText: 'Hủy bỏ'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const res = await fetch(`${API_URL}/delete/${id}`, { method: 'DELETE' });
                            const data = await res.json();
                            if (data.success) {
                                Swal.fire('Đã xóa!', 'Gói khám đã được xóa.', 'success');
                                loadPackages(document.getElementById('searchInput').value);
                            } else {
                                Swal.fire('Lỗi!', data.error || 'Xóa dữ liệu thất bại!', 'error');
                            }
                        } catch (err) {
                            console.error(err);
                            Swal.fire('Lỗi!', 'Lỗi kết nối tới máy chủ!', 'error');
                        }
                    }
                });
            }
        });
    });
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>

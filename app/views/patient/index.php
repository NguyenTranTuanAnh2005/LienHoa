<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<!-- Import Font Lexend -->
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Custom Styling matching the requested primary color and fonts */
    :root {
        --patient-primary: #0d5c75;
        --patient-primary-hover: #0a4659;
    }
    
    .text-patient-primary {
        color: var(--patient-primary) !important;
    }
    
    .bg-patient-primary {
        background-color: var(--patient-primary) !important;
        color: white;
    }
    
    .btn-patient-primary {
        background-color: var(--patient-primary);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-patient-primary:hover {
        background-color: var(--patient-primary-hover);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 92, 117, 0.2);
    }

    .btn-outline-patient {
        border-color: var(--patient-primary);
        color: var(--patient-primary);
    }

    .btn-outline-patient:hover {
        background-color: var(--patient-primary);
        color: white;
    }

    .table-patient th {
        background-color: var(--patient-primary) !important;
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
            <h2 class="text-patient-primary fw-bold mb-0">Quản lý Bệnh Nhân</h2>
            <p class="text-muted small mt-1 mb-0">Hệ thống tra cứu và cập nhật hồ sơ y tế</p>
        </div>
        
        <!-- Công cụ (Search + Nút Thêm) -->
        <div class="col-md-8 d-flex gap-3 justify-content-md-end flex-wrap flex-md-nowrap">
            <div class="input-group shadow-sm" style="max-width: 350px;">
                <input type="text" id="searchInput" class="form-control rounded-pill-start border-end-0 py-2" placeholder="Tìm tên hoặc SĐT...">
                <button class="btn btn-outline-secondary rounded-pill-end border-start-0 py-2 px-3 bg-white" id="btnSearch" type="button">
                    <i class="bi bi-search text-patient-primary"></i>
                </button>
            </div>
            
            <button class="btn btn-patient-primary btn-lg rounded-pill px-4 text-nowrap fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#patientModal" id="btnAddPatient">
                <i class="bi bi-plus-circle me-2"></i>Thêm bệnh nhân mới
            </button>
        </div>
    </div>

    <!-- Danh sách Bệnh nhân -->
    <div class="card shadow-sm border-0 card-custom overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-patient align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-3 px-4">Mã BN</th>
                            <th class="py-3">Họ và tên</th>
                            <th class="py-3">Ngày sinh</th>
                            <th class="py-3">Số điện thoại</th>
                            <th class="py-3">Chuẩn đoán</th>
                            <th class="py-3 px-4 text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="patientTableBody">
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="spinner-border text-patient-primary mb-3" role="status"></div>
                                <div>Đang tải dữ liệu...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm / Sửa Bệnh nhân -->
<div class="modal fade" id="patientModal" tabindex="-1" style="font-family: 'Lexend', 'Inter', sans-serif;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-patient-primary py-3">
                <h5 class="modal-title fw-bold" id="patientModalTitle">Thêm bệnh nhân mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <form id="patientForm">
                    <input type="hidden" id="patientId">
                    <div class="row g-4">
                        <!-- Họ và tên -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-sm border-0" id="fullName" placeholder="Nhập họ tên đầy đủ" required>
                        </div>
                        
                        <!-- Số điện thoại -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-sm border-0" id="phone" placeholder="Nhập số điện thoại liên lạc" required>
                        </div>

                        <div class="col-12">
    <label class="form-label fw-semibold text-dark">Chuẩn đoán ban đầu</label>
    <select class="form-select rounded-3 py-2 shadow-sm border-0" id="diagnosis">
        <option value="" disabled selected>Chọn chuẩn đoán...</option>
        <option value="Cao huyết áp">Cao huyết áp</option>
        <option value="Đau dạ dày">Đau dạ dày</option>
        <option value="Sốt siêu vi">Sốt siêu vi</option>
        <option value="Suy nhược cơ thể">Suy nhược cơ thể</option>
        <option value="Gout cấp tính">Gout cấp tính</option>
        <option value="Chấn thương phần mềm">Chấn thương phần mềm</option>
        <option value="Rối Loạn Tiền Đình">Rối Loạn Tiền Đình</option>
        <option value="Viêm Xoang">Viêm Xoang</option>
        <option value="Thiếu Máu Nhẹ">Thiếu Máu Nhẹ</option>
        <option value="Cảm cúm thông thường">Cảm cúm thông thường</option>
        <option value="Đau thắt lưng">Đau thắt lưng</option>
        <option value="Viêm Dạ Dày">Viêm Dạ Dày</option>
        <option value="Khác">Khác (Nhập thêm chi tiết sau)</option>
    </select>
</div>
                        
                        <!-- Ngày sinh -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Ngày sinh</label>
                            <input type="date" class="form-control rounded-3 py-2 shadow-sm border-0 text-muted" id="birthday">
                        </div>
                        
                        <!-- Giới tính -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Giới tính</label>
                            <select class="form-select rounded-3 py-2 shadow-sm border-0" id="gender">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                                <option value="Khác" selected>Khác</option>
                            </select>
                        </div>
                        
                        <!-- CCCD -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">CCCD / Mã định danh</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-sm border-0" id="cccd" placeholder="Nhập số thẻ căn cước (nếu có)">
                        </div>
                        
                        <!-- Địa chỉ -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Địa chỉ liên hệ</label>
                            <textarea class="form-control rounded-3 py-2 shadow-sm border-0" id="address" rows="2" placeholder="Nhập địa chỉ cư trú hiện tại"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-white border-top-0 py-3 rounded-bottom-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold border text-muted" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-patient-primary rounded-pill px-4 fw-semibold shadow-sm" id="btnSavePatient">Lưu thông tin</button>
            </div>
        </div>
    </div>
</div>

<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Định nghĩa URL kết nối API (Controller đã viết)
    const API_URL = '<?= BASE_URL ?>/patient';
    let patientModal; 
    
    // Hàm tải dữ liệu danh sách
    async function loadPatients(search = '') {
        try {
            const timestamp = new Date().getTime();
            const res = await fetch(`${API_URL}/apiList?search=${encodeURIComponent(search)}&_t=${timestamp}`);
            const result = await res.json();
            
            const tbody = document.getElementById('patientTableBody');
            tbody.innerHTML = '';
            
            if (result.success && result.data.length > 0) {
                result.data.forEach(p => {
                    const dob = p.birthday ? new Date(p.birthday).toLocaleDateString('vi-VN') : '<span class="text-muted">Chưa cập nhật</span>';
                    
                    const statusBadge = p.status === 'nhap_vien' 
                        ? '<span class="badge bg-primary ms-2 rounded-pill">Nhập viện</span>' 
                        : (p.status === 'xuat_vien' ? '<span class="badge bg-success ms-2 rounded-pill">Xuất viện</span>' : '');

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-4 fw-bold text-dark align-middle">${p.patient_code}</td>
                        <td class="align-middle">
                            <div class="fw-bold text-dark d-flex align-items-center">${p.full_name} ${statusBadge}</div>
                            <small class="text-muted fw-medium"><i class="bi bi-gender-ambiguous me-1"></i>${p.gender}</small>
                        </td>
                        <td class="align-middle">${dob}</td>
                        <td class="align-middle fw-medium">${p.phone}</td>
                        <!-- Hiển thị cột Chuẩn đoán -->
                        <td class="align-middle">${p.diagnosis || '<span class="text-muted small">Chưa có</span>'}</td>
                        <td class="px-4 text-end align-middle">
                            <div class="d-flex gap-2 justify-content-end align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-info text-white rounded-pill px-3 fw-medium dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-arrow-repeat me-1"></i>Cập nhật
                                    </button>
                                    <ul class="dropdown-menu shadow-sm border-0">
                                        <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(${p.id}, 'nhap_vien')"><i class="bi bi-hospital me-2 text-primary"></i>Nhập viện</a></li>
                                        <li><a class="dropdown-item py-2" href="#" onclick="updateStatus(${p.id}, 'xuat_vien')"><i class="bi bi-house-door me-2 text-success"></i>Xuất viện</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-sm btn-warning text-dark rounded-pill px-3 fw-medium btn-edit" data-id="${p.id}">
                                    <i class="bi bi-pencil-square me-1"></i>Sửa
                                </button>
                                <button class="btn btn-sm btn-danger text-white rounded-pill px-3 fw-medium btn-delete" data-id="${p.id}">
                                    <i class="bi bi-trash me-1"></i>Xóa
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>Chưa có bệnh nhân nào</td></tr>`;
            }
        } catch (err) {
            console.error('Error fetching patients:', err);
            alert('Lỗi tải dữ liệu: Vui lòng nhấn Ctrl + F5 để làm mới trình duyệt hoàn toàn!');
        }
    }

    // Khởi tạo trang
    document.addEventListener('DOMContentLoaded', () => {
        patientModal = new bootstrap.Modal(document.getElementById('patientModal'));
        loadPatients();
        
        document.getElementById('btnSearch').addEventListener('click', () => {
            loadPatients(document.getElementById('searchInput').value);
        });
        
        document.getElementById('btnAddPatient').addEventListener('click', () => {
            document.getElementById('patientForm').reset();
            document.getElementById('patientId').value = '';
            document.getElementById('patientModalTitle').innerText = 'Thêm bệnh nhân mới';
        });

        // Bắt sự kiện nhấn Lưu Thông Tin
        document.getElementById('btnSavePatient').addEventListener('click', async () => {
            const id = document.getElementById('patientId').value;
            const data = {
                full_name: document.getElementById('fullName').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                birthday: document.getElementById('birthday').value,
                gender: document.getElementById('gender').value,
                cccd: document.getElementById('cccd').value.trim(),
                address: document.getElementById('address').value.trim(),
                diagnosis: document.getElementById('diagnosis').value.trim() // Bổ sung trường này
            };

            if (!data.full_name || !data.phone) {
                alert('Vui lòng nhập Họ và tên và Số điện thoại!');
                return;
            }

            const btnSave = document.getElementById('btnSavePatient');
            btnSave.disabled = true;

            try {
                const res = await fetch(id ? `${API_URL}/update/${id}` : `${API_URL}/store`, {
                    method: id ? 'PUT' : 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await res.json();
                
                if (result.success) {
                    patientModal.hide();
                    loadPatients(document.getElementById('searchInput').value);
                } else {
                    alert(result.error || 'Có lỗi xảy ra!');
                }
            } finally {
                btnSave.disabled = false;
            }
        });

        // Xử lý Sửa và Xóa (Event Delegation)
        document.getElementById('patientTableBody').addEventListener('click', async (e) => {
            const btnEdit = e.target.closest('.btn-edit');
            const btnDelete = e.target.closest('.btn-delete');

            if (btnEdit) {
                const id = btnEdit.dataset.id;
                const res = await fetch(`${API_URL}/show/${id}`);
                const result = await res.json();
                if (result.success) {
                    const p = result.data;
                    document.getElementById('patientId').value = p.id;
                    document.getElementById('fullName').value = p.full_name;
                    document.getElementById('phone').value = p.phone;
                    document.getElementById('birthday').value = p.birthday || '';
                    document.getElementById('gender').value = p.gender || 'Khác';
                    document.getElementById('cccd').value = p.cccd || '';
                    document.getElementById('address').value = p.address || '';
                    document.getElementById('diagnosis').value = p.diagnosis || ''; // Đổ dữ liệu vào form
                    
                    document.getElementById('patientModalTitle').innerText = 'Cập nhật thông tin bệnh nhân';
                    patientModal.show();
                }
            }

            if (btnDelete) {
                const id = btnDelete.dataset.id;
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Vâng, xóa!'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const res = await fetch(`${API_URL}/delete/${id}`, { method: 'DELETE' });
                        const data = await res.json();
                        if (data.success) {
                            loadPatients(document.getElementById('searchInput').value);
                            Swal.fire('Đã xóa!', '', 'success');
                        }
                    }
                });
            }
        });
    });

    // Cập nhật trạng thái
    async function updateStatus(id, status) {
        const res = await fetch(`${API_URL}/update/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status: status })
        });
        if ((await res.json()).success) loadPatients(document.getElementById('searchInput').value);
    }
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>

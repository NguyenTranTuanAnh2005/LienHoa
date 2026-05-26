<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<!-- Import Font Lexend -->
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Custom Styling matching the requested primary color and fonts */
    :root {
        --doctor-primary: #0d5c75;
        --doctor-primary-hover: #0a4659;
    }
    
    .text-doctor-primary {
        color: var(--doctor-primary) !important;
    }
    
    .bg-doctor-primary {
        background-color: var(--doctor-primary) !important;
        color: white;
    }
    
    .btn-doctor-primary {
        background-color: var(--doctor-primary);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-doctor-primary:hover {
        background-color: var(--doctor-primary-hover);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 92, 117, 0.2);
    }

    .btn-outline-doctor {
        border-color: var(--doctor-primary);
        color: var(--doctor-primary);
    }

    .btn-outline-doctor:hover {
        background-color: var(--doctor-primary);
        color: white;
    }

    .table-doctor th {
        background-color: var(--doctor-primary) !important;
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
            <h2 class="text-doctor-primary fw-bold mb-0">Quản lý Bác Sĩ</h2>
            <p class="text-muted small mt-1 mb-0">Hệ thống quản lý thông tin bác sĩ và chuyên khoa</p>
        </div>
        
        <!-- Công cụ (Search + Nút Thêm) -->
        <div class="col-md-8 d-flex gap-3 justify-content-md-end flex-wrap flex-md-nowrap">
            <div class="input-group shadow-sm" style="max-width: 350px;">
                <input type="text" id="searchInput" class="form-control rounded-pill-start border-end-0 py-2" placeholder="Tìm tên hoặc chuyên khoa...">
                <button class="btn btn-outline-secondary rounded-pill-end border-start-0 py-2 px-3 bg-white" id="btnSearch" type="button">
                    <i class="bi bi-search text-doctor-primary"></i>
                </button>
            </div>
            
            <button class="btn btn-doctor-primary btn-lg rounded-pill px-4 text-nowrap fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#doctorModal" id="btnAddDoctor">
                <i class="bi bi-plus-circle me-2"></i>Thêm bác sĩ mới
            </button>
        </div>
    </div>

    <!-- Danh sách Bác sĩ -->
    <div class="card shadow-sm border-0 card-custom overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-doctor align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3">Họ và tên</th>
                            <th class="py-3">Chuyên khoa</th>
                            <th class="py-3">Hình ảnh</th>
                            <th class="py-3 px-4 text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="doctorTableBody">
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="spinner-border text-doctor-primary mb-3" role="status"></div>
                                <div>Đang tải dữ liệu...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm / Sửa Bác sĩ -->
<div class="modal fade" id="doctorModal" tabindex="-1" style="font-family: 'Lexend', 'Inter', sans-serif;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-doctor-primary py-3">
                <h5 class="modal-title fw-bold" id="doctorModalTitle">Thêm bác sĩ mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <form id="doctorForm">
                    <input type="hidden" id="doctorId">
                    <div class="row g-4">
                        <!-- Họ và tên -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-sm border-0" id="hoTen" placeholder="Nhập họ tên đầy đủ" required>
                        </div>
                        
                        <!-- Chuyên khoa -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Chuyên khoa <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3 py-2 shadow-sm border-0" id="idChuyenKhoa" required>
                                <option value="">-- Chọn chuyên khoa --</option>
                            </select>
                        </div>
                        
                        <!-- Hình ảnh -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Tên file hình ảnh</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-sm border-0" id="hinhAnh" placeholder="Ví dụ: doctor_name.png">
                        </div>
                        
                        <!-- Tiểu sử -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Tiểu sử</label>
                            <textarea class="form-control rounded-3 py-2 shadow-sm border-0" id="tieuSu" rows="3" placeholder="Nhập tiểu sử bác sĩ"></textarea>
                        </div>
                        
                        <!-- Lịch làm việc định kỳ -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark mb-2"><i class="bi bi-clock-history me-1"></i> Thời gian làm việc định kỳ</label>
                            <div class="p-3 bg-white rounded-3 border">
                                <div class="d-flex flex-wrap gap-3 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="work_T2" checked>
                                        <label class="form-check-label fw-medium" for="work_T2">T2</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="work_T3" checked>
                                        <label class="form-check-label fw-medium" for="work_T3">T3</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="work_T4" checked>
                                        <label class="form-check-label fw-medium" for="work_T4">T4</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="work_T5" checked>
                                        <label class="form-check-label fw-medium" for="work_T5">T5</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="work_T6" checked>
                                        <label class="form-check-label fw-medium" for="work_T6">T6</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="work_T7">
                                        <label class="form-check-label fw-medium" for="work_T7">T7</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="work_CN">
                                        <label class="form-check-label fw-medium" for="work_CN">CN</label>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-sun text-warning"></i> Sáng</span>
                                            <input type="text" class="form-control border" id="ca_sang" value="09:00 AM - 11:00 AM">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-moon-stars text-info"></i> Tối</span>
                                            <input type="text" class="form-control border" id="ca_toi" value="10:00 PM - 20:00 PM">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-medium" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-doctor-primary rounded-pill px-4 fw-medium shadow-sm" id="btnSaveDoctor">Lưu thông tin</button>
            </div>
        </div>
    </div>
</div>

<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Định nghĩa URL kết nối API
    const API_URL = '<?= BASE_URL ?>/doctormanagement';
    let doctorModal;
    
    // Hàm tải danh sách chuyên khoa
    async function loadSpecialties() {
        try {
            const res = await fetch(`${API_URL}/getSpecialties`);
            const result = await res.json();
            
            if (result.success) {
                const selectSpecialty = document.getElementById('idChuyenKhoa');
                selectSpecialty.innerHTML = '<option value="">-- Chọn chuyên khoa --</option>';
                
                result.data.forEach(specialty => {
                    const option = document.createElement('option');
                    option.value = specialty.id;
                    option.textContent = specialty.ten_khoa;
                    selectSpecialty.appendChild(option);
                });
            }
        } catch (err) {
            console.error('Error loading specialties:', err);
        }
    }
    
    // Hàm tải dữ liệu danh sách bác sĩ
    async function loadDoctors(search = '') {
        try {
            const timestamp = new Date().getTime();
            const res = await fetch(`${API_URL}/apiList?search=${encodeURIComponent(search)}&_t=${timestamp}`);
            const result = await res.json();
            
            const tbody = document.getElementById('doctorTableBody');
            tbody.innerHTML = '';
            
            if (result.success && result.data.length > 0) {
                result.data.forEach(d => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-4 fw-bold text-dark align-middle">${d.id}</td>
                        <td class="align-middle">
                            <div class="fw-bold text-dark">${d.ho_ten}</div>
                        </td>
                        <td class="align-middle">${d.chuyen_khoa || '<span class="text-muted">Chưa gán</span>'}</td>
                        <td class="align-middle"><small class="text-muted">${d.hinh_anh || 'Chưa cập nhật'}</small></td>
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
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>Chưa có bác sĩ nào</td></tr>`;
            }
        } catch (err) {
            console.error('Error fetching doctors:', err);
            alert('Lỗi tải dữ liệu: Vui lòng nhấn Ctrl + F5 để làm mới trình duyệt hoàn toàn!');
        }
    }

    // Khởi tạo trang
    document.addEventListener('DOMContentLoaded', () => {
        doctorModal = new bootstrap.Modal(document.getElementById('doctorModal'));
        
        loadSpecialties(); // Tải danh sách chuyên khoa
        loadDoctors(); // Tải danh sách bác sĩ
        
        // Bắt sự kiện tìm kiếm
        document.getElementById('btnSearch').addEventListener('click', () => {
            loadDoctors(document.getElementById('searchInput').value);
        });
        document.getElementById('searchInput').addEventListener('keypress', (e) => {
            if(e.key === 'Enter') loadDoctors(e.target.value);
        });

        // Bắt sự kiện nhấn nút Thêm Bác Sĩ
        document.getElementById('btnAddDoctor').addEventListener('click', () => {
            document.getElementById('doctorForm').reset();
            document.getElementById('doctorId').value = '';
            document.getElementById('doctorModalTitle').innerText = 'Thêm bác sĩ mới';
            document.getElementById('work_T2').checked = true;
            document.getElementById('work_T3').checked = true;
            document.getElementById('work_T4').checked = true;
            document.getElementById('work_T5').checked = true;
            document.getElementById('work_T6').checked = true;
            document.getElementById('work_T7').checked = false;
            document.getElementById('work_CN').checked = false;
            document.getElementById('ca_sang').value = '09:00 AM - 11:00 AM';
            document.getElementById('ca_toi').value = '10:00 PM - 20:00 PM';
        });

        // Bắt sự kiện nhấn Lưu Thông Tin
        document.getElementById('btnSaveDoctor').addEventListener('click', async () => {
            const id = document.getElementById('doctorId').value;
            const hoTen = document.getElementById('hoTen').value.trim();
            const idChuyenKhoa = document.getElementById('idChuyenKhoa').value;

            if (!hoTen || !idChuyenKhoa) {
                alert('Vui lòng nhập Họ và tên và Chọn chuyên khoa!');
                return;
            }

            const btnSave = document.getElementById('btnSaveDoctor');
            const originalText = btnSave.innerHTML;
            btnSave.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...`;
            btnSave.disabled = true;

            const lichLamViec = {
                days: {
                    "T2": document.getElementById('work_T2').checked,
                    "T3": document.getElementById('work_T3').checked,
                    "T4": document.getElementById('work_T4').checked,
                    "T5": document.getElementById('work_T5').checked,
                    "T6": document.getElementById('work_T6').checked,
                    "T7": document.getElementById('work_T7').checked,
                    "CN": document.getElementById('work_CN').checked
                },
                ca_sang: document.getElementById('ca_sang').value.trim(),
                ca_toi: document.getElementById('ca_toi').value.trim()
            };

            const data = {
                ho_ten: hoTen,
                id_chuyen_khoa: idChuyenKhoa,
                hinh_anh: document.getElementById('hinhAnh').value.trim(),
                tieu_su: document.getElementById('tieuSu').value.trim(),
                lich_lam_viec: JSON.stringify(lichLamViec)
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
                    doctorModal.hide();
                    loadDoctors(document.getElementById('searchInput').value);
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
        document.getElementById('doctorTableBody').addEventListener('click', async (e) => {
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
                        document.getElementById('doctorId').value = d.id;
                        document.getElementById('hoTen').value = d.ho_ten;
                        document.getElementById('idChuyenKhoa').value = d.id_chuyen_khoa || '';
                        document.getElementById('hinhAnh').value = d.hinh_anh || '';
                        document.getElementById('tieuSu').value = d.tieu_su || '';
                        
                        if (d.lich_lam_viec) {
                            try {
                                const lich = JSON.parse(d.lich_lam_viec);
                                if (lich.days) {
                                    document.getElementById('work_T2').checked = !!lich.days["T2"];
                                    document.getElementById('work_T3').checked = !!lich.days["T3"];
                                    document.getElementById('work_T4').checked = !!lich.days["T4"];
                                    document.getElementById('work_T5').checked = !!lich.days["T5"];
                                    document.getElementById('work_T6').checked = !!lich.days["T6"];
                                    document.getElementById('work_T7').checked = !!lich.days["T7"];
                                    document.getElementById('work_CN').checked = !!lich.days["CN"];
                                }
                                document.getElementById('ca_sang').value = lich.ca_sang || '09:00 AM - 11:00 AM';
                                document.getElementById('ca_toi').value = lich.ca_toi || '10:00 PM - 20:00 PM';
                            } catch (e) {
                                document.getElementById('doctorForm').reset();
                            }
                        } else {
                            document.getElementById('work_T2').checked = true;
                            document.getElementById('work_T3').checked = true;
                            document.getElementById('work_T4').checked = true;
                            document.getElementById('work_T5').checked = true;
                            document.getElementById('work_T6').checked = true;
                            document.getElementById('work_T7').checked = false;
                            document.getElementById('work_CN').checked = false;
                            document.getElementById('ca_sang').value = '09:00 AM - 11:00 AM';
                            document.getElementById('ca_toi').value = '10:00 PM - 20:00 PM';
                        }
                        
                        document.getElementById('doctorModalTitle').innerText = 'Cập nhật thông tin bác sĩ';
                        doctorModal.show();
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
                    text: "Hành động này sẽ xóa bác sĩ vĩnh viễn!",
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
                                Swal.fire('Đã xóa!', 'Bác sĩ đã được xóa khỏi hệ thống.', 'success');
                                loadDoctors(document.getElementById('searchInput').value);
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
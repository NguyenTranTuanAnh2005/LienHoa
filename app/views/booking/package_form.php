<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-modern-card">
                <!-- Header: Đồng bộ style -->
                <div class="form-modern-header text-center">
                    <h2 class="form-modern-title text-uppercase">ĐẶT GÓI KHÁM</h2>
                    <p class="form-modern-subtitle">Vui lòng điền đầy đủ thông tin để chúng tôi phục vụ bạn tốt nhất</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="<?= BASE_URL ?>/booking/store" method="POST" id="packageForm">
                        
                        <?php if (!empty($selected_package)): ?>
                            <input type="hidden" name="package_id" value="<?= $selected_package['id'] ?>">
                            <input type="hidden" name="package_name" value="<?= htmlspecialchars($selected_package['ten_goi']) ?>">
                        <?php endif; ?>

                        <div class="row">
                            <!-- CỘT TRÁI: THÔNG TIN BỆNH NHÂN -->
                            <div class="col-md-6 mb-4 pe-md-4 border-end-md">
                                <h4 class="section-title">
                                    <i class="bi bi-person"></i>Thông tin bệnh nhân
                                </h4>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_name" class="form-control py-2 custom-input" placeholder="Nhập đầy đủ họ tên" value="<?= isset($current_patient['full_name']) ? htmlspecialchars($current_patient['full_name']) : '' ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label small fw-bold">Ngày sinh <span class="text-danger">*</span></label>
                                        <input type="date" name="dob" class="form-control py-2 custom-input" value="<?= isset($current_patient['birthday']) ? htmlspecialchars($current_patient['birthday']) : '' ?>" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label small fw-bold">Giới tính <span class="text-danger">*</span></label>
                                        <select name="gender" class="form-select py-2 custom-input">
                                            <option value="Nam" <?= (isset($current_patient['gender']) && $current_patient['gender'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                                            <option value="Nữ" <?= (isset($current_patient['gender']) && $current_patient['gender'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                            <option value="Khác" <?= (isset($current_patient['gender']) && $current_patient['gender'] == 'Khác') ? 'selected' : '' ?>>Khác</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control py-2 custom-input" placeholder="Số điện thoại liên hệ" value="<?= isset($current_patient['phone']) ? htmlspecialchars($current_patient['phone']) : '' ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Số CCCD/CMND</label>
                                    <input type="text" name="cccd" class="form-control py-2 custom-input" placeholder="Nhập số định danh" value="<?= isset($current_patient['cccd']) ? htmlspecialchars($current_patient['cccd']) : '' ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control py-2 custom-input" placeholder="Tỉnh/Thành phố, Quận/Huyện" value="<?= isset($current_patient['address']) ? htmlspecialchars($current_patient['address']) : '' ?>">
                                </div>
                            </div>

                            <!-- CỘT PHẢI: DỊCH VỤ KHÁM -->
                            <div class="col-md-6 mb-4 ps-md-4">
                                <h4 class="section-title">
                                    <i class="bi bi-clipboard2-pulse"></i>Dịch vụ khám
                                </h4>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Cơ sở thăm khám <span class="text-danger">*</span></label>
                                    <select name="hospital" class="form-select py-2 custom-input" required>
                                        <option value="Liên Hoa">Bệnh Viện Liên Hoa (Trụ sở chính)</option>
                                        <option value="CS2">Bệnh Viện Liên Hoa (Cơ sở 2)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Gói chăm sóc sức khỏe <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control py-2 custom-input bg-light" 
                                           value="<?= !empty($selected_package) ? htmlspecialchars($selected_package['ten_goi']) : 'Chưa chọn gói khám' ?>" 
                                           readonly>
                                    <?php if (empty($selected_package)): ?>
                                        <small class="text-danger">Vui lòng quay lại trang danh sách gói khám để chọn gói.</small>
                                    <?php else: ?>
                                        <small class="text-muted">Giá: <?= number_format($selected_package['gia_tien'], 0, ',', '.') ?> VNĐ</small>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Ngày và giờ hẹn/đặt <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="appointment_date" class="form-control py-2 custom-input" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Email nhận thông báo</label>
                                    <input type="email" name="email" class="form-control py-2 custom-input" placeholder="example@gmail.com" value="<?= isset($current_patient['email']) ? htmlspecialchars($current_patient['email']) : '' ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Ghi chú triệu chứng</label>
                                    <textarea name="notes" class="form-control custom-input" rows="2" placeholder="Mô tả ngắn gọn tình trạng sức khỏe của bạn..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-lg text-white px-5 py-3 fw-bold custom-submit-btn" <?= empty($selected_package) ? 'disabled' : '' ?>>
                                XÁC NHẬN ĐẶT GÓI KHÁM
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer: Giữ nguyên thông tin hỗ trợ -->
                <div class="bg-light-footer p-4 text-center border-top">
                    <p class="mb-2 text-muted small">* Lưu ý: Thời gian khám có thể thay đổi tùy theo tình trạng thực tế của bệnh viện.</p>
                    <p class="mb-0 fw-bold" style="color: #0d5c75;">
                        <i class="bi bi-telephone-fill me-2"></i>Hotline hỗ trợ: (028) 3820 6001
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Form Modern UI */
    .form-modern-card {
        border-radius: 24px;
        border: none;
        box-shadow: 0 15px 45px rgba(13, 92, 117, 0.08);
        background: #fff;
        overflow: hidden;
    }
    .form-modern-header {
        background: linear-gradient(135deg, #0d5c75 0%, #178eb4 100%);
        padding: 2.5rem 2rem;
        position: relative;
    }
    .form-modern-header::before {
        content: ''; position: absolute; top: -30px; left: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.08); border-radius: 50%;
    }
    .form-modern-header::after {
        content: ''; position: absolute; bottom: -40px; right: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.06); border-radius: 50%;
    }
    .form-modern-title {
        color: #fff; font-weight: 800; letter-spacing: 1px; margin-bottom: 0.5rem; position: relative; z-index: 2;
    }
    .form-modern-subtitle {
        color: rgba(255,255,255,0.85); font-size: 1rem; position: relative; z-index: 2;
    }
    .section-title {
        color: #0d5c75; font-weight: 700; font-size: 1.3rem; margin-bottom: 1.8rem; display: flex; align-items: center;
    }
    .section-title i {
        background: rgba(13, 92, 117, 0.08); color: #0d5c75; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; margin-right: 15px; font-size: 1.3rem;
    }
    .custom-input {
        background-color: #f8fafd; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.8rem 1.2rem; color: #2d3748; font-size: 0.95rem; transition: all 0.3s ease;
    }
    .custom-input:focus {
        background-color: #fff; border-color: #0dcaf0; box-shadow: 0 0 0 4px rgba(13, 202, 240, 0.15);
    }
    .custom-submit-btn {
        background: linear-gradient(135deg, #0d5c75 0%, #1585a9 100%); color: #fff; border: none; border-radius: 50px; padding: 15px 45px; font-weight: 700; letter-spacing: 0.5px; box-shadow: 0 10px 25px rgba(13, 92, 117, 0.25); transition: all 0.3s ease; text-transform: uppercase;
    }
    .custom-submit-btn:hover:not(:disabled) {
        transform: translateY(-3px); box-shadow: 0 15px 30px rgba(13, 92, 117, 0.35); color: #fff;
    }
    @media (min-width: 768px) {
        .border-end-md { border-right: 1px dashed #dee2e6 !important; }
    }
    .bg-light-footer { background-color: #f8fafd !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script>
    document.getElementById('packageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận đăng ký gói khám?',
            html: 'Bạn có chắc chắn muốn đăng ký gói khám này?<br><small class="text-muted">Vui lòng kiểm tra kỹ thông tin trước khi xác nhận.</small>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> XÁC NHẬN',
            cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Hủy',
            customClass: {
                confirmButton: 'btn custom-submit-btn px-4 py-2 me-3',
                cancelButton: 'btn btn-light border px-4 py-2 fw-bold text-dark',
                popup: 'rounded-4 shadow-lg border-0',
                title: 'fw-bold text-dark'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>

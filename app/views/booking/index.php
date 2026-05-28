<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-modern-card">
                <div class="form-modern-header text-center">
                    <h2 class="form-modern-title text-uppercase" data-lang="book_form_title_appointment">ĐẶT LỊCH HẸN KHÁM</h2>
                    <p class="form-modern-subtitle" data-lang="book_form_desc_short">Vui lòng điền đầy đủ thông tin để chúng tôi phục vụ bạn tốt nhất</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="<?= BASE_URL ?>/booking/store" method="POST" id="bookingForm">
                        <div class="row">
                            <div class="col-md-6 mb-4 pe-md-4 border-end-md">
                                <h4 class="section-title">
                                    <i class="bi bi-person"></i><span data-lang="book_cust_info">Thông tin bệnh nhân</span>
                                </h4>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold"><span data-lang="book_lbl_name">Họ và tên</span> <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_name" class="form-control py-2 custom-input" data-lang="book_plh_name" placeholder="Nhập đầy đủ họ tên" value="<?= isset($current_patient['full_name']) ? htmlspecialchars($current_patient['full_name']) : '' ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label small fw-bold"><span data-lang="book_plh_dob">Ngày sinh</span> <span class="text-danger">*</span></label>
                                        <input type="date" name="dob" class="form-control py-2 custom-input" value="<?= isset($current_patient['birthday']) ? htmlspecialchars($current_patient['birthday']) : '' ?>" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label small fw-bold"><span data-lang="book_lbl_gender">Giới tính</span> <span class="text-danger">*</span></label>
                                        <select name="gender" class="form-select py-2 custom-input">
                                            <option value="Nam" data-lang="book_gender_male" <?= (isset($current_patient['gender']) && $current_patient['gender'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                                            <option value="Nữ" data-lang="book_gender_female" <?= (isset($current_patient['gender']) && $current_patient['gender'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                            <option value="Khác" data-lang="book_gender_other" <?= (isset($current_patient['gender']) && $current_patient['gender'] == 'Khác') ? 'selected' : '' ?>>Khác</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold"><span data-lang="book_lbl_phone">Số điện thoại</span> <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control py-2 custom-input" data-lang="book_plh_phone" placeholder="Số điện thoại liên hệ" value="<?= isset($current_patient['phone']) ? htmlspecialchars($current_patient['phone']) : '' ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold" data-lang="book_plh_cccd">Số CCCD/CMND</label>
                                    <input type="text" name="cccd" class="form-control py-2 custom-input" data-lang="book_plh_id" placeholder="Nhập số định danh" value="<?= isset($current_patient['cccd']) ? htmlspecialchars($current_patient['cccd']) : '' ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold" data-lang="book_plh_address">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control py-2 custom-input" data-lang="book_plh_address_detail" placeholder="Tỉnh/Thành phố, Quận/Huyện" value="<?= isset($current_patient['address']) ? htmlspecialchars($current_patient['address']) : '' ?>">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4 ps-md-4">
                                <h4 class="section-title">
                                    <i class="bi bi-clipboard2-pulse"></i><span data-lang="book_service_info">Dịch vụ khám</span>
                                </h4>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold"><span data-lang="book_lbl_hospital">Cơ sở thăm khám</span> <span class="text-danger">*</span></label>
                                    <select name="hospital" class="form-select py-2 custom-input" required>
                                        <option value="Liên Hoa" data-lang="book_hospital_main">Bệnh Viện Liên Hoa (Trụ sở chính)</option>
                                        <option value="CS2" data-lang="book_hospital_2">Bệnh Viện Liên Hoa (Cơ sở 2)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold"><span data-lang="book_opt_specialty">Chuyên khoa cần khám</span> <span class="text-danger">*</span></label>
                                    <select name="specialty" class="form-select py-2 custom-input" required>
                                        <option value="" data-lang="book_select_specialty">-- Chọn chuyên khoa --</option>
                                        <option value="Nội tổng quát" data-translate-text="true">Nội tổng quát</option>
                                        <option value="Nhi khoa" data-translate-text="true">Nhi khoa</option>
                                        <option value="Sản phụ khoa" data-translate-text="true">Sản phụ khoa</option>
                                        <option value="Tim mạch" data-translate-text="true">Tim mạch</option>
                                        <option value="Tai Mũi Họng" data-translate-text="true">Tai Mũi Họng</option>
                                        <option value="Răng Hàm Mặt" data-translate-text="true">Răng Hàm Mặt</option>
                                        <option value="Da liễu" data-translate-text="true">Da liễu</option>
                                        <option value="Ung bướu" data-translate-text="true">Ung Bướu</option>
                                        <option value="Chấn thương chỉnh hình" data-translate-text="true">Chấn thương chỉnh hình</option>

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold"><span data-lang="book_lbl_date">Ngày và giờ hẹn/đặt</span> <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="appointment_date" class="form-control py-2 custom-input" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold" data-lang="book_lbl_email_notice">Email nhận thông báo</label>
                                    <input type="email" name="email" class="form-control py-2 custom-input" data-lang="book_plh_email_notice" placeholder="example@gmail.com" value="<?= isset($current_patient['email']) ? htmlspecialchars($current_patient['email']) : '' ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold"><span data-lang="book_lbl_doctor">Bác sĩ chuyên khoa</span> <span class="text-danger">*</span></label>
                                    <select name="doctor_id" class="form-select py-2 custom-input" required>
                                        <option value="" data-lang="book_select_doctor">-- Chọn bác sĩ --</option>
                                        <option value="Nguyễn Văn An" data-specialty="noi-khoa" data-translate-text="true">BS. Nguyễn Văn An</option>
                                        <option value="Trần Thị Bình" data-specialty="nhi-khoa" data-translate-text="true">BS. Trần Thanh Bình</option>
                                        <option value="Lê Minh Tâm" data-specialty="ngoai-khoa" data-translate-text="true">BS. Lê Minh Tâm</option>
                                        <option value="Phạm Quang Khải" data-specialty="sản-khoa" data-translate-text="true">BS. Phạm Quang Khải</option>
                                        <option value="Lê Quang Hải" data-specialty="nha-khoa" data-translate-text="true">BS. Lê Quang Hải</option>
                                        <option value="Nguyễn Thị Trang" data-specialty="ung-buou" data-translate-text="true">BS. Nguyễn Thị Trang</option>
                                    </select>
                                </div>
                            </div> </div> <div class="text-center mt-4">
                            <button type="submit" class="btn btn-lg text-white px-5 py-3 fw-bold custom-submit-btn" data-lang="btn_submit_appointment">
                                XÁC NHẬN ĐẶT LỊCH NGAY
                            </button>
                        </div>
                    </form>
                </div>
                <div class="bg-light-footer p-4 text-center border-top">
                    <p class="mb-2 text-muted small" data-lang="book_footer_note4">* Lưu ý: Thời gian khám có thể thay đổi tùy theo tình trạng thực tế của bệnh viện.</p>
                    <p class="mb-0 fw-bold" style="color: #0d5c75;">
                        <i class="bi bi-telephone-fill me-2"></i><span data-lang="book_hotline">Hotline hỗ trợ: 1900 8888</span>
                    </p>
                </div>
            </div> </div>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận đặt lịch hẹn?',
            html: 'Bạn có chắc chắn muốn đặt lịch hẹn này?<br><small class="text-muted">Vui lòng kiểm tra kỹ thông tin trước khi xác nhận.</small>',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn custom-submit-btn px-4 py-2 me-3 shadow',
                cancelButton: 'btn btn-light border px-4 py-2 fw-bold shadow-sm',
                popup: 'rounded-4 border-0 shadow-lg'
            },
            confirmButtonText: '<i class="bi bi-check2-circle me-2"></i>Xác nhận',
            cancelButtonText: '<i class="bi bi-x-circle me-2"></i>Hủy',
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
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
<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-modern-card">
                <div class="form-modern-header text-center">
                    <h2 class="form-modern-title text-uppercase">ĐĂNG KÝ XÉT NGHIỆM</h2>
                    <p class="form-modern-subtitle">Vui lòng điền đầy đủ thông tin để tiến hành thủ tục</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="<?= BASE_URL ?>/labtest/store" method="POST" id="labTestForm">
                        <div class="row">
                            <!-- CỘT 1: THÔNG TIN BỆNH NHÂN -->
                            <div class="col-md-6 mb-4 pe-md-4 border-end-md">
                                <h4 class="section-title">
                                    <i class="bi bi-person"></i><span>Thông tin bệnh nhân</span>
                                </h4>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Họ và tên bệnh nhân <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_name" class="form-control py-2 custom-input" placeholder="Nhập đầy đủ họ tên" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold"><span data-lang="book_lbl_gender">Giới tính</span> <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-select py-2 custom-input" required>
                                        <option value="Nam" data-lang="book_gender_male">Nam</option>
                                        <option value="Nữ" data-lang="book_gender_female">Nữ</option>
                                        <option value="Khác" data-lang="book_gender_other">Khác</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control py-2 custom-input" placeholder="Số điện thoại liên hệ" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Số CCCD/CMND</label>
                                    <input type="text" name="cccd" class="form-control py-2 custom-input" placeholder="Nhập số định danh">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Mã bệnh nhân (Nếu có)</label>
                                    <input type="text" name="patient_id" class="form-control py-2 custom-input" placeholder="Mã số bệnh nhân">
                                </div>
                            </div>

                            <!-- CỘT 2: THÔNG TIN XÉT NGHIỆM -->
                            <div class="col-md-6 mb-4 ps-md-4">
                                <h4 class="section-title">
                                    <i class="bi bi-droplet-fill"></i>Thông tin xét nghiệm
                                </h4>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Loại xét nghiệm <span class="text-danger">*</span></label>
                                    <select name="test_type" class="form-select py-2 custom-input" required>
                                        <option value="">-- Chọn loại xét nghiệm --</option>
                                        <option value="Xét nghiệm huyết học">Xét nghiệm huyết học</option>
                                        <option value="Xét nghiệm sinh hóa">Xét nghiệm sinh hóa</option>
                                        <option value="Xét nghiệm miễn dịch">Xét nghiệm miễn dịch</option>
                                        <option value="Xét nghiệm vi sinh & ký sinh trùng">Xét nghiệm vi sinh & ký sinh trùng</option>
                                        <option value="Xét nghiệm sinh học phân tử">Xét nghiệm sinh học phân tử</option>
                                        <option value="Xét nghiệm giải phẫu bệnh">Xét nghiệm giải phẫu bệnh</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Ngày lấy mẫu dự kiến <span class="text-danger">*</span></label>
                                    <input type="date" name="sample_date" class="form-control py-2 custom-input" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Ghi chú (Triệu chứng, yêu cầu khác)</label>
                                    <textarea name="notes" class="form-control custom-input" rows="4" placeholder="Mô tả các yêu cầu đặc biệt hoặc chỉ định của bác sĩ..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-lg text-white px-5 py-3 fw-bold custom-submit-btn">
                                ĐĂNG KÝ XÉT NGHIỆM
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="bg-light-footer p-4 text-center border-top">
                    <p class="mb-2 text-muted small">* Lưu ý: Vui lòng mang theo đầy đủ giấy tờ tùy thân và hồ sơ bệnh án khi đến xét nghiệm.</p>
                    <p class="mb-0 fw-bold" style="color: #0d5c75;">
                        <i class="bi bi-telephone-fill me-2"></i>Hotline hỗ trợ: 1900 8888
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Form Modern UI */
    .form-modern-card { border-radius: 24px; border: none; box-shadow: 0 15px 45px rgba(13, 92, 117, 0.08); background: #fff; overflow: hidden; }
    .form-modern-header { background: linear-gradient(135deg, #0d5c75 0%, #178eb4 100%); padding: 2.5rem 2rem; position: relative; }
    .form-modern-header::before { content: ''; position: absolute; top: -30px; left: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.08); border-radius: 50%; }
    .form-modern-header::after { content: ''; position: absolute; bottom: -40px; right: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.06); border-radius: 50%; }
    .form-modern-title { color: #fff; font-weight: 800; letter-spacing: 1px; margin-bottom: 0.5rem; position: relative; z-index: 2; }
    .form-modern-subtitle { color: rgba(255,255,255,0.85); font-size: 1rem; position: relative; z-index: 2; }
    .section-title { color: #0d5c75; font-weight: 700; font-size: 1.3rem; margin-bottom: 1.8rem; display: flex; align-items: center; }
    .section-title i { background: rgba(13, 92, 117, 0.08); color: #0d5c75; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; margin-right: 15px; font-size: 1.3rem; }
    .custom-input { background-color: #f8fafd; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.8rem 1.2rem; color: #2d3748; font-size: 0.95rem; transition: all 0.3s ease; }
    .custom-input:focus { background-color: #fff; border-color: #0dcaf0; box-shadow: 0 0 0 4px rgba(13, 202, 240, 0.15); }
    .custom-submit-btn { background: linear-gradient(135deg, #0d5c75 0%, #1585a9 100%); color: #fff; border: none; border-radius: 50px; padding: 15px 45px; font-weight: 700; letter-spacing: 0.5px; box-shadow: 0 10px 25px rgba(13, 92, 117, 0.25); transition: all 0.3s ease; text-transform: uppercase; }
    .custom-submit-btn:hover:not(:disabled) { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(13, 92, 117, 0.35); color: #fff; }
    @media (min-width: 768px) { .border-end-md { border-right: 1px dashed #dee2e6 !important; } }
    .bg-light-footer { background-color: #f8fafd !important; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('labTestForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận đăng ký xét nghiệm?',
            html: 'Bạn có chắc chắn muốn đăng ký xét nghiệm này?<br><small class="text-muted">Vui lòng kiểm tra kỹ thông tin trước khi xác nhận.</small>',
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
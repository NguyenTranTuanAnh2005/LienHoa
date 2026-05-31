<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    /* Custom CSS nâng cao độ thẩm mỹ cho giao diện Profile */
    .profile-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(13, 110, 253, 0.05); border: none; }
    .profile-header-bg { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border-radius: 20px 20px 0 0; }
    .avatar-wrapper { width: 100px; height: 100px; border-radius: 50%; background: #ffffff; padding: 5px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .vital-card { border-radius: 16px; border: none; transition: transform 0.3s ease; }
    .vital-card:hover { transform: translateY(-5px); }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; border-left: 4px solid #0d6efd; padding-left: 12px; }
    .info-label { font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 2px; }
    .info-value { font-size: 1rem; color: #0f172a; font-weight: 600; }
    .badge-medical { padding: 6px 16px; border-radius: 50px; font-weight: 600; font-size: 0.85rem; }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<main class="flex-grow-1 bg-light py-5">
    <div class="container">
        <div class="text-center mb-5 animate-fade-in-up">
            <h1 class="text-primary fw-bolder" data-lang="record_main_title">Hồ Sơ Sức Khỏe Điện Tử</h1>
            <p class="text-muted" data-lang="record_main_desc">Nhập Mã y tế (PID) để tra cứu hồ sơ khám chữa bệnh bảo mật.</p>
        </div>

        <div class="row justify-content-center">
            <div class="<?= empty($searched) ? 'col-lg-7' : 'col-lg-9' ?>">
                <div id="alert-container"></div>

                <?php if (empty($searched)): ?>
                    <div class="card shadow-sm border-0 rounded-4 mb-4 animate-fade-in-up">
                        <div class="card-body p-4 p-md-5">
                            
                            <div id="step-input-code">
                                <label class="form-label fw-bold text-secondary mb-2" data-lang="patient_id_label">Mã định danh y tế bệnh nhân</label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text bg-white border-end-0 text-primary">
                                        <i class="bi bi-person-vcard text-primary"></i>
                                    </span>
                                    <input type="text" id="patient_code" name="code" class="form-control border-start-0 ps-0" 
                                           placeholder="Ví dụ: BN2026001" 
                                           value="<?= htmlspecialchars($code ?? '') ?>" required>
                                    <button type="button" onclick="handleSendOTP()" class="btn btn-primary px-4 fw-bold shadow-sm">
                                        TRA CỨU
                                    </button>
                                </div>
                            </div>
                            
                            <div
                                id="step-input-otp"
                                style="display:none;"
                                class="mt-3 border-top pt-3"
                            >

                                <div class="alert alert-info py-2 small text-center">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Mã xác thực đã được gửi. Vui lòng kiểm tra!
                                </div>

                                <label class="form-label fw-bold text-center d-block mb-3">
                                    Nhập mã gồm 6 chữ số
                                </label>

                                <div class="d-flex justify-content-between gap-2 mb-4">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px;">
                                </div>
                                <input type="hidden" id="otp_value" value="">

                                <button
                                    type="button"
                                    onclick="handleVerifyOTP()"
                                    class="btn btn-success w-100 py-3 fw-bold rounded-3 shadow-sm mb-3"
                                >
                                    XÁC NHẬN
                                </button>

                                <div class="text-center">
                                    <span id="otp-timer" class="text-muted small">Gửi lại mã sau 60s</span>
                                    <button type="button" id="btn-resend-otp" onclick="handleSendOTP()" class="btn btn-link btn-sm text-decoration-none p-0 d-none fw-bold">Gửi lại mã OTP</button>
                                </div>
                                <div class="text-center mt-3 border-top pt-2">
                                    <button
                                        type="button"
                                        onclick="handleCancelOTP()"
                                        class="btn btn-link btn-sm text-decoration-none text-danger"
                                    >
                                        <i class="bi bi-x-circle me-1"></i> Hủy bỏ
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($searched) && $searched): ?>
                    <?php if (empty($data)): ?>
                        <div class="alert alert-warning border-0 shadow-sm rounded-4 text-center py-5 animate-fade-in-up">
                            <i class="bi bi-shield-exclamation fs-1 text-warning mb-3 d-block"></i>
                            <h4 class="alert-heading fw-bold">Không tìm thấy Hồ sơ!</h4>
                            <p class="mb-3 text-muted">Bệnh nhân mang mã số <strong><?= htmlspecialchars($code ?? '') ?></strong> không tồn tại dữ liệu lâm sàng trên hệ thống.</p>
                            <a href="<?= BASE_URL ?>/<?= basename(dirname(__FILE__)) ?>" class="btn btn-primary px-4 fw-bold rounded-pill">Quay lại</a>
                        </div>
                    <?php else: ?>
                        
                        <div class="card profile-card animate-fade-in-up overflow-hidden mb-4">
                            <div class="profile-header-bg p-4 p-md-5 text-white position-relative">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                                    <div class="avatar-wrapper d-flex align-items-center justify-content-center">
                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center w-100 height-100" style="height: 100%;">
                                            <i class="bi bi-person-fill fs-1"></i>
                                        </div>
                                    </div>
                                    <div class="text-center text-md-start flex-grow-1">
                                        <div class="d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-2 mb-2">
                                            <h3 class="mb-0 fw-bold"><?= htmlspecialchars($data['ho_ten'] ?? 'Nguyễn Văn A') ?></h3>
                                            <span class="badge bg-white text-primary rounded-pill fw-bold text-uppercase px-3 small shadow-sm">Bệnh Nhân</span>
                                        </div>
                                        <p class="mb-2 opacity-90 fw-medium">
                                            <i class="bi bi-fingerprint me-1"></i> Mã số y tế: <span class="fw-bold text-warning"><?= htmlspecialchars($data['ma_benh_nhan'] ?? 'BN2026001') ?></span>
                                        </p>
                                        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 opacity-75 small">
                                            <span><i class="bi bi-calendar3 me-1"></i> Ngày tạo: <?= date('d/m/Y', strtotime($data['ngay_tao'] ?? 'now')) ?></span>
                                            <span><i class="bi bi-clock-history me-1"></i> Đồng bộ mới nhất: Vừa xong</span>
                                        </div>
                                    </div>
                                    <div class="text-center text-md-end">
                                        <button class="btn btn-light text-primary fw-bold rounded-pill shadow-sm px-4" onclick="window.print()">
                                            <i class="bi bi-printer-fill me-2"></i> Xuất PDF / In
                                        </button>
                                    </div>
                                </div>
                            </div>

<div class="p-4 bg-light border-bottom">
    <div class="row g-3">
        <!-- Nhóm Máu -->
        <div class="col-6 col-md-3 col-lg">
            <div class="card vital-card p-3 bg-white shadow-sm border-start border-primary border-4">
                <div class="text-muted small fw-bold mb-1"><i class="bi bi-droplet-fill text-danger"></i> NHÓM MÁU</div>
                <div class="fs-4 fw-bolder text-dark"><?= htmlspecialchars($data['nhom_mau'] ?? 'O+') ?></div>
            </div>
        </div>
        <!-- Huyết Áp -->
        <div class="col-6 col-md-3 col-lg">
            <div class="card vital-card p-3 bg-white shadow-sm border-start border-danger border-4">
                <div class="text-muted small fw-bold mb-1"><i class="bi bi-heart-pulse-fill text-danger"></i> HUYẾT ÁP</div>
                <div class="fs-4 fw-bolder text-dark">120/80 <span class="fs-6 text-muted fw-normal">mmHg</span></div>
            </div>
        </div>
        <!-- Nhịp Tim -->
        <div class="col-6 col-md-3 col-lg">
            <div class="card vital-card p-3 bg-white shadow-sm border-start border-success border-4">
                <div class="text-muted small fw-bold mb-1"><i class="bi bi-speedometer2 text-success"></i> NHỊP TIM</div>
                <div class="fs-4 fw-bolder text-dark">78 <span class="fs-6 text-muted fw-normal">bpm</span></div>
            </div>
        </div>
<!-- Kết Quả Nội Soi -->
<div class="col-6 col-md-3 col-lg">
    <div class="card vital-card p-3 bg-white shadow-sm border-start border-warning border-4">
        <div class="text-muted small fw-bold mb-1">
            <i class="bi bi-camera-reels-fill text-warning"></i> KẾT QUẢ SIÊU ÂM
        </div>
        <div class="fs-6 fw-bold text-danger text-truncate mt-1" title="Viêm loét dạ dày tá tràng">
            <?= htmlspecialchars($data['ket_qua_noi_soi'] ?? 'Bình thường') ?>
        </div>
    </div>
</div>
        <!-- Kết Quả Xét Nghiệm (Mới) -->
        <div class="col-6 col-md-3 col-lg">
            <div class="card vital-card p-3 bg-white shadow-sm border-start border-info border-4">
                <div class="text-muted small fw-bold mb-1"><i class="bi bi-file-earmark-medical-fill text-info"></i> XÉT NGHIỆM</div>
                <div class="fs-6 fw-bold text-dark text-truncate mt-1">
                    <?= htmlspecialchars($data['ket_qua_xn'] ?? 'Không có') ?>
                </div>
            </div>
        </div>
    </div>
</div>

                            <div class="card-body p-4 p-md-5">
                                <div class="row g-4">
                                    <div class="col-md-7 border-md-end pe-md-4">
                                        <div class="mb-4">
                                            <h5 class="section-title mb-3">Chẩn Đoán Lâm Sàng</h5>
                                            <div class="bg-primary-subtle text-primary p-3 rounded-3 fw-bold fs-6">
                                                <i class="bi bi-activity me-2"></i><?= nl2br(htmlspecialchars($data['chan_doan'] ?? 'Chưa ghi nhận dữ liệu chẩn đoán')) ?>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h5 class="section-title mb-3">Nội Dung Sức Khỏe Chi Tiết</h5>
                                            <div class="p-3 bg-light rounded-3 text-secondary lh-lg" style="text-align: justify;">
                                                <?= nl2br(htmlspecialchars($data['noi_dung_suc_khoe'] ?? 'Chưa có thông tin sức khỏe bổ sung.')) ?>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <h5 class="section-title mb-3">Chỉ Định & Ghi Chú Của Bác Sĩ</h5>
                                            <div class="p-3 rounded-3 bg-warning-subtle text-warning-emphasis fst-italic border-start border-warning border-3">
                                                <i class="bi bi-pencil-square me-2"></i><?= htmlspecialchars($data['ghi_chu'] ?? 'Không có ghi chú chỉ định đặc biệt nào từ hội đồng y khoa.') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5 ps-md-4">
                                        <h5 class="section-title mb-3">Thông Tin Hành Chính</h5>
                                        
                                        <div class="mb-3 bg-light p-2.5 rounded-3 px-3 d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="info-label">Bảo hiểm y tế (BHYT)</div>
                                                <div class="info-value">GD4797921XXXXXX</div>
                                            </div>
                                            <span class="badge bg-success-subtle text-success badge-medical">Hiệu lực</span>
                                        </div>

                                        <div class="mb-3 bg-light p-2.5 rounded-3 px-3">
                                            <div class="info-label">Tiền sử bệnh án gia đình</div>
                                            <div class="info-value text-muted small fw-normal"><?= htmlspecialchars($data['tien_su'] ?? 'Không ghi nhận tiền sử bệnh nền mạn tính nguy hiểm.') ?></div>
                                        </div>

                                        <div class="mb-4 bg-light p-2.5 rounded-3 px-3">
                                            <div class="info-label">Cơ sở khám chữa bệnh ĐKKCB</div>
                                            <div class="info-value text-primary fs-6">Bệnh Viện Liên Hoa</div>
                                        </div>

                                        <div class="text-center pt-3">
                                            <a href="<?= BASE_URL ?>/<?= basename(dirname(__FILE__)) ?>" class="btn btn-outline-secondary btn-sm w-100 py-2 rounded-pill fw-bold">
                                                <i class="bi bi-arrow-left-circle me-1"></i> Tra cứu hồ sơ y khoa khác
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>

<script>
function showAlert(message, type = 'danger') {
    const alertContainer = document.getElementById('alert-container');
    if (alertContainer) {
        alertContainer.innerHTML = `
            <div class="alert alert-${type} shadow-sm border-0 mb-4 animate-fade-in-up">
                ${message}
            </div>
        `;
    }
}

let otpTimerInterval;

function startOtpTimer(duration) {
    let timer = duration;
    const timerDisplay = document.getElementById('otp-timer');
    const resendBtn = document.getElementById('btn-resend-otp');
    
    if (!timerDisplay || !resendBtn) return;
    
    timerDisplay.classList.remove('d-none');
    resendBtn.classList.add('d-none');
    
    clearInterval(otpTimerInterval);
    otpTimerInterval = setInterval(function () {
        timerDisplay.textContent = `Gửi lại mã sau ${timer}s`;
        if (--timer < 0) {
            clearInterval(otpTimerInterval);
            timerDisplay.classList.add('d-none');
            resendBtn.classList.remove('d-none');
        }
    }, 1000);
}

const MODULE_URL = '<?= BASE_URL ?>/<?= basename(dirname(__FILE__)) ?>';

document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const otpHidden = document.getElementById('otp_value');

    if (otpInputs.length > 0) {
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value !== '') {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                }
                updateHiddenOtp();
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '') {
                    if (index > 0) {
                        otpInputs[index - 1].focus();
                    }
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                for (let i = 0; i < pasteData.length; i++) {
                    if (i < otpInputs.length) {
                        otpInputs[i].value = pasteData[i];
                    }
                }
                if (pasteData.length > 0) {
                    const focusIndex = Math.min(pasteData.length, otpInputs.length - 1);
                    otpInputs[focusIndex].focus();
                }
                updateHiddenOtp();
            });
        });

        function updateHiddenOtp() {
            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value;
            });
            if (otpHidden) otpHidden.value = otp;
        }
    }

    // Kiểm tra và phục hồi trạng thái OTP khi quay lại tab từ sessionStorage
    const isOtpRequested = sessionStorage.getItem('record_otp_requested');
    const savedPatientCode = sessionStorage.getItem('record_patient_code');
    const stepOtpDiv = document.getElementById('step-input-otp');
    const patientCodeInput = document.getElementById('patient_code');

    if (isOtpRequested === 'true' && stepOtpDiv && patientCodeInput) {
        if (savedPatientCode) {
            patientCodeInput.value = savedPatientCode;
        }
        stepOtpDiv.style.display = 'block';
        
        setTimeout(() => {
            const firstOtpInput = document.querySelector('.otp-input');
            if (firstOtpInput) firstOtpInput.focus();
        }, 100);

        startOtpTimer(30); 
    }
});

function handleCancelOTP() {
    sessionStorage.removeItem('record_otp_requested');
    sessionStorage.removeItem('record_patient_code');
    location.reload();
}

function handleSendOTP() {
    const code = document.getElementById('patient_code').value.trim();

    if (!code) {
        showAlert('Vui lòng nhập mã để tra cứu.');
        return;
    }

    fetch(MODULE_URL + '/sendotp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'code=' + encodeURIComponent(code)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(
                data.message +
                (data.otp_debug ? ' (OTP test: ' + data.otp_debug + ')' : ''),
                'success'
            );
            
            sessionStorage.setItem('record_otp_requested', 'true');
            sessionStorage.setItem('record_patient_code', code);

            const userBtn = document.querySelector('.dropdown-toggle');
            if (userBtn && !document.getElementById('user-notification-dot')) {
                userBtn.insertAdjacentHTML('beforeend', '<span id="user-notification-dot" class="position-absolute bg-danger border border-white rounded-circle" style="width: 12px; height: 12px; top: -1px; right: 2px; border-width: 2px !important; z-index: 10;"></span>');
            }

            document.getElementById('step-input-otp').style.display = 'block';
            startOtpTimer(60);

            setTimeout(() => {
                const firstOtpInput = document.querySelector('.otp-input');
                if (firstOtpInput) firstOtpInput.focus();
            }, 100);
        } else {
            showAlert(data.message);
        }
    })
    .catch(() => {
        showAlert('Có lỗi xảy ra khi gửi OTP.');
    });
}

function handleVerifyOTP() {
    const code = document.getElementById('patient_code').value.trim();
    const otp = document.getElementById('otp_value').value.trim();

    if (!otp || otp.length < 6) {
        showAlert('Vui lòng nhập đủ 6 số OTP.');
        return;
    }

    fetch(MODULE_URL + '/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'code=' + encodeURIComponent(code) + '&otp=' + encodeURIComponent(otp)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            sessionStorage.removeItem('record_otp_requested');
            sessionStorage.removeItem('record_patient_code');
            window.location.href = MODULE_URL + '?code=' + encodeURIComponent(code);
        } else {
            showAlert(data.message);
        }
    })
    .catch(() => {
        showAlert('Lỗi xác thực OTP.');
    });
}
</script>
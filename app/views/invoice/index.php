<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<main class="flex-grow-1 bg-light py-5">
    <div class="container">
        <div class="text-center mb-5 animate-fade-in-up">
            <h1 class="text-primary fw-bolder">Tra Cứu Hóa Đơn Điện Tử</h1>
            <p class="text-muted">Nhập Mã bệnh nhân để tải file PDF hóa đơn VAT.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">
                
                <?php if (empty($searched)): ?>
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5">
                            <div id="alert-container"></div>
                            
                            <div id="step-input-code">
                                <label class="form-label fw-bold text-secondary mb-2">Mã định danh y tế bệnh nhân</label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text bg-white border-end-0 text-primary">
                                        <i class="bi bi-file-earmark-text text-primary"></i>
                                    </span>
                                    <input type="text" id="patient_code" name="code" class="form-control border-start-0 ps-0" 
                                           placeholder="Ví dụ: BN2026001" 
                                           value="<?= htmlspecialchars($code ?? '') ?>" required>
                                    <button type="button" onclick="handleSendOTP()" class="btn btn-primary px-4 fw-bold shadow-sm">
                                        TRA CỨU
                                    </button>
                                </div>
                            </div>
                            
                            <div id="step-input-otp" style="display:none;" class="mt-4 border-top pt-4">
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
                        <div class="alert alert-warning border-0 shadow-sm rounded-4 text-center py-5">
                            <i class="bi bi-shield-exclamation fs-1 text-warning mb-3 d-block"></i>
                            <h4 class="alert-heading fw-bold">Không tìm thấy mã Hóa Đơn!</h4>
                            <p class="mb-0">Hóa đơn mang mã <strong><?= htmlspecialchars($code ?? '') ?></strong> không tồn tại.</p>
                            <div class="text-center mt-4">
                                <a href="<?= BASE_URL ?>/invoice" class="btn btn-primary rounded-pill px-4 fw-bold">Quay lại Tra cứu</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success border-0 shadow rounded-4 p-4 text-center animate-fade-in-up">
                            <i class="bi bi-check-circle-fill fs-1 text-success mb-3 d-block"></i>
                            <h4 class="alert-heading fw-bold">Tìm thấy Hóa Đơn Hợp Lệ!</h4>
                            
                            <p class="mb-2">
                                Ký hiệu: <strong><?= htmlspecialchars($data['ky_hieu'] ?? 'LH-2026') ?></strong> - 
                                Số HĐ: <strong><?= htmlspecialchars($data['so_hoa_don'] ?? $data['id'] ?? '000000') ?></strong>
                            </p>
                            
                            <p class="mb-3 text-secondary">
                                Ngày lập: <?= date('d/m/Y - H:i', strtotime($data['ngay_lap'] ?? $data['created_at'] ?? 'now')) ?> | 
                                Tổng tiền: <?= number_format($data['tong_tien'] ?? 0, 0, ',', '.') ?> VND
                            </p>

                            <hr class="mx-auto" style="width: 50%;">
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="<?= BASE_URL ?>/invoice/view?code=<?= urlencode($data['ma_benh_nhan'] ?? $code) ?>" target="_blank" class="btn btn-outline-success fw-bold rounded-pill px-4">
                                    <i class="bi bi-eye me-2"></i> Xem trực tuyến
                                </a>
                                <a href="<?= BASE_URL ?>/invoice/view?code=<?= urlencode($data['ma_benh_nhan'] ?? $code) ?>&action=download" target="_blank" class="btn btn-success fw-bold rounded-pill px-4 shadow-sm">
                                    <i class="bi bi-download me-2"></i> Tải bản thể hiện (PDF)
                                </a>
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

    const isOtpRequested = sessionStorage.getItem('invoice_otp_requested');
    const savedCode = sessionStorage.getItem('invoice_patient_code');
    const stepOtpDiv = document.getElementById('step-input-otp');
    const patientInput = document.getElementById('patient_code');

    if (isOtpRequested === 'true' && stepOtpDiv && patientInput) {
        if (savedCode) patientInput.value = savedCode;
        stepOtpDiv.style.display = 'block';
        startOtpTimer(45);
    }
});

function handleCancelOTP() {
    sessionStorage.removeItem('invoice_otp_requested');
    sessionStorage.removeItem('invoice_patient_code');
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
            
            sessionStorage.setItem('invoice_otp_requested', 'true');
            sessionStorage.setItem('invoice_patient_code', code);

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
            sessionStorage.removeItem('invoice_otp_requested');
            sessionStorage.removeItem('invoice_patient_code');
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
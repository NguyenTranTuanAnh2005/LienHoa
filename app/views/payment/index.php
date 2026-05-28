<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<main class="flex-grow-1 bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="text-primary fw-bolder">
                Thanh Toán Viện Phí
            </h1>
            <p class="text-muted">
                Nhập Mã bệnh nhân để tra cứu và thanh toán.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div id="alert-container">
                    <?php if (!empty($successMsg)): ?>
                        <div class="alert alert-success shadow-sm border-0 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= htmlspecialchars($successMsg) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (empty($searched)): ?>

                    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4">

                        <div id="step-input-code">

                            <label class="form-label fw-bold">
                                Mã định danh y tế bệnh nhân
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-person-badge text-primary"></i>
                                </span>

                                <input
                                    type="text"
                                    id="patient_code"
                                    class="form-control border-start-0 ps-0"
                                    placeholder="Ví dụ: BN2026001"
                                    required
                                >

                                <button
                                    type="button"
                                    onclick="handleSendOTP()"
                                    class="btn btn-primary px-4 fw-bold"
                                >
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

                <?php endif; ?>

                <?php if (!empty($searched)): ?>

                    <?php if (empty($data)): ?>

                        <div class="alert alert-warning text-center shadow-sm border-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>

                            Không tìm thấy mã
                            <b><?= htmlspecialchars($code ?? '') ?></b>

                            <div class="mt-2">
                                <a
                                    href="<?= BASE_URL ?>/payment"
                                    class="small text-decoration-none"
                                >
                                    Thử lại
                                </a>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="card shadow border-0 rounded-4 overflow-hidden">

                            <div class="card-header bg-white border-0 pt-4 text-center">
                                <h4 class="mb-0 fw-bold">
                                    <span class="text-dark">
                                        Thông tin viện phí
                                    </span>
                                </h4>
                            </div>

                            <div class="card-body p-4">

                                <?php if (($data['trang_thai'] ?? '') === 'Đã thanh toán'): ?>
                                    <div class="alert alert-success text-center mb-4">
                                        <h5 class="fw-bold mb-0"><i class="bi bi-check-circle-fill me-2"></i> Bệnh nhân đã thanh toán viện phí</h5>
                                    </div>
                                    <div class="invoice-details bg-light rounded-4 p-4 mb-4 border">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-muted fs-5">TỔNG CỘNG:</span>
                                            <span class="text-success fs-3 fw-bolder">0 VNĐ</span>
                                        </div>
                                    </div>
                                <?php elseif (!empty($invoiceData)): ?>
                                <div class="invoice-details bg-light rounded-4 p-4 mb-4 border">
                                    <div class="text-center mb-4 border-bottom pb-3">
                                        <h5 class="fw-bold text-primary mb-1">CHI TIẾT HÓA ĐƠN VIỆN PHÍ</h5>
                                        <p class="text-muted small mb-0">Mã HĐ: <?= htmlspecialchars($invoiceData['patient_info']['ma_hoa_don']) ?> - Ngày lập: <?= htmlspecialchars($invoiceData['patient_info']['ngay_lap']) ?></p>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-sm-6 mb-2 mb-sm-0">
                                            <span class="text-muted small d-block">Tên bệnh nhân:</span>
                                            <span class="fw-bold fs-6"><?= htmlspecialchars($invoiceData['patient_info']['ten_benh_nhan']) ?></span>
                                        </div>
                                        <div class="col-sm-6 text-sm-end">
                                            <span class="text-muted small d-block">Mã bệnh nhân:</span>
                                            <span class="fw-bold fs-6"><?= htmlspecialchars($invoiceData['patient_info']['ma_benh_nhan']) ?></span>
                                        </div>
                                    </div>

                                    <div class="table-responsive mb-4">
                                        <table class="table table-borderless table-sm mb-0">
                                            <thead class="border-bottom border-2 text-muted small">
                                                <tr>
                                                    <th class="ps-0 py-2">Dịch vụ đã đăng ký</th>
                                                    <th class="text-center py-2">SL</th>
                                                    <th class="text-end pe-0 py-2">Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody class="border-bottom">
                                                <?php foreach ($invoiceData['services'] as $svc): ?>
                                                <tr>
                                                    <td class="ps-0 py-3 fw-semibold text-dark"><?= htmlspecialchars($svc['ten_dich_vu']) ?></td>
                                                    <td class="text-center py-3"><?= $svc['so_luong'] ?></td>
                                                    <td class="text-end pe-0 py-3 fw-semibold"><?= number_format($svc['thanh_tien'], 0, ',', '.') ?> đ</td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="fw-bold text-muted fs-5">TỔNG CỘNG:</span>
                                        <span class="text-danger fs-3 fw-bolder"><?= number_format($invoiceData['tong_tien'], 0, ',', '.') ?> VNĐ</span>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <style>
                                    .payment-card {
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                        background-color: #fff;
                                        height: 100%;
                                        border: 2px solid #dee2e6 !important;
                                    }
                                    .payment-card:hover {
                                        border-color: var(--bs-primary) !important;
                                        transform: translateY(-3px);
                                        box-shadow: 0 6px 15px rgba(13, 92, 117, 0.1);
                                    }
                                    .payment-card:hover i {
                                        color: var(--bs-primary) !important;
                                    }
                                    .payment-card.active {
                                        border-color: var(--bs-primary) !important;
                                        background-color: rgba(13, 92, 117, 0.05);
                                    }
                                    .payment-card.active i {
                                        color: var(--bs-primary) !important;
                                    }
                                </style>

                                <?php if (($data['trang_thai'] ?? '') !== 'Đã thanh toán'): ?>
                                <div class="payment-methods-section mt-4 border-top pt-4">
                                    <h5 class="fw-bold text-center mb-4 text-dark">Chọn hình thức thanh toán</h5>
                                    <form action="<?= BASE_URL ?>/payment/process" method="GET">
                                        <input type="hidden" name="code" value="<?= htmlspecialchars($code ?? '') ?>">
                                        
                                        <div class="row g-3 mb-4">
                                            <div class="col-6">
                                                <div class="payment-card rounded-4 p-3 text-center d-flex flex-column justify-content-center align-items-center" onclick="selectPaymentMethod('ewallet')">
                                                    <input type="radio" name="payment_method" value="ewallet" class="d-none" id="method-ewallet" required>
                                                    <i class="bi bi-wallet2 fs-1 mb-2 text-secondary transition-colors"></i>
                                                    <span class="fw-bold small">Ví điện tử<br>(Momo, ZaloPay)</span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-6">
                                                <div class="payment-card rounded-4 p-3 text-center d-flex flex-column justify-content-center align-items-center" onclick="selectPaymentMethod('counter')">
                                                    <input type="radio" name="payment_method" value="counter" class="d-none" id="method-counter">
                                                    <i class="bi bi-hospital fs-1 mb-2 text-secondary transition-colors"></i>
                                                    <span class="fw-bold small">Thanh toán tại<br>quầy bệnh viện</span>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" id="btn-confirm-payment" class="btn btn-primary w-100 py-3 fw-bold shadow-sm rounded-pill" disabled>
                                            <i class="bi bi-check-circle-fill me-2"></i> XÁC NHẬN PHƯƠNG THỨC
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>

                            <div class="text-center mt-4">
                                <a
                                    href="<?= BASE_URL ?>/payment"
                                    class="text-muted small text-decoration-none"
                                >
                                    <i class="bi bi-arrow-left"></i>
                                    Quay lại tra cứu
                                </a>
                            </div>

                        </div>
                    </div>

                <?php endif; ?>

            <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<script>
function showAlert(message, type = 'danger') {
    document.getElementById('alert-container').innerHTML = `
        <div class="alert alert-${type} shadow-sm border-0 mb-4">
            ${message}
        </div>
    `;
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

// Hàm Xử lý hủy bỏ trạng thái OTP
function handleCancelOTP() {
    sessionStorage.removeItem('otp_requested');
    sessionStorage.removeItem('saved_patient_code');
    location.reload();
}

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

    // [BỔ SUNG LOGIC] Kiểm tra và khôi phục trạng thái OTP khi tải lại trang
    const isOtpRequested = sessionStorage.getItem('otp_requested');
    const savedCode = sessionStorage.getItem('saved_patient_code');
    const stepOtpDiv = document.getElementById('step-input-otp');
    const patientInput = document.getElementById('patient_code');

    if (isOtpRequested === 'true' && stepOtpDiv && patientInput) {
        if (savedCode) patientInput.value = savedCode;
        stepOtpDiv.style.display = 'block';
        // Bật nút gửi lại hoặc chạy bộ đếm thời gian ngắn 30s để tránh spam
        startOtpTimer(30); 
    }
});

/**
 * Gửi OTP
 */
function handleSendOTP() {
    const code = document.getElementById('patient_code').value.trim();

    if (!code) {
        showAlert('Vui lòng nhập mã bệnh nhân.');
        return;
    }

    fetch('<?= BASE_URL ?>/payment/sendotp', {
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
                data.message + (data.otp_debug ? ' (OTP test: ' + data.otp_debug + ')' : ''),
                'success'
            );

            // [BỔ SUNG] Lưu trạng thái gửi thành công vào sessionStorage
            sessionStorage.setItem('otp_requested', 'true');
            sessionStorage.setItem('saved_patient_code', code);

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

/**
 * Xác thực OTP
 */
function handleVerifyOTP() {
    const code = document.getElementById('patient_code').value.trim();
    const otp = document.getElementById('otp_value').value.trim();

    if (!otp) {
        showAlert('Vui lòng nhập mã OTP.');
        return;
    }

    fetch('<?= BASE_URL ?>/payment/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'code=' + encodeURIComponent(code) + '&otp=' + encodeURIComponent(otp)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // [BỔ SUNG] Xác thực thành công -> Xóa sạch session lưu trữ tạm
            sessionStorage.removeItem('otp_requested');
            sessionStorage.removeItem('saved_patient_code');

            window.location.href = '<?= BASE_URL ?>/payment?code=' + encodeURIComponent(code);
        } else {
            showAlert(data.message);
        }
    })
    .catch(() => {
        showAlert('Lỗi xác thực OTP.');
    });
}

/**
 * Chọn hình thức thanh toán
 */
function selectPaymentMethod(methodId) {
    const cards = document.querySelectorAll('.payment-card');
    cards.forEach(card => card.classList.remove('active'));

    const inputRadio = document.getElementById('method-' + methodId);
    if (inputRadio) {
        inputRadio.checked = true;
        const selectedCard = inputRadio.closest('.payment-card');
        if (selectedCard) {
            selectedCard.classList.add('active');
        }
    }

    const btnConfirm = document.getElementById('btn-confirm-payment');
    if (btnConfirm) {
        btnConfirm.disabled = false;
    }
}
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
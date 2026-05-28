<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<style>
    @media print {
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        #printable-area { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 20px; }
        .card { box-shadow: none !important; border: none !important; background: transparent !important; }
        .badge { border: 1px solid #000; color: #000 !important; }
        .btn, .d-flex.justify-content-end { display: none !important; }
    }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1) !important; }
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .medical-record-card {
        background: #ffffff;
        background-image: radial-gradient(#f0f4f8 1px, transparent 1px);
        background-size: 20px 20px;
    }
</style>

<main class="flex-grow-1 bg-light py-5">
    <div class="container">
        <div class="text-center mb-5 animate-fade-in-up">
            <h1 class="text-primary fw-bolder">Kết Quả Cận Lâm Sàng</h1>
            <p class="text-muted">Nhập Mã Phiếu Chỉ Định để xem Tờ kết quả Xét nghiệm, Siêu âm, X-Quang.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <?php if (empty($searched)): ?>
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div id="alert-container"></div>
                            <div id="step-input-code">
                                <!-- THÊM MỚI: Tiêu đề cho ô nhập mã tra cứu -->
                                <label class="form-label fw-bold text-secondary mb-2">Mã định danh y tế bệnh nhân</label>
                                
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text bg-white border-end-0 text-primary">
                                        <i class="bi bi-file-medical text-primary"></i>
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
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px; border-radius: 10px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px; border-radius: 10px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px; border-radius: 10px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px; border-radius: 10px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px; border-radius: 10px;">
                                    <input type="text" class="form-control text-center fw-bold fs-3 otp-input" maxlength="1" inputmode="numeric" style="width: 50px; height: 60px; border-radius: 10px;">
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
                            <h4 class="alert-heading fw-bold">Không tìm thấy mã phiếu!</h4>
                            <p class="mb-0">Phiếu kiểm tra mang mã số <strong><?= htmlspecialchars($code ?? '') ?></strong> không tồn tại trong hệ thống.</p>
                        </div>
                    <?php else: ?>
                        <div class="card shadow-lg border-0 rounded-4 animate-fade-in-up medical-record-card position-relative overflow-hidden">
                            <!-- Nút Hành Động -->
                            <div class="d-flex justify-content-end p-3 bg-white border-bottom shadow-sm z-1 position-relative">
                                <button class="btn btn-outline-secondary btn-sm me-2 fw-bold" onclick="window.print()">
                                    <i class="bi bi-printer me-1"></i> In Kết Quả
                                </button>
                                <button class="btn btn-primary btn-sm fw-bold shadow-sm">
                                    <i class="bi bi-file-earmark-arrow-down me-1"></i> Lưu PDF
                                </button>
                            </div>

                            <div class="card-body p-4 p-md-5" id="printable-area">
                                <!-- Watermark -->
                                <div class="position-absolute top-50 start-50 translate-middle opacity-25" style="z-index: 0; pointer-events: none;">
                                    <i class="bi bi-hospital" style="font-size: 20rem; color: #e9ecef;"></i>
                                </div>

                                <div class="position-relative" style="z-index: 1;">
                                    <!-- Header Phiếu -->
                                    <div class="row border-bottom border-2 border-primary pb-4 mb-4 align-items-center">
                                        <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                                            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 60px; height: 60px;">
                                                <i class="bi bi-hospital fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <h4 class="text-primary fw-bolder mb-1">BỆNH VIỆN ĐA KHOA LIÊN HOA</h4>
                                            <p class="mb-0 small text-muted">123 Đường Y Tế, Phường Bệnh Viện, Quận 1, TP.HCM<br>Hotline: 1900 8888 - Email: cskh@smarthospital.vn</p>
                                        </div>
                                        <div class="col-md-3 text-center text-md-end mt-3 mt-md-0">
                                            <div class="border p-2 d-inline-block bg-white rounded shadow-sm">
                                                <img src="https://barcode.tec-it.com/barcode.ashx?data=<?= htmlspecialchars($data['ma_benh_nhan'] ?? $code) ?>&code=Code128&translate-esc=on" alt="Barcode" style="height: 35px;">
                                                <div class="small fw-bold mt-1 text-dark" style="letter-spacing: 1px;"><?= htmlspecialchars($data['ma_benh_nhan'] ?? $code) ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mb-5">
                                        <h3 class="fw-bolder" style="color: #0d47a1; text-shadow: 1px 1px 0px rgba(0,0,0,0.1);">PHIẾU KẾT QUẢ CẬN LÂM SÀNG</h3>
                                        <div class="mt-2">
                                            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fs-6 border border-primary shadow-sm"><?= htmlspecialchars($data['loai_xet_nghiem'] ?? 'Khám Cận Lâm Sàng') ?></span>
                                        </div>
                                    </div>

                                    <!-- Thông Tin Bệnh Nhân -->
                                    <div class="bg-white p-4 rounded-3 shadow-sm border border-light mb-4">
                                        <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 d-flex align-items-center">
                                            <i class="bi bi-person-vcard fs-5 me-2"></i> THÔNG TIN HÀNH CHÍNH
                                        </h6>
                                        <div class="row g-3 text-dark">
                                            <div class="col-md-6">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted fw-semibold" style="width: 150px;">Họ và tên:</span>
                                                    <span class="fw-bolder text-uppercase text-primary"><?= htmlspecialchars($data['ten_benh_nhan'] ?? 'Khách hàng') ?></span>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted fw-semibold" style="width: 150px;">Mã bệnh nhân (PID):</span>
                                                    <span class="fw-bold"><?= htmlspecialchars($data['ma_benh_nhan'] ?? $code) ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted fw-semibold" style="width: 150px;">Ngày thực hiện:</span>
                                                    <span class="fw-bold"><?= date('d/m/Y H:i', strtotime($data['ngay_tao'] ?? 'now')) ?></span>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted fw-semibold" style="width: 150px;">Bác sĩ chỉ định:</span>
                                                    <span class="fw-bold">BS. Nguyễn Văn Trưởng</span>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="d-flex p-3 bg-light rounded border">
                                                    <span class="text-muted fw-semibold me-2">Nội dung chỉ định:</span>
                                                    <span class="fw-bold text-dark"><?= htmlspecialchars($data['noi_dung_can_lam_sang'] ?? 'Không có ghi chú cụ thể.') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chi Tiết Kết Quả -->
                                    <h6 class="fw-bold text-primary mb-3 d-flex align-items-center">
                                        <i class="bi bi-heart-pulse fs-5 me-2"></i> CHI TIẾT DỊCH VỤ
                                    </h6>
                                    <div class="table-responsive bg-white rounded-3 shadow-sm border mb-4">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light text-primary">
                                                <tr>
                                                    <th class="ps-4 py-3 border-bottom-0" style="width: 5%">STT</th>
                                                    <th class="py-3 border-bottom-0" style="width: 45%">Tên Dịch Vụ / Chỉ Số</th>
                                                    <th class="py-3 text-center border-bottom-0" style="width: 25%">Trạng Thái</th>
                                                    <th class="pe-4 py-3 text-end border-bottom-0" style="width: 25%">Kết Quả</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $json_str = $data['ket_qua'] ?? '[]';
                                                    $ket_qua = json_decode($json_str, true);
                                                    
                                                    if(is_array($ket_qua) && !empty($ket_qua)): 
                                                        $stt = 1;
                                                        foreach($ket_qua as $item): 
                                                ?>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-muted"><?= $stt++ ?></td>
                                                        <td>
                                                            <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($item['ten_xet_nghiem'] ?? 'Dịch vụ chưa rõ') ?></div>
                                                            <div class="small text-muted"><i class="bi bi-tag me-1"></i>Chuẩn đoán hình ảnh & Xét nghiệm</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if(($item['trang_thai'] ?? '') === 'da_co_ket_qua'): ?>
                                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3 py-2 fw-bold shadow-sm placeholder-wave">
                                                                    <i class="bi bi-hourglass-split me-1"></i> Đang xử lý
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3 py-2 fw-bold shadow-sm placeholder-wave">
                                                                    <i class="bi bi-hourglass-split me-1"></i> Đang xử lý
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="pe-4 text-end">
                                                            <?php if(($item['trang_thai'] ?? '') === 'da_co_ket_qua'): ?>
                                                                <span class="text-muted small fst-italic">Vui lòng chờ...</span>
                                                            <?php else: ?>
                                                                <span class="text-muted small fst-italic">Vui lòng chờ...</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                        endforeach;
                                                    else:
                                                ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center py-5 text-muted">
                                                            <div class="fs-1 text-light mb-2"><i class="bi bi-folder-x"></i></div>
                                                            <i>Chưa có dữ liệu kết quả cụ thể cho phiếu này.</i>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Chữ Ký -->
                                    <div class="row mt-5 pt-3">
                                        <div class="col-6 text-center text-muted small px-4">
                                            <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                                            <p class="fst-italic">Lưu ý: Kết quả này chỉ mang tính chất hỗ trợ chẩn đoán lâm sàng. Vui lòng mang theo phiếu kết quả này khi tái khám để bác sĩ tư vấn phác đồ điều trị.</p>
                                        </div>
                                        <div class="col-6 text-center">
                                            <p class="mb-1 fw-semibold text-dark">Thành phố Hồ Chí Minh, Ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></p>
                                            <p class="fw-bold mb-0 text-primary">NGƯỜI LẬP PHIẾU</p>
                                            <p class="small text-muted mb-2">(Ký và ghi rõ họ tên)</p>
                                            
                                            <div class="my-3" style="height: 80px;">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Signature_of_John_Hancock.png" style="height: 100%; opacity: 0.8; filter: hue-rotate(220deg);" alt="Signature">
                                            </div>
                                            
                                            <p class="fw-bold text-uppercase fs-6">KTV. NGUYỄN THỊ MAI</p>
                                        </div>
                                    </div>
                                </div> <!-- end position-relative -->
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

    const isOtpRequested = sessionStorage.getItem('cls_otp_requested');
    const savedCode = sessionStorage.getItem('cls_saved_code');
    const stepOtpDiv = document.getElementById('step-input-otp');
    const patientInput = document.getElementById('patient_code');

    if (isOtpRequested === 'true' && stepOtpDiv && patientInput) {
        if (savedCode) patientInput.value = savedCode;
        stepOtpDiv.style.display = 'block';
        startOtpTimer(45);
    }
});

function handleCancelOTP() {
    sessionStorage.removeItem('cls_otp_requested');
    sessionStorage.removeItem('cls_saved_code');
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
            
            sessionStorage.setItem('cls_otp_requested', 'true');
            sessionStorage.setItem('cls_saved_code', code);

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
            sessionStorage.removeItem('cls_otp_requested');
            sessionStorage.removeItem('cls_saved_code');
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
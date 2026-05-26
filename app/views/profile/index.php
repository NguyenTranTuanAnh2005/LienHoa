<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container py-5 min-vh-100">
    <div class="row">
        <!-- Thông tin cá nhân -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 100px; z-index: 1010; max-height: calc(100vh - 120px); overflow-y: auto;">
                <div class="card-header bg-primary text-white py-3 border-0 d-flex align-items-center gap-2">
                    <i class="bi bi-person-lines-fill fs-5"></i>
                    <h5 class="mb-0 fw-bold">Thông tin cá nhân</h5>
                </div>
                <div class="card-body p-4">
                    <?php if (!$patient): ?>
                        <div class="alert alert-warning">
                            Không tìm thấy hồ sơ bệnh nhân. Vui lòng liên hệ bộ phận hỗ trợ.
                        </div>
                    <?php else: ?>
                        <form id="profileForm">
                            <div class="text-center mb-4">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                    <i class="bi bi-person text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($patient['full_name'] ?? '') ?></h5>
                                <span class="badge bg-secondary mb-2">Mã BN: <?= htmlspecialchars($patient['patient_code'] ?? 'N/A') ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" name="full_name" value="<?= htmlspecialchars($patient['full_name'] ?? '') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" name="phone" value="<?= htmlspecialchars($patient['phone'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Email</label>
                                <input type="email" class="form-control bg-light" name="email" value="<?= htmlspecialchars($patient['email'] ?? '') ?>">
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label text-muted small fw-bold">Ngày sinh</label>
                                    <input type="date" class="form-control bg-light" name="birthday" value="<?= htmlspecialchars($patient['birthday'] ?? '') ?>">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted small fw-bold">Giới tính</label>
                                    <select class="form-select bg-light" name="gender">
                                        <option value="">Chọn</option>
                                        <option value="Nam" <?= ($patient['gender'] ?? '') === 'Nam' ? 'selected' : '' ?>>Nam</option>
                                        <option value="Nữ" <?= ($patient['gender'] ?? '') === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">CCCD / Hộ chiếu</label>
                                <input type="text" class="form-control bg-light" name="cccd" value="<?= htmlspecialchars($patient['cccd'] ?? '') ?>">
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">Địa chỉ</label>
                                <textarea class="form-control bg-light" name="address" rows="2"><?= htmlspecialchars($patient['address'] ?? '') ?></textarea>
                            </div>

                            <hr class="text-muted">

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-danger"><i class="bi bi-shield-lock me-1"></i>Đổi mật khẩu (Bỏ trống nếu không đổi)</label>
                                <input type="password" class="form-control bg-light border-danger-subtle" name="password" placeholder="Mật khẩu mới">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm" id="btnUpdateProfile">
                                <i class="bi bi-save me-2"></i>Lưu thay đổi
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Lịch sử đặt lịch -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history fs-5 text-primary" id="history-header-icon"></i>
                        <h5 class="mb-0 fw-bold text-dark" id="history-header-title">Lịch sử</h5>
                    </div>
                    <?php 
                    $activeOtp = '***';
                    $activePatientCode = '';
                    $minutesLeft = 0;
                    if (isset($_SESSION)) {
                        foreach ($_SESSION as $key => $value) {
                            if (strpos($key, 'payment_otp_') === 0 && isset($value['expires_at']) && time() <= $value['expires_at']) {
                                $activeOtp = $value['otp'];
                                $activePatientCode = substr($key, strlen('payment_otp_'));
                                $minutesLeft = ceil(($value['expires_at'] - time()) / 60);
                                break;
                            }
                        }
                    }
                    ?>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Nút Lịch Sử Hóa Đơn -->

                        <!-- Hộp SMS hệ thống (Thiết kế tinh tế bên phải) -->
                        <div class="d-flex align-items-center bg-light rounded-pill px-3 py-1 border shadow-sm" style="border-color: #e2e8f0 !important; gap: 10px; cursor: pointer; transition: all 0.2s;" onclick="toggleSmsView()" id="sms-trigger-btn" onmouseover="this.classList.add('bg-white')" onmouseout="this.classList.remove('bg-white')">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-chat-dots-fill"></i>
                            </div>
                            <div class="d-flex flex-column lh-sm pe-2">
                                <span class="text-muted fw-bold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">SMS Hệ thống</span>
                                <span class="text-dark fw-bold" style="font-size: 0.85rem;" id="smsOtpDisplay">Mã OTP: <span class="text-danger ms-1"><?= $activeOtp ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Khung Chat SMS (Mặc định ẩn) -->
                <div id="sms-view" class="card-body p-0 d-flex flex-column" style="height: 500px;">
    <div class="chat-messages p-4 flex-grow-1" style="overflow-y: auto; background-color: #f8f9fa;">
        <?php if (!empty($activeOtp) && $activeOtp !== '***'): ?>
            <div class="d-flex mb-4 animate-fade-in-up">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                    <i class="bi bi-hospital fs-5"></i>
                </div>
                <div>
                    <div class="small text-muted mb-1 fw-bold">Hệ thống BV Liên Hoa</div>
                    <div class="bg-white p-3 rounded-4 shadow-sm border" style="border-radius: 0 1rem 1rem 1rem !important; max-width: 90%;">
                        BV LIEN HOA: Ma OTP cua quy khach la <strong class="text-danger fs-5"><?= htmlspecialchars($activeOtp) ?></strong>. 
                        Ma nay duoc dung de tra cuu lich su kham cho ma benh nhan <strong><?= htmlspecialchars($activePatientCode) ?></strong>. 
                        Vui long khong chia se ma nay cho bat ky ai. Ma co hieu luc trong <?= $minutesLeft ?? 5 ?> phut.
                    </div>
                    <div class="small text-muted mt-1" style="font-size: 0.75rem;"><?= date('H:i') ?></div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted h-100 d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-chat-left-dots fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                <p>Hệ thống sẵn sàng. Vui lòng nhập thông tin để nhận OTP.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="chat-input border-top p-3 bg-white mt-auto">
        <div class="input-group">
            <input type="text" id="sms-input" class="form-control rounded-pill bg-light border-0 ps-4" placeholder="Nhập tin nhắn..." onkeypress="if(event.key === 'Enter') handleSendSms()">
            <button id="sms-send-btn" onclick="handleSendSms()" class="btn btn-primary rounded-circle ms-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
        <div class="text-center mt-2">
            <small class="text-muted" style="font-size: 0.7rem;">Hộp thư tự động. Hệ thống có thể không phản hồi các tin nhắn rác.</small>
        </div>
    </div>
</div>

                <!-- Bảng Lịch sử -->
                <div id="history-view" class="card-body p-0">
                    <?php if (empty($bookings)): ?>
                        <div class="text-center py-5 text-muted">
                            <img src="<?= BASE_URL ?>/assets/images/empty-calendar.svg" alt="Empty" style="width: 120px; opacity: 0.5;" class="mb-3">
                            <p class="mb-0">Bạn chưa có lịch hẹn nào.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th class="py-3 px-4">Dịch vụ / Bác sĩ</th>
                                        <th class="py-3">Thời gian hẹn/Thời gian đặt</th>
                                        <th class="py-3">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td class="px-4 py-3">
                                                <?php if (!empty($booking['id_goi_kham'])): ?>
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle mb-1">Gói khám</span>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($booking['ten_goi_kham'] ?? '') ?></div>
                                                <?php elseif (!empty($booking['is_hospitalization'])): ?>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle mb-1">Nhập viện</span>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($booking['room_type'] ?? '') ?> - <?= htmlspecialchars($booking['department'] ?? '') ?></div>
                                                <?php elseif (!empty($booking['is_lab_test'])): ?>
                                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle mb-1" style="color: #fd7e14 !important; border-color: #fd7e14 !important;">Xét nghiệm</span>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($booking['test_type'] ?? '') ?></div>
                                                <?php else: ?>
                                                    <span class="badge bg-info bg-opacity-10 text-info border border-info-subtle mb-1">Chuyên khoa</span>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($booking['chuyen_khoa'] ?? '') ?></div>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($booking['ten_bac_si'])): ?>
                                                    <div class="small text-muted mt-1"><i class="bi bi-person-badge me-1"></i>BS. <?= htmlspecialchars($booking['ten_bac_si']) ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3">
                                                <div class="fw-bold text-danger">
                                                    <?= date('H:i', strtotime($booking['ngay_hen'])) ?>
                                                </div>
                                                <div class="small text-muted">
                                                    <?= date('d/m/Y', strtotime($booking['ngay_hen'])) ?>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <?php
                                                    $statusClass = 'bg-secondary';
                                                    $statusText = 'Không xác định';
                                                    switch($booking['trang_thai']) {
                                                        case 'dang_cho': 
                                                            $statusClass = 'bg-warning text-dark'; 
                                                            $statusText = 'Đang chờ duyệt'; 
                                                            break;
                                                        case 'da_xac_nhan': 
                                                            $statusClass = 'bg-primary'; 
                                                            $statusText = 'Đã xác nhận'; 
                                                            break;
                                                        case 'hoan_thanh': 
                                                            $statusClass = 'bg-success'; 
                                                            $statusText = 'Đã khám xong'; 
                                                            break;
                                                        case 'da_huy': 
                                                            $statusClass = 'bg-danger'; 
                                                            $statusText = 'Đã hủy'; 
                                                            break;
                                                    }
                                                ?>
                                                <span class="badge rounded-pill <?= $statusClass ?> px-3 py-2 fw-medium shadow-sm">
                                                    <?= $statusText ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = document.getElementById('btnUpdateProfile');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang lưu...';
            btn.disabled = true;

            const formData = new FormData(profileForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const res = await fetch('<?= BASE_URL ?>/profile/update', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await res.json();
                
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Lỗi', result.error || 'Cập nhật thất bại', 'error');
                }
            } catch (err) {
                console.error(err);
                Swal.fire('Lỗi', 'Không thể kết nối đến máy chủ.', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }
});

// 1. Hàm này chỉ dùng để MỞ khung tin nhắn (không tự đóng)
function openSmsView() {
    const historyView = document.getElementById('history-view');
    const smsView = document.getElementById('sms-view');
    const headerIcon = document.getElementById('history-header-icon');
    const headerTitle = document.getElementById('history-header-title');
    
    // Ẩn lịch sử, hiện tin nhắn
    historyView.classList.add('d-none');
    if (typeof invoiceView !== 'undefined') {
        invoiceView.classList.add('d-none');
        invoiceView.classList.remove('d-flex');
    }
    
    smsView.classList.remove('d-none');
    smsView.classList.add('d-flex');
    
    headerIcon.className = 'bi bi-arrow-left fs-5 text-primary';
    headerIcon.style.cursor = 'pointer';
    // Khi bấm vào mũi tên quay lại, gọi hàm đóng
    headerIcon.onclick = closeSmsView; 
    
    headerTitle.innerHTML = 'Tin nhắn hệ thống';
    headerTitle.style.cursor = 'pointer';
    headerTitle.onclick = closeSmsView;
    
    // Gọi API đọc tin nhắn
    fetch('<?= BASE_URL ?>/profile/clearOtpDot')
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const dot = document.getElementById('user-notification-dot');
                if (dot) dot.remove();
            }
        });

    const chatMessages = document.querySelector('.chat-messages');
    if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;
}

// 2. Hàm này chỉ dùng để ĐÓNG khung tin nhắn và quay lại lịch sử
function closeSmsView() {
    const historyView = document.getElementById('history-view');
    const smsView = document.getElementById('sms-view');
    const headerIcon = document.getElementById('history-header-icon');
    const headerTitle = document.getElementById('history-header-title');

    smsView.classList.add('d-none');
    smsView.classList.remove('d-flex');
    historyView.classList.remove('d-none');
    
    headerIcon.className = 'bi bi-clock-history fs-5 text-primary';
    headerTitle.innerHTML = 'Lịch sử';
    headerIcon.onclick = null;
    headerTitle.onclick = null;
    headerIcon.style.cursor = 'default';
    headerTitle.style.cursor = 'default';
}

function toggleInvoiceHistoryView() {
    const historyView = document.getElementById('history-view');
    const smsView = document.getElementById('sms-view');
    const invoiceView = document.getElementById('invoice-history-view');
    const headerIcon = document.getElementById('history-header-icon');
    const headerTitle = document.getElementById('history-header-title');
    
    if (invoiceView.classList.contains('d-none')) {
        historyView.classList.add('d-none');
        smsView.classList.add('d-none');
        smsView.classList.remove('d-flex');
        invoiceView.classList.remove('d-none');
        invoiceView.classList.add('d-flex');
        
        headerIcon.className = 'bi bi-arrow-left fs-5 text-primary';
        headerIcon.style.cursor = 'pointer';
        headerIcon.onclick = toggleInvoiceHistoryView;
        headerTitle.innerHTML = 'Lịch sử hóa đơn';
        headerTitle.style.cursor = 'pointer';
        headerTitle.onclick = toggleInvoiceHistoryView;
    } else {
        // Go back to main history
        invoiceView.classList.add('d-none');
        invoiceView.classList.remove('d-flex');
        smsView.classList.add('d-none');
        smsView.classList.remove('d-flex');
        historyView.classList.remove('d-none');
        headerIcon.className = 'bi bi-clock-history fs-5 text-primary';
        headerTitle.innerHTML = 'Lịch sử';
        headerIcon.onclick = null;
        headerTitle.onclick = null;
        headerIcon.style.cursor = 'default';
        headerTitle.style.cursor = 'default';
    }
}

function handleSendSms() {
    const input = document.getElementById('sms-input');
    const msg = input.value.trim();
    if (!msg) return;
    
    const chatContainer = document.querySelector('.chat-messages');
    
    // Xóa thẻ thông báo rỗng (nếu có)
    const emptyMsg = chatContainer.querySelector('.text-center.py-5');
    if (emptyMsg) emptyMsg.remove();
    
    // Thêm tin nhắn của User
    const timeNow = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
    const userHtml = `
        <div class="d-flex mb-4 justify-content-end animate-fade-in-up">
            <div>
                <div class="small text-muted mb-1 fw-bold text-end">Bạn</div>
                <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="border-radius: 1rem 0 1rem 1rem !important; max-width: 90%; margin-left: auto;">
                    ${msg}
                </div>
                <div class="small text-muted mt-1 text-end" style="font-size: 0.75rem;">${timeNow}</div>
            </div>
        </div>
    `;
    chatContainer.insertAdjacentHTML('beforeend', userHtml);
    input.value = '';
    chatContainer.scrollTop = chatContainer.scrollHeight;
    
    // Mô phỏng phản hồi tự động
    setTimeout(() => {
        const sysTime = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
        const sysHtml = `
            <div class="d-flex mb-4 animate-fade-in-up">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                    <i class="bi bi-hospital fs-5"></i>
                </div>
                <div>
                    <div class="small text-muted mb-1 fw-bold">Hệ thống BV Liên Hoa</div>
                    <div class="bg-white p-3 rounded-4 shadow-sm border" style="border-radius: 0 1rem 1rem 1rem !important; max-width: 90%;">
                        Hệ thống tự động: Vui lòng không trả lời tin nhắn này. Mọi thắc mắc xin liên hệ Hotline 1900 xxxx.
                    </div>
                    <div class="small text-muted mt-1" style="font-size: 0.75rem;">${sysTime}</div>
                </div>
            </div>
        `;
        chatContainer.insertAdjacentHTML('beforeend', sysHtml);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }, 1000);
}

</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>

<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container my-5 pt-4">
    <div class="mb-4">
        <a href="<?= BASE_URL ?>/doctor" class="text-decoration-none text-muted transition-all d-inline-flex align-items-center hover-primary">
            <i class="bi bi-arrow-left fs-5 me-2"></i> <span data-lang="btn_back_doctors" class="fw-medium">Quay lại danh sách bác sĩ</span>
        </a>
    </div>

    <div class="d-flex align-items-center justify-content-center gap-3 mb-5">
        <i class="bi bi-flower1 fs-1 text-theme animate-lotus"></i>
        <h3 class="fw-bold text-uppercase m-0 header-main-title" style="color: #26c4f1ff; letter-spacing: 1px;" data-lang="cv_title">Sơ yếu lý lịch chuyên gia</h3>
    </div>

    <div class="row g-4 justify-content-center">
        
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white border-top-theme">
                <div class="d-flex flex-column flex-sm-row gap-4 align-items-center align-items-sm-start">
                    <div class="flex-shrink-0">
                        <?php 
                            $hoTen = $doctor['ho_ten'] ?? '';
                            $doctorId = $doctor['id'] ?? 0;
                            
                            // LOGIC KIỂM TRA ẢNH
                            if ($doctorId == 1 || trim($hoTen) === 'Nguyễn Văn A' || trim($hoTen) === 'BS. CKII Nguyễn Văn A') {
                                $imgSrcDetail = BASE_URL . '/assets/images/doctor_nguyen_van_an.png';
                            } elseif ($doctorId == 2 || strpos($hoTen, 'Trần Thị') !== false) {
                                $imgSrcDetail = BASE_URL . '/assets/images/doctor_le_minh_tam.png';
                            } elseif ($doctorId == 3 || strpos($hoTen, 'Lê Minh Tâm') !== false || strpos($hoTen, 'Nguyễn Văn An') !== false) {
                                $imgSrcDetail = BASE_URL . '/assets/images/doctor_pham_quang_khai.png';
                            } elseif ($doctorId == 4 || strpos($hoTen, 'Phạm Quang Khải') !== false) {
                                $imgSrcDetail = BASE_URL . '/assets/images/doctor_tran_thanh_binh.png ';
                            } elseif ($doctorId == 5 || strpos($hoTen, 'Lê Quang Hải') !== false) {
                                $imgSrcDetail = BASE_URL . '/assets/images/doctor_le_quang_hai.png';
                            } elseif ($doctorId == 6 || strpos($hoTen, 'Nguyễn Thị Trang') !== false) {
                                $imgSrcDetail = BASE_URL . '/assets/images/doctor_nguyen_thi_trang.png';
                            } else {
                                $imgSrcDetail = !empty($doctor['hinh_anh']) ? BASE_URL . '/assets/images/' . $doctor['hinh_anh'] : 'https://cdn-icons-png.flaticon.com/512/3774/3774299.png';
                            }
                        ?>
                        <img src="<?= htmlspecialchars($imgSrcDetail) ?>" 
                             class="rounded-3 img-thumbnail shadow-sm bg-white-50" 
                             style="width: 170px; height: 170px; object-fit: cover; border: 4px solid rgba(13, 92, 117, 0.1);">
                    </div>
                    <div class="flex-grow-1 text-center text-sm-start">
                        <span class="badge bg-light text-theme mb-2 px-3 py-1.5 rounded-pill fw-semibold small">BS. CHUYÊN GIA</span>
                        <h2 class="fw-bold text-dark mb-2 fs-3" data-translate-text="true"><?= htmlspecialchars($hoTen) ?></h2>
                        
                        <div class="text-muted small mt-3 info-list-v6">
                            <p class="mb-2"><i class="bi bi-card-heading text-theme me-2"></i> <strong>Mã BS:</strong> LH-<?= str_pad($doctor['id'] ?? 0, 4, '0', STR_PAD_LEFT) ?></p>
                            <p class="mb-2"><i class="bi bi-building text-theme me-2"></i> Bệnh viện Liên Hoa - TP. Hồ Chí Minh</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white border-top-theme">
                <h5 class="fw-bold text-theme mb-3"><i class="bi bi-geo-fill me-2"></i> <span data-lang="cv_work_history_title">QUÁ TRÌNH CÔNG TÁC</span></h5>
                <div class="timeline-v6 ps-2 pt-2">
                    <div class="timeline-v6-item pb-3 position-relative ps-4 border-left-dot">
                        <span class="badge bg-light text-secondary mb-1 small" data-lang="cv_year_2023">Năm 2023</span>
                        <p class="text-dark mb-0 small fw-semibold" data-lang="cv_work_1">Tu nghiệp Chuyên gia tại nước ngoài</p>
                    </div>
                    <div class="timeline-v6-item pb-3 position-relative ps-4 border-left-dot">
                        <span class="badge bg-light text-secondary mb-1 small" data-lang="cv_year_2024">Năm 2024</span>
                        <p class="text-dark mb-0 small fw-semibold" data-lang="cv_work_2">Bệnh viện Liên Hoa - Tỉnh/TP. Hồ Chí Minh</p>
                    </div>
                    <div class="timeline-v6-item position-relative ps-4">
                        <span class="badge bg-light text-theme mb-1 small" data-lang="cv_year_2025">Năm 2025 - Nay</span>
                        <p class="text-dark mb-0 small fw-semibold" data-lang="cv_work_3">Hội đồng chuyên môn cao cấp - Hệ thống Y tế Liên Hoa</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white">
                <h5 class="fw-bold text-theme mb-3"><i class="bi bi-person-workspace me-2"></i> <span data-lang="cv_summary">TÓM TẮT TIỂU SỬ</span></h5>
                <div class="text-secondary lh-lg small text-justify" data-translate-text="true">
                    <?= nl2br(htmlspecialchars($doctor['tieu_su'] ?? 'Thông tin tiểu sử chuyên gia đang được cập nhật liên tục...')) ?>
                </div>
                <div class="mt-3 p-3 rounded-3 bg-light border-start border-4 border-theme">
                    <p class="mb-1 fw-bold text-dark small" data-translate-text="true"><?= htmlspecialchars($doctor['chuyen_khoa'] ?? '') ?></p>
                    <p class="mb-0 text-muted extra-small" data-translate-text="true"><?= htmlspecialchars($doctor['mo_ta_khoa'] ?? 'Chẩn đoán và điều trị chuyên sâu kỹ thuật cao tại hệ thống Liên Hoa.') ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white">
                <h5 class="fw-bold text-theme mb-3"><i class="bi bi-clock-history me-2"></i> <span data-lang="cv_working_hours">THỜI GIAN LÀM VIỆC ĐỊNH KỲ</span></h5>
                <div class="p-3 rounded-3 bg-f8 border mb-3">
                    <?php 
                        $days = ['T2' => false, 'T3' => false, 'T4' => false, 'T5' => false, 'T6' => false, 'T7' => false, 'CN' => false];
                        $ca_sang = '09:00 AM - 11:00 AM';
                        $ca_toi = '10:00 PM - 20:00 PM';
                        
                        if (!empty($doctor['lich_lam_viec'])) {
                            $lichData = json_decode($doctor['lich_lam_viec'], true);
                            if (is_array($lichData)) {
                                if (isset($lichData['days'])) {
                                    $days = array_merge($days, $lichData['days']);
                                }
                                if (!empty($lichData['ca_sang'])) {
                                    $ca_sang = $lichData['ca_sang'];
                                }
                                if (!empty($lichData['ca_toi'])) {
                                    $ca_toi = $lichData['ca_toi'];
                                }
                            }
                        } else {
                            if (strpos($hoTen, 'Nguyễn Văn An') !== false || strpos($hoTen, 'An') !== false) {
                                $days = ['T2' => true, 'T3' => false, 'T4' => true, 'T5' => false, 'T6' => true, 'T7' => false, 'CN' => false];
                            } elseif (strpos($hoTen, 'Trần Thanh Bình') !== false || strpos($hoTen, 'Trần Thị') !== false) {
                                $days = ['T2' => false, 'T3' => true, 'T4' => false, 'T5' => true, 'T6' => false, 'T7' => true, 'CN' => false];
                            } elseif (strpos($hoTen, 'Lê Minh Tâm') !== false || (strpos($hoTen, 'Nguyễn Văn A') !== false && strpos($hoTen, 'An') === false)) {
                                $days = ['T2' => true, 'T3' => true, 'T4' => false, 'T5' => true, 'T6' => false, 'T7' => false, 'CN' => true];
                            } elseif (strpos($hoTen, 'Phạm Quang Khải') !== false) {
                                $days = ['T2' => false, 'T3' => true, 'T4' => false, 'T5' => true, 'T6' => true, 'T7' => true, 'CN' => false];
                            } elseif (strpos($hoTen, 'Lê Quang Hải') !== false) {
                                $days = ['T2' => true, 'T3' => false, 'T4' => true, 'T5' => true, 'T6' => false, 'T7' => false, 'CN' => true];
                            } elseif (strpos($hoTen, 'Nguyễn Thị Trang') !== false) {
                                $days = ['T2' => false, 'T3' => true, 'T4' => true, 'T5' => false, 'T6' => false, 'T7' => true, 'CN' => true];
                            }
                        }
                    ?>
                    
                    <div class="d-flex flex-wrap gap-2 text-center mb-2">
                        <?php foreach($days as $day => $isWorking): ?>
                            <div class="flex-fill p-2 rounded-2 border <?php echo $isWorking ? 'bg-theme text-white border-theme shadow-sm' : 'bg-white text-muted opacity-40'; ?>" style="min-width: 42px; font-size: 0.8rem;">
                                <div class="fw-bold" data-lang="day_<?php echo strtolower($day); ?>"><?php echo $day; ?></div>
                                <div style="font-size: 0.65rem;" data-lang="<?php echo $isWorking ? 'cv_working' : 'cv_off'; ?>"><?php echo $isWorking ? 'Lịch trực' : 'Nghỉ'; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="time-slots-v6 border-top pt-3 small text-muted">
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="bi bi-sun me-2 text-warning"></i> <span data-lang="cv_morning_shift">Ca sáng:</span></span>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($ca_sang) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="bi bi-moon-stars me-2 text-info"></i> <span data-lang="cv_evening_shift">Ca tối:</span></span>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($ca_toi) ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt-5 mb-3">
        <a href="<?= BASE_URL ?>/booking?doctor_id=<?= $doctor['id'] ?? 0 ?>" class="btn btn-theme btn-lg rounded-pill px-5 shadow-sm btn-booking-cv d-inline-flex align-items-center justify-content-center text-white">
            <i class="bi bi-calendar-check me-2 fs-5"></i> <span data-lang="btn_book_now" class="fw-bold text-uppercase fs-6">Đặt lịch hẹn ngay</span>
        </a>
        <p class="text-center text-muted mt-3 small italic mb-0">
            <i data-lang="cv_footer_note">* Thông tin trên được xác nhận và đảm bảo bởi Hội đồng chuyên môn Bệnh viện Liên Hoa.</i>
        </p>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>

<style>
    .text-theme { color: #0d5c75 !important; }
    .bg-theme { background-color: #0d5c75 !important; }
    .border-theme { border-color: #0d5c75 !important; }
    
    .border-top-theme {
        border-top: 4px solid #0d5c75 !important;
    }

    .border-start-theme {
        border-left: 4px solid #0d5c75 !important;
    }

    .text-justify { text-align: justify; }
    .extra-small { font-size: 0.75rem !important; }

    .border-left-dot { border-left: 2px dashed #e2e8f0; }
    .timeline-v6-item::before {
        content: '';
        position: absolute;
        left: -5px;
        top: 6px;
        width: 8px;
        height: 8px;
        background-color: #0d5c75;
        border-radius: 50%;
    }

    h5 {
        border-left: 4px solid #0d5c75;
        padding-left: 10px;
        font-weight: 700 !important;
    }

    .bg-f8 { background-color: #f8fbfc; }
    .opacity-40 { opacity: 0.4; }

    .hover-primary { transition: all 0.2s ease-in-out; }
    .hover-primary:hover { color: #0d5c75 !important; transform: translateX(-3px); }

    .btn-theme {
        background-color: #0d5c75;
        border: none;
        transition: all 0.25s ease;
    }
    .btn-theme:hover {
        background-color: #083b4b;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 92, 117, 0.3) !important;
    }

    .animate-lotus {
        display: inline-block;
        animation: pulseLotus 3s infinite ease-in-out;
    }
    @keyframes pulseLotus {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
</style>
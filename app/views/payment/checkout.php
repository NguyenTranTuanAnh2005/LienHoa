<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<main class="flex-grow-1 bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold text-primary mb-5 text-center border-bottom pb-3">THÔNG TIN THANH TOÁN VIỆN PHÍ</h3>
                        
                        <div class="row">
                            <!-- CỘT TRÁI: THÔNG TIN HỒ SƠ -->
                            <div class="col-md-5 border-end pe-md-4 mb-4 mb-md-0">
                                <h5 class="fw-bold text-dark mb-4"><i class="bi bi-person-vcard-fill me-2 text-primary"></i>Chi tiết hồ sơ</h5>
                                
                                <div class="text-start bg-light p-4 rounded-4 shadow-sm border border-primary border-opacity-10 h-100">
                                    <div class="mb-3 border-bottom pb-3">
                                        <span class="text-muted d-block small mb-1">Mã hồ sơ/Bệnh nhân:</span>
                                        <span class="fw-bold fs-5 text-dark"><?= htmlspecialchars($data['ma_ho_so'] ?? $data['ma_benh_nhan'] ?? 'BN2026001') ?></span>
                                    </div>
                                    <div class="mb-3 border-bottom pb-3">
                                        <span class="text-muted d-block small mb-1">Tên bệnh nhân:</span>
                                        <span class="fw-bold fs-5 text-dark"><?= htmlspecialchars($data['ten_benh_nhan'] ?? 'Khách hàng thử nghiệm') ?></span>
                                    </div>
                                    <div class="mb-3 border-bottom pb-3">
                                        <span class="text-muted d-block small mb-1">Ngân hàng thụ hưởng:</span>
                                        <span class="fw-bold text-uppercase fs-6 text-primary"><i class="bi bi-bank me-1"></i> <?= htmlspecialchars($_GET['method'] ?? 'Ngân hàng nội địa') ?></span>
                                    </div>
                                    <div class="mt-4 text-center bg-white p-3 rounded-3 shadow-sm border">
                                        <span class="text-muted d-block small mb-1">Số tiền cần thanh toán</span>
                                        <span class="fw-bolder text-danger display-6"><?= number_format($data['tong_tien'] ?? 0, 0, ',', '.') ?></span>
                                        <span class="fw-bold text-danger">VND</span>
                                    </div>
                                </div>
                            </div>

                            <!-- CỘT PHẢI: HƯỚNG DẪN & UPLOAD -->
                            <div class="col-md-7 ps-md-4">
                                <h5 class="fw-bold text-dark mb-4"><i class="bi bi-wallet2 me-2 text-info"></i>Hướng dẫn chuyển khoản</h5>
                                
                                <div class="text-start mb-4">
                                    <ul class="list-unstyled text-muted small lh-lg">
                                        <li><i class="bi bi-1-circle-fill text-info me-2 fs-6"></i>Mở ứng dụng ngân hàng hoặc ví điện tử của bạn.</li>
                                        <li class="mt-2"><i class="bi bi-2-circle-fill text-info me-2 fs-6"></i>Chuyển khoản chính xác tới thông tin sau:
                                            <div class="bg-info bg-opacity-10 p-3 rounded-4 mt-2 mb-3 border border-info border-opacity-25 shadow-sm">
                                                <div class="d-flex justify-content-between mb-2 border-bottom border-info border-opacity-25 pb-2">
                                                    <span class="text-muted fw-semibold">Số tài khoản:</span>
                                                    <strong class="text-primary fs-5">190015152026</strong>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2 border-bottom border-info border-opacity-25 pb-2">
                                                    <span class="text-muted fw-semibold">Chủ tài khoản:</span>
                                                    <strong class="text-dark">BỆNH VIỆN ĐA KHOA LIÊN HOA</strong>
                                                </div>
                                                <div class="d-flex justify-content-between pt-1">
                                                    <span class="text-muted fw-semibold">Ngân hàng:</span>
                                                    <strong class="text-dark"><?= htmlspecialchars(strtoupper($_GET['method'] ?? 'N/A')) ?></strong>
                                                </div>
                                            </div>
                                        </li>
                                        <li><i class="bi bi-3-circle-fill text-info me-2 fs-6"></i>Nhập chính xác nội dung chuyển khoản là: 
                                            <div class="text-center mt-3 mb-2">
                                                <strong class="text-danger border border-2 border-danger px-4 py-2 rounded-pill bg-danger bg-opacity-10 fs-4 d-inline-block shadow-sm user-select-all">
                                                    <?= htmlspecialchars($data['ma_ho_so'] ?? $data['ma_benh_nhan'] ?? 'BN2026001') ?>
                                                </strong>
                                            </div>
                                            <div class="text-center small text-muted fst-italic">(Chạm để copy nội dung)</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="alert alert-warning border-0 small mb-4 text-start shadow-sm rounded-4 d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill fs-3 text-warning me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Lưu ý quan trọng:</h6>
                                        Hệ thống chỉ tự động duyệt khi <strong class="text-dark">Nội dung</strong> và <strong class="text-dark">Số tiền</strong> chuyển khoản khớp hoàn toàn.
                                    </div>
                                </div>

                                <div class="mb-4 text-start bg-white p-3 rounded-4 shadow-sm border border-2 border-primary border-opacity-25">
                                    <label class="form-label fw-bold text-primary mb-3"><i class="bi bi-cloud-arrow-up-fill me-2"></i>Tải lên biên lai chuyển khoản thành công</label>
                                    <input class="form-control form-control-lg bg-light border-0" type="file" id="receiptImage" accept="image/*" required>
                                    <div class="form-text small mt-2 text-muted"><i class="bi bi-info-circle me-1"></i>Hỗ trợ định dạng JPG, PNG (Tối đa 5MB)</div>
                                </div>

                                <?php $confirmCode = htmlspecialchars($data['ma_ho_so'] ?? $data['ma_benh_nhan'] ?? 'BN2026001'); ?>
                                <a href="<?= BASE_URL ?>/payment/success?code=<?= $confirmCode ?>" 
                                   class="btn btn-primary w-100 fw-bold py-3 rounded-pill shadow-sm fs-5 mb-3 text-white"
                                   style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%); border: none;">
                                    <i class="bi bi-check-circle-fill me-2"></i> XÁC NHẬN ĐÃ CHUYỂN KHOẢN
                                </a>
                                
                                <div class="text-center">
                                    <a href="<?= BASE_URL ?>/payment/select_bank?code=<?= $confirmCode ?>" class="text-decoration-none text-muted small fw-semibold">
                                        <i class="bi bi-arrow-left me-1"></i> Chọn ngân hàng khác
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
<?php
// Check for active notifications (e.g., OTP)
$hasNotification = false;
if (isset($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, 'payment_otp_') === 0) {
            if (isset($value['expires_at']) && time() <= $value['expires_at'] && empty($value['is_read'])) {
                $hasNotification = true;
                break;
            }
        }
    }
}
?>
<!-- HEADER ĐẦY ĐỦ: Đã hỗ trợ chuyển đổi giao diện ngôn ngữ VI/EN toàn bộ -->


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-lang="pageTitle">Bệnh viện Đa khoa Liên Hoa - Tinh Hoa Y Tế</title>
    <!-- Các link cần thiết -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="bg-light">

<!-- Thanh điều hướng Navbar (Header) -->
<nav class="navbar navbar-expand-lg navbar-glass sticky-top py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand text-primary fw-bolder d-flex align-items-center gap-2" href="<?= BASE_URL ?>/">
            <i class="bi bi-flower1 fs-2" style="color: var(--primary-color)"></i> 
            <span class="fs-4">
                <span style="color: #0d6efd;" data-lang="brand">Bệnh viện Đa khoa</span>
                <span style="color: #0dcaf0;" data-lang="brand_sub"> LIÊN HOA</span>
            </span>
        </a>
        
        <!-- Nút Toggle Mobile -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <i class="bi bi-list fs-1 text-primary"></i>
        </button>
        
        <!-- Menu liên kết -->
        <div class="collapse navbar-collapse" id="mainNavbar">
    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold fs-6">
        <li class="nav-item">
            <a class="nav-link px-3 active text-primary" href="<?= BASE_URL ?>/" data-lang="nav_home">Trang Chủ</a>
        </li>
<?php 
// Kiểm tra nếu KHÔNG phải là admin thì mới hiển thị nút này
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'): 
?>
        <li class="nav-item">
            <a class="nav-link px-3" href="<?= BASE_URL ?>/notice" data-lang="nav_notice">Thông báo</a>
        </li>
<li class="nav-item">
    <a class="nav-link px-3" href="<?= BASE_URL ?>/package" data-lang="nav_health_package">Gói Khám Sức Khoẻ Định Kỳ</a>
</li>
<?php endif; ?>
        
        <!-- Menu Dành Cho Admin -->
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
<li class="nav-item">
    <a class="nav-link px-3 text-danger fw-bold"
       href="<?= BASE_URL ?>/patient"
       data-lang="nav_patient">
        Quản lý bệnh nhân
    </a>
</li>

<li class="nav-item">
    <a class="nav-link px-3 text-danger fw-bold"
       href="<?= BASE_URL ?>/admin/package"
       data-lang="nav_packages">
        Gói khám
    </a>
</li>

<li class="nav-item">
    <a class="nav-link px-3 text-danger fw-bold"
       href="<?= BASE_URL ?>/admin/revenue"
       data-lang="nav_statistics">
        Thống kê
    </a>
</li>

<li class="nav-item">
    <a class="nav-link px-3 text-danger fw-bold"
       href="<?= BASE_URL ?>/admin/notices"
       data-lang="nav_notices_admin">
        Quản lý Thông báo
    </a>
</li>
<?php endif; ?>
            
            <!-- Nút Call to action + Đăng nhập + Đổi ngôn ngữ -->
            <div class="d-flex align-items-center gap-4">
                
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- Nút Đăng nhập -->
                    <a href="<?= BASE_URL ?>/auth/loginPage" class="btn btn-outline-primary rounded-pill px-4 py-2 d-flex align-items-center gap-2 text-decoration-none">
                        <i class="bi bi-box-arrow-in-right"></i> <span data-lang="btn_login">Đăng nhập</span>
                    </a>
                <?php else: ?>
                    <!-- Dropdown User (Đã Đăng Nhập) -->
                    <div class="dropdown">
                        <button class="btn btn-light rounded-pill px-4 py-2 d-flex align-items-center gap-2 fw-semibold border dropdown-toggle position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 text-primary"></i> 
                            <?= htmlspecialchars($_SESSION['full_name']) ?>
                            <?php if($hasNotification): ?>
                                <span id="user-notification-dot" class="position-absolute bg-danger border border-white rounded-circle" style="width: 12px; height: 12px; top: -1px; right: 2px; border-width: 2px !important; z-index: 10;"></span>
                            <?php endif; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>/admin/dashboard"><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>/profile"><i class="bi bi-person me-2 text-primary"></i>Hồ sơ y tế</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="#" onclick="logoutUser()"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'): ?>
                    <!-- Nút Đặt Lịch Ngay (Ẩn với Admin) -->
                    <a href="<?= BASE_URL ?>/booking" class="btn btn-booking-nav text-white shadow-sm rounded-pill px-4 py-2 d-flex align-items-center gap-2 text-decoration-none" style="background-color: #0d5c75;">
                        <i class="bi bi-calendar2-check-fill"></i> <span data-lang="btn_book">ĐẶT LỊCH NGAY</span>
                    </a>
                <?php endif; ?>
                
                <!-- Nút chọn ngôn ngữ VI/EN -->
                <div class="form-check form-switch ms-2">
                  <input class="form-check-input" type="checkbox" id="langSwitch" />
                  <label class="form-check-label fw-bold" for="langSwitch"><span id="langLabel">VI</span></label>
                </div>
            </div>
        </div>
    </div>
</nav>



<!-- Modal Đăng ký chung (User/Admin) -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel" data-lang="register_title">Đăng ký tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="registerForm">
          <!-- Mặc định ẩn Role, gán sẵn là Bệnh nhân trong CSDL khi submit -->
          <input type="hidden" name="role" value="patient">
          <div id="registerAlert" class="alert alert-danger d-none" role="alert"></div>
          <div class="mb-3">
            <label for="registerFullName" class="form-label" data-lang="register_fullname">Họ và tên</label>
            <input type="text" class="form-control rounded-3" id="registerFullName" required>
          </div>
          <div class="mb-3">
            <label for="registerEmail" class="form-label" data-lang="register_email">Email</label>
            <input type="email" class="form-control rounded-3" id="registerEmail">
          </div>
          <div class="mb-3">
            <label for="registerPhone" class="form-label" data-lang="register_phone">Số điện thoại</label>
            <input type="text" class="form-control rounded-3" id="registerPhone" required>
          </div>
          <div class="mb-3">
            <label for="registerPassword" class="form-label" data-lang="register_password">Mật khẩu</label>
            <input type="password" class="form-control rounded-3" id="registerPassword" required>
          </div>
          <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 mt-2 fw-semibold shadow-sm" data-lang="btn_register">Đăng ký ngay</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT xử lý các modal, nút, và chuyển đổi ngôn ngữ -->
<script src="<?= BASE_URL ?>/assets/js/translations.js?v=<?= time() ?>"></script>
<script>
  document.querySelector('#langSwitch').addEventListener('change', function() {
    const lang = this.checked ? 'EN' : 'VI';
    switchLanguage(lang);
  });

  const registerModalEl = document.getElementById('registerModal');
  if (registerModalEl) {
    const registerModal = new bootstrap.Modal(registerModalEl);
    const btnRegisterAccount = document.getElementById('btnRegisterAccount');
    if(btnRegisterAccount) {
        btnRegisterAccount.onclick = function() {
          let lang = localStorage.getItem('lang') || 'VI';
          document.getElementById('registerModalLabel').textContent = translations[lang].register_title;
          registerModal.show();
        };
    }
    
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
      registerForm.onsubmit = async function(e) {
        e.preventDefault();
        
        const fullName = document.getElementById('registerFullName').value;
        const email = document.getElementById('registerEmail').value;
        const phone = document.getElementById('registerPhone').value;
        const password = document.getElementById('registerPassword').value;
        const alertBox = document.getElementById('registerAlert');
        const submitBtn = registerForm.querySelector('button[type="submit"]');

        alertBox.classList.add('d-none');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...';
        submitBtn.disabled = true;

        try {
            const res = await fetch('<?= BASE_URL ?>/auth/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    full_name: fullName,
                    email: email,
                    phone: phone, 
                    password: password
                })
            });
            const data = await res.json();

            if (data.success) {
                alert('Đăng ký tài khoản thành công! Tự động đăng nhập...');
                window.location.href = data.redirect || '<?= BASE_URL ?>/';
            } else {
                alertBox.textContent = data.error || 'Có lỗi xảy ra khi đăng ký';
                alertBox.classList.remove('d-none');
            }
        } catch (error) {
            console.error(error);
            alertBox.textContent = 'Lỗi kết nối máy chủ. Vui lòng thử lại!';
            alertBox.classList.remove('d-none');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
      };
    }
  }

  function logoutUser() {
      fetch('<?= BASE_URL ?>/auth/logout', { method: 'POST' })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              window.location.href = '<?= BASE_URL ?>/';
          }
      });
  }
</script>

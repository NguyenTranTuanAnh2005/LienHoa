<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<style>
    body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
    .login-container { max-width: 900px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .login-image { background: linear-gradient(135deg, #0d5c75 0%, #168ba8 100%); display: flex; align-items: center; justify-content: center; color: white; padding: 3rem; text-align: center; }
    .btn-primary-custom { background-color: #0d5c75; border-color: #0d5c75; color: white; font-weight: 600; transition: all 0.3s; }
    .btn-primary-custom:hover { background-color: #0a4659; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(13, 92, 117, 0.3); color: white; }
    .form-control:focus { border-color: #0d5c75; box-shadow: 0 0 0 0.25rem rgba(13, 92, 117, 0.25); }
    .input-group-text { background-color: transparent; cursor: pointer; }
    
    /* Style cho phần chọn tư cách */
    .role-selection .btn-check:checked + .btn-outline-primary {
        background-color: #0d5c75;
        border-color: #0d5c75;
        color: white;
    }
    .role-selection .btn-outline-primary {
        color: #0d5c75;
        border-color: #0d5c75;
    }
</style>

<div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="row w-100 login-container">
        
        <div class="col-md-5 d-none d-md-flex login-image flex-column">
            <i class="bi bi-hospital fs-1 mb-3"></i>
            <h2 class="fw-bold mb-3">Liên Hoa Medical</h2>
            <p class="fs-6 opacity-75">Đăng nhập để đặt lịch khám nhanh chóng và theo dõi hồ sơ y tế của bạn.</p>
        </div>

        <div class="col-md-7 p-5">
            <div class="text-center mb-5">
                <h3 class="fw-bold" style="color: #0d5c75;">Chào mừng trở lại!</h3>
                <p class="text-muted">Vui lòng đăng nhập vào tài khoản của bạn</p>
            </div>
            
            <div id="loginAlert" class="alert alert-danger d-none" role="alert"></div>

            <form id="authLoginForm">
                <div class="mb-4">
                    <label class="form-label fw-semibold mb-2">Bạn đăng nhập với tư cách:</label>
                    <div class="btn-group w-100 role-selection" role="group">
                        <input type="radio" class="btn-check" name="role" id="roleUser" value="user" checked>
                        <label class="btn btn-outline-primary py-2" for="roleUser">
                            <i class="bi bi-person-fill me-2"></i>Bệnh nhân
                        </label>

                        <input type="radio" class="btn-check" name="role" id="roleAdmin" value="admin">
                        <label class="btn btn-outline-primary py-2" for="roleAdmin">
                            <i class="bi bi-shield-lock-fill me-2"></i>Admin
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="username" class="form-label fw-semibold">Tên đăng nhập (Email/SĐT)</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 text-muted"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="username" placeholder="Nhập email hoặc số điện thoại" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password" placeholder="Nhập mật khẩu" required>
                        <span class="input-group-text bg-white" id="togglePassword">
                            <i class="bi bi-eye-slash text-muted"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label text-muted" for="rememberMe">Ghi nhớ tôi</label>
                    </div>
                    <a href="#" class="text-decoration-none" style="color: #0d5c75; font-weight: 500;">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-3 fs-5 mb-4" id="btnLoginSubmit">
                    Đăng Nhập
                </button>
            </form>

            <div class="text-center">
                <p class="text-muted">Chưa có tài khoản? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" class="fw-bold text-decoration-none" style="color: #0d5c75;">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });

    document.getElementById('authLoginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const pass = document.getElementById('password').value;
        const role = document.querySelector('input[name="role"]:checked').value; // Lấy giá trị role
        const btnSubmit = document.getElementById('btnLoginSubmit');
        const alertBox = document.getElementById('loginAlert');
        
        if(!username || !pass) return;

        const originalText = btnSubmit.innerHTML;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...';
        btnSubmit.disabled = true;
        alertBox.classList.add('d-none');

        try {
            const res = await fetch('<?= BASE_URL ?>/auth/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    username: username, 
                    password: pass,
                    role: role // Gửi kèm tư cách đăng nhập lên server
                })
            });
            const data = await res.json();

            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alertBox.textContent = data.error || 'Sai tài khoản hoặc mật khẩu';
                alertBox.classList.remove('d-none');
            }
        } catch (error) {
            console.error(error);
            alertBox.textContent = 'Lỗi kết nối máy chủ. Vui lòng thử lại!';
            alertBox.classList.remove('d-none');
        } finally {
            btnSubmit.innerHTML = originalText;
            btnSubmit.disabled = false;
        }
    });
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
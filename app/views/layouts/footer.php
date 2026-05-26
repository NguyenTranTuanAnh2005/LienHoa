    </main> <!-- Đóng Content Main Layout -->

    <!-- =========================
        FOOTER PREMIUM
    ========================== -->
    <footer class="footer-premium text-white pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row mb-5 mt-3">

                <!-- Giới thiệu -->
                <div class="col-lg-4 pe-lg-5 mb-4 mb-lg-0">
                    <h4 class="fw-bolder mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-flower1 text-white"></i>
                        <span class="text-white" data-lang="brand">Bệnh viện Đa khoa</span>
                        <span class="text-info" data-lang="brand_sub">LIÊN HOA</span>
                    </h4>

                    <p class="text-light lh-lg pe-3" data-lang="footer_desc">
                        Hệ thống chuyển đổi số toàn diện trong y tế.
                        Với thông điệp "Tận tâm chữa trị, ân cần chăm sóc",
                        chúng tôi luôn mang lại dịch vụ nhanh chóng,
                        tối ưu và hiệu quả nhất cho từng bệnh nhân.
                    </p>
                </div>

                <!-- Liên hệ -->
                <div class="col-lg-4 px-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-4 border-bottom border-secondary d-inline-block pb-2 text-white"
                        data-lang="footer_contact_title">
                        Thông Tin Liên Hệ
                    </h5>

                    <ul class="list-unstyled text-light lh-lg">
                        <li class="mb-3 d-flex align-items-start gap-3">
                            <i class="bi bi-geo-alt-fill text-info mt-1 fs-5"></i>
                            <span data-lang="footer_address">
                                123 Đường Y Tế, Phường Bệnh Viện, Quận 14, TP.HCM
                            </span>
                        </li>

                        <li class="mb-3 d-flex align-items-center gap-3">
                            <i class="bi bi-telephone-fill text-info fs-5"></i>
                            <span>
                                <span data-lang="footer_hotline_lbl">
                                    Hotline/Cấp cứu:
                                </span>
                                <strong class="text-warning text-decoration-underline">
                                    1900 8888
                                </strong>
                                (24/7)
                            </span>
                        </li>

                        <li class="mb-3 d-flex align-items-center gap-3">
                            <i class="bi bi-envelope-fill text-info fs-5"></i>
                            <span>cskh@lienhoamedical.vn</span>
                        </li>
                    </ul>
                </div>

                <!-- Giờ làm việc -->
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-4 border-bottom border-secondary d-inline-block pb-2 text-white"
                        data-lang="footer_hours_title">
                        Giờ Làm Việc
                    </h5>

                    <ul class="list-unstyled text-light lh-lg">
                        <li class="d-flex justify-content-between border-bottom border-secondary pb-2 mb-3">
                            <span>
                                <i class="bi bi-clock me-2"></i>
                                <span data-lang="footer_weekday">Thứ 2 - Thứ 6:</span>
                            </span>
                            <span class="fw-semibold">07:00 - 20:00</span>
                        </li>

                        <li class="d-flex justify-content-between border-bottom border-secondary pb-2 mb-3">
                            <span>
                                <i class="bi bi-clock me-2"></i>
                                <span data-lang="footer_weekend">Thứ 7, Chủ Nhật:</span>
                            </span>
                            <span class="fw-semibold">07:00 - 17:00</span>
                        </li>

                        <li class="d-flex justify-content-between text-warning fw-bold bg-dark bg-opacity-25 px-3 py-2 rounded-3 mt-3">
                            <span>
                                <i class="bi bi-activity me-2"></i>
                                <span data-lang="footer_emergency_lbl">
                                    Trực Cấp Cứu:
                                </span>
                            </span>

                            <span data-lang="footer_emergency_val">
                                Hỗ Trợ 24/7
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary mb-4">

            <!-- Copyright -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-light fs-6">
                <p class="mb-2 mb-md-0 d-flex align-items-center gap-1">
                    <span data-lang="footer_copyright">
                        &copy; 2026 Liên Hoa Medical. Đã đăng ký bản quyền.
                    </span>
                    <i class="bi bi-shield-check"></i>
                </p>

                <div class="d-flex gap-3 fs-5">
                    <a href="#" class="text-white text-decoration-none social-icon">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="#" class="text-white text-decoration-none social-icon">
                        <i class="bi bi-youtube"></i>
                    </a>

                    <a href="#" class="text-white text-decoration-none social-icon">
                        <i class="bi bi-chat-text"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <?php
    $uri = $_SERVER['REQUEST_URI'] ?? '';

    $isHome = (
        $uri == '/' ||
        $uri == '/doanbenhvienthongminh_6/' ||
        $uri == '/doanbenhvienthongminh_6/home' ||
        $uri == '/doanbenhvienthongminh_6/home/index'
    );

    if ($isHome):
    ?>

    <!-- =========================
        QUICK ACCESS SIDEBAR
    ========================== -->
    <div class="quick-access-sidebar">

        <!-- Header -->
        <div class="qa-title-badge"
             data-bs-toggle="collapse"
             data-bs-target="#qaPillsCollapse"
             aria-expanded="false"
             aria-controls="qaPillsCollapse">

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-flower1 qa-logo animate-pulse"></i>
                <span class="qa-title-text">
                    <span style="color: #0d6efd; font-size: 0.8rem; line-height: 1;">Bệnh viện Đa khoa</span>
                    <span style="color: #0dcaf0; font-size: 1.1rem; line-height: 1.1;">LIÊN HOA</span>
                </span>
            </div>

            <div class="ms-3 border-start ps-3 border-info d-flex align-items-center">
                <span class="fw-bold text-dark me-2">TIỆN ÍCH</span>
                <i class="bi bi-chevron-right qa-toggle-icon text-primary fs-5"></i>
            </div>
        </div>

        <!-- Nội dung -->
<div class="collapse" id="qaPillsCollapse">
    <div class="qa-pills-container mt-2">

        <a href="<?= BASE_URL ?>/#dich-vu" class="qa-pill">
            <i class="bi bi-heart-pulse-fill me-2 text-danger"></i>
            <span data-lang="srv_title_1">Dịch vụ của chúng tôi</span>
        </a>

        <a href="<?= BASE_URL ?>/#so-do" class="qa-pill">
            <i class="bi bi-map-fill me-2 text-info"></i>
            <span data-lang="map_main_title_1">Sơ Đồ Tổng Quan</span>
        </a>

        <a href="<?= BASE_URL ?>/#bac-si" class="qa-pill">
            <i class="bi bi-person-badge-fill me-2 text-primary"></i>
            <span data-lang="doc_title_1">Đội ngũ bác sĩ chuyên gia</span>
        </a>

        <a href="<?= BASE_URL ?>/#chuyen-khoa" class="qa-pill">
            <i class="bi bi-star-fill me-2 text-warning"></i>
            <span data-lang="spec_title_1">Chuyên khoa mũi nhọn</span>
        </a>

        <a href="<?= BASE_URL ?>/#goi-kham" class="qa-pill">
            <i class="bi bi-shield-plus me-2 text-success"></i>
            <span data-lang="pkg_title_1">Gói chăm sóc sức khỏe</span>
        </a>
    </div>
</div>
    </div>

    <?php endif; ?>

    <!-- =========================
        AI CHATBOT
    ========================== -->

    <!-- Floating AI Button -->
    <div class="fab-container">

        <button class="fab-btn fab-ai animate-pulse-glow"
                id="chatToggleBtn"
                onclick="toggleChat()">

            <i class="bi bi-robot"></i>
        </button>
    </div>

    <!-- Chat Window -->
    <div id="ai-chat-window" class="ai-chat-window">

        <!-- Header -->
        <div class="ai-chat-header">
            <div class="d-flex align-items-center gap-2">
                <div class="ai-avatar">
                    <i class="bi bi-flower1"></i>
                </div>

                <div>
                    <h6 class="mb-0 fw-bold">
                        Liên Hoa AI
                    </h6>

                    <small class="text-light opacity-75">
                        Trợ lý chăm sóc sức khỏe
                    </small>
                </div>
            </div>

            <button class="btn-close btn-close-white"
                    onclick="toggleChat()">
            </button>
        </div>

        <!-- Messages -->
        <div id="chat-messages" class="ai-chat-messages">

            <div class="message ai-message">
                <div class="message-content">
                    👋 Xin chào! Tôi là trợ lý AI của Liên Hoa Medical.
                    Tôi có thể hỗ trợ đặt lịch khám, tư vấn dịch vụ,
                    tra cứu chuyên khoa và giải đáp thông tin cho bạn.
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="ai-chat-footer">

            <div class="input-group">
                <input type="text"
                       id="chat-input"
                       class="form-control"
                       placeholder="Nhập câu hỏi của bạn...">

                <button class="btn btn-primary px-4"
                        onclick="sendMessage()">

                    <i class="bi bi-send-fill"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- =========================
        STYLE
    ========================== -->
    <style>

    body{
        overflow-x: hidden;
    }

    /* =========================
        FOOTER
    ========================== */

    .footer-premium{
        background:
            linear-gradient(
                135deg,
                #052c3b 0%,
                #0d5c75 50%,
                #11779b 100%
            );

        position: relative;
        overflow: hidden;
    }

    .footer-premium::before{
        content:'';
        position:absolute;
        top:-100px;
        right:-100px;
        width:300px;
        height:300px;
        background:rgba(255,255,255,0.05);
        border-radius:50%;
    }

    .social-icon{
        transition: all .3s ease;
    }

    .social-icon:hover{
        color:#0dcaf0 !important;
        transform: translateY(-4px) scale(1.15);
    }

    /* =========================
        FLOATING BUTTON
    ========================== */

    .fab-container{
        position:fixed;
        right:30px;
        bottom:30px;
        z-index:9999;
    }

    .fab-btn{
        width:75px;
        height:75px;
        border:none;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:34px;
        color:white;
        cursor:pointer;

        background: linear-gradient(
            135deg,
            #0dcaf0,
            #0d6efd
        );

        box-shadow:
            0 10px 30px rgba(13,110,253,.35);

        transition: all .35s ease;
    }

    .fab-btn:hover{
        transform: translateY(-8px) scale(1.05);
    }

    /* =========================
        CHAT WINDOW
    ========================== */

    .ai-chat-window{
        position: fixed;
        right: 30px;
        bottom: 120px;

        width: 390px;
        height: 620px;

        background: white;

        border-radius: 25px;

        overflow: hidden;

        display: none;
        flex-direction: column;

        z-index: 9999;

        box-shadow:
            0 20px 60px rgba(0,0,0,.25);

        animation: chatFade .35s ease;
    }

    @keyframes chatFade{
        from{
            opacity:0;
            transform: translateY(20px) scale(.95);
        }

        to{
            opacity:1;
            transform: translateY(0) scale(1);
        }
    }

    .ai-chat-header{
        background:
            linear-gradient(
                135deg,
                #0d5c75,
                #0d6efd
            );

        color:white;

        padding:18px 20px;

        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .ai-avatar{
        width:45px;
        height:45px;
        border-radius:50%;
        background:rgba(255,255,255,.2);

        display:flex;
        align-items:center;
        justify-content:center;

        font-size:1.3rem;
    }

    .ai-chat-messages{
        flex:1;
        padding:20px;
        overflow-y:auto;

        background:
            linear-gradient(
                to bottom,
                #f8fbff,
                #eef6ff
            );
    }

    .message{
        margin-bottom:16px;
        display:flex;
    }

    .message-content{
        max-width:80%;
        padding:14px 18px;
        border-radius:18px;
        line-height:1.5;
        font-size:.95rem;
    }

    .ai-message{
        justify-content:flex-start;
    }

    .ai-message .message-content{
        background:white;
        color:#333;
        border-top-left-radius:5px;

        box-shadow:
            0 4px 10px rgba(0,0,0,.05);
    }

    .user-message{
        justify-content:flex-end;
    }

    .user-message .message-content{
        background:
            linear-gradient(
                135deg,
                #0d6efd,
                #0dcaf0
            );

        color:white;
        border-top-right-radius:5px;
    }

    .ai-chat-footer{
        padding:15px;
        border-top:1px solid #e9ecef;
        background:white;
    }

    .ai-chat-footer .form-control{
        border-radius:15px;
        padding:12px 15px;
    }

    .ai-chat-footer .btn{
        border-radius:15px;
    }

    /* =========================
        QUICK ACCESS
    ========================== */

    .quick-access-sidebar{
        position: fixed;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1050;

        display:flex;
        flex-direction:column;
        gap:15px;
        align-items:flex-start;
    }

    .qa-title-badge{
        display:flex;
        align-items:center;
        background: #ffffff;
        padding: 12px 20px 12px 15px;
        border-radius: 0 50px 50px 0;
        box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        cursor:pointer;
        border: 2px solid #0dcaf0;
        border-left: none;
        transition: all 0.3s ease;
    }
    
    .qa-title-badge:hover {
        background: #f8fbff;
        transform: translateX(5px);
    }

    .qa-logo{
        font-size: 2rem;
        color: #0d6efd;
    }

    .qa-title-text{
        font-weight: 800;
        display: flex;
        flex-direction: column;
    }

    .qa-pills-container{
        display:flex;
        flex-direction:column;
        gap:12px;
        padding-left:0;
    }

    .qa-pill{
        display:inline-block;
        background: #ffffff;
        color: #0d5c75;
        font-weight: 700;
        padding: 12px 24px;
        border-radius: 0 50px 50px 0;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 15px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
        border-left: 4px solid #0dcaf0;
    }

    .qa-pill:hover{
        background: #0d5c75;
        color: white !important;
        border-color: #0d5c75;
        transform: translateX(10px);
    }
    
    .qa-pill:hover i {
        color: white !important;
    }

    /* =========================
        ANIMATION
    ========================== */

    @keyframes pulseGlow{
        0%{
            box-shadow:0 0 0 0 rgba(13,110,253,.45);
        }

        70%{
            box-shadow:0 0 0 18px rgba(13,110,253,0);
        }

        100%{
            box-shadow:0 0 0 0 rgba(13,110,253,0);
        }
    }

    @keyframes floatButton{
        0%{
            transform:translateY(0);
        }

        50%{
            transform:translateY(-8px);
        }

        100%{
            transform:translateY(0);
        }
    }

    .animate-pulse-glow{
        animation:
            floatButton 3s ease-in-out infinite,
            pulseGlow 2.5s infinite;
    }

    @keyframes float-left-right{
        0%{
            transform:translateX(0);
        }

        50%{
            transform:translateX(12px);
        }

        100%{
            transform:translateX(0);
        }
    }

    .animate-float-left-right{
        animation: float-left-right 3.5s ease-in-out infinite;
    }

    /* =========================
        RESPONSIVE
    ========================== */

    @media(max-width:768px){

        .ai-chat-window{
            width: calc(100% - 20px);
            height: 85vh;

            right:10px;
            bottom:90px;
        }

        .fab-container{
            right:15px;
            bottom:20px;
        }

        .fab-btn{
            width:65px;
            height:65px;
            font-size:28px;
        }

        .quick-access-sidebar{
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            bottom: auto;
        }

        .qa-pill{
            font-size:.9rem;
            padding:12px 18px;
        }
    }

    </style>

    <!-- =========================
        SCRIPT
    ========================== -->
    <script>

    // Toggle Chat
    function toggleChat(){

        const chatWindow =
            document.getElementById('ai-chat-window');

        if(chatWindow.style.display === 'flex'){
            chatWindow.style.display = 'none';
        }else{
            chatWindow.style.display = 'flex';
        }
    }

    // Enter gửi tin nhắn
    document.addEventListener('DOMContentLoaded', function(){

        const input =
            document.getElementById('chat-input');

        if(input){
            input.addEventListener('keypress', function(e){

                if(e.key === 'Enter'){
                    sendMessage();
                }
            });
        }
    });

    // Gửi tin nhắn
    async function sendMessage(){

        const input =
            document.getElementById('chat-input');

        const messages =
            document.getElementById('chat-messages');

        const message = input.value.trim();

        if(!message) return;

        // Tin nhắn user
        messages.innerHTML += `
            <div class="message user-message">
                <div class="message-content">
                    ${message}
                </div>
            </div>
        `;

        input.value = '';

        // Scroll xuống cuối
        messages.scrollTop = messages.scrollHeight;

        // Loading
        const loadingId =
            'loading-' + Date.now();

        messages.innerHTML += `
            <div class="message ai-message" id="${loadingId}">
                <div class="message-content">
                    <span class="spinner-border spinner-border-sm me-2"></span>
                    AI đang trả lời...
                </div>
            </div>
        `;

        messages.scrollTop = messages.scrollHeight;

        try{

            // API Backend
            const response = await fetch(
                '<?= BASE_URL ?>/chatbot/handleChat',
                {
                    method:'POST',

                    headers:{
                        'Content-Type':'application/json'
                    },

                    body: JSON.stringify({
                        message: message
                    })
                }
            );

            const data = await response.json();

            // Xóa loading
            document
                .getElementById(loadingId)
                ?.remove();

            // AI trả lời
            messages.innerHTML += `
                <div class="message ai-message">
                    <div class="message-content">
                        ${data.reply || 'Xin lỗi, hiện tại tôi chưa thể phản hồi.'}
                    </div>
                </div>
            `;

            messages.scrollTop = messages.scrollHeight;

        }catch(error){

            document
                .getElementById(loadingId)
                ?.remove();

            messages.innerHTML += `
                <div class="message ai-message">
                    <div class="message-content text-danger">
                        Đã xảy ra lỗi kết nối máy chủ.
                    </div>
                </div>
            `;

            messages.scrollTop = messages.scrollHeight;
        }
    }

    // Tránh đè footer
    window.addEventListener('scroll', function(){

        const footer =
            document.querySelector('footer.footer-premium');

        const fab =
            document.querySelector('.fab-container');

        const sidebar =
            document.querySelector('.quick-access-sidebar');

        if(!footer) return;

        const footerRect =
            footer.getBoundingClientRect();

        const windowHeight =
            window.innerHeight;

        if(footerRect.top < windowHeight){

            const overlap =
                windowHeight - footerRect.top;

            if(fab){
                fab.style.marginBottom =
                    overlap + 'px';
            }

            if(sidebar){
                sidebar.style.marginBottom =
                    overlap + 'px';
            }

        }else{

            if(fab){
                fab.style.marginBottom = '0px';
            }

            if(sidebar){
                sidebar.style.marginBottom = '0px';
            }
        }
    });

    </script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= BASE_URL ?>/assets/js/script.js"></script>

</body>
</html>
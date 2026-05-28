<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<!-- BANNER HERO CHÍNH -->
<section class="hero-section position-relative overflow-hidden" style="min-height: 550px; background-color: #f8fbff;">
    <div class="position-absolute top-0 end-0 h-100 w-100 d-none d-lg-block" style="
        background-image: linear-gradient(to right, #f8fbff 35%, rgba(248, 251, 255, 0) 60%), url('<?= BASE_URL ?>/assets/images/image_11.png');
        background-size: cover;
        background-position: center right;
        z-index: 1;
    "></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center" style="min-height: 550px;">
            <div class="col-lg-6 col-xl-5 animate-fade-in-up">
                <div class="hero-badge px-3 py-1 rounded-pill d-inline-block mb-3" style="background: rgba(13, 92, 117, 0.1); color: var(--primary-color);">
                    <span class="fs-6 fw-bold" data-lang="hero_badge">✨ Hệ thống Y tế Chất lượng cao</span>
                </div>
                
                <h1 class="hero-title mb-0" style="font-size: 4rem; font-weight: 800; line-height: 1.1; color: #0d3b4b;">
                    <span style="color: #0d6efd;" data-lang="hero_title1">Bệnh Viện</span> <br>
<span style="color: #0dcaf0;" data-lang="hero_title2">Liên Hoa</span>
                </h1>
                
                </div>
        </div>
    </div>
    
</section>

<!-- GIỚI THIỆU VỀ BỆNH VIỆN (COMPACT CARD) -->
<section style="padding: 60px 0; background: transparent;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- CARD GIỚI THIỆU -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative animate-fade-in-up">
                    <div class="position-absolute top-0 start-0 w-100" style="height: 6px; background: linear-gradient(90deg, #0d6efd, #0dcaf0);"></div>
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-hospital fs-1" style="color: #0d6efd;"></i>
                        </div>
                        <h2 class="fw-bolder text-center mb-5" style="font-size: 2rem;" data-lang="about_title">
                            Giới thiệu về <span style="color: #0d6efd;">Bệnh viện Đa khoa</span> <span style="color: #0dcaf0;">LIÊN HOA</span>
                        </h2>
                        
                        <div class="row g-4 text-start">
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="mt-1" style="color: #0d6efd;"><i class="bi bi-heart-pulse-fill fs-4"></i></div>
                                    <p class="text-muted lh-lg mb-0" style="font-size: 1rem; text-align: justify;" data-lang="about_desc1">
                                        Chúng tôi cung cấp dịch vụ chăm sóc tận tâm, chất lượng cao, chi phí hợp lý với hệ thống đa chuyên khoa. Mạng lưới liên viện trên toàn quốc sẵn sàng trao đổi kiến thức và thực hành lâm sàng cùng các chuyên gia y tế toàn cầu.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="mt-1" style="color: #0dcaf0;"><i class="bi bi-shield-fill-check fs-4"></i></div>
                                    <p class="text-muted lh-lg mb-0" style="font-size: 1rem; text-align: justify;" data-lang="about_desc2">
                                        Được chứng nhận bởi Hội đồng Tiêu chuẩn Chăm sóc Sức khỏe Quốc tế (ACHSI), minh chứng mạnh mẽ nhất về chất lượng chăm sóc lâm sàng, đảm bảo an toàn tuyệt đối và mang lại trải nghiệm y tế tốt nhất cho bệnh nhân.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KHU VỰC THẺ TÍNH NĂNG (DỊCH VỤ CHÍNH) -->
<section class="container pb-5 position-relative" style="margin-top: 40px; z-index: 10;">
    <div class="row g-4 px-3 px-lg-0">
        
        <!-- Chuyên Khoa Đa Dạng -->
        <div class="col-md-4">
            <div class="feature-card px-4 py-5 text-center d-flex flex-column justify-content-between h-100">
                <div>
                    <div class="icon-box icon-bg-primary mx-auto shadow-sm">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h4 class="fw-bolder mb-3 text-dark" data-lang="feat1_title">Chuyên Khoa Đa Dạng</h4>
                    <p class="text-muted mb-4 px-2 lh-lg" data-lang="feat1_desc">Hệ thống khám chữa bệnh nội & khoa liên viện với hơn 50 chuyên khoa sâu, trang thiết bị tối tân chuẩn xác.</p>
                </div>
                <a href="<?= BASE_URL ?>/doctor" class="text-primary fw-bold text-decoration-none hover-link d-inline-block mx-auto position-relative">
                    <span data-lang="feat1_link">Xem Chuyên Khoa & Bác Sĩ</span> <i class="bi bi-arrow-right-short fs-5 vertical-align-middle border border-primary rounded-circle ms-1 p-1"></i>
                </a>
            </div>
        </div>

        <!-- Tầm Soát Sức Khoẻ -->
        <div class="col-md-4">
            <div class="feature-card px-4 py-5 text-center position-relative d-flex flex-column justify-content-between h-100 border-top border-4 border-info">
                <span class="position-absolute badge rounded-pill bg-danger shadow px-3 py-2 fw-bold" style="top: -15px; left: 50%; transform: translateX(-50%); letter-spacing: 0.5px;"><i class="bi bi-fire me-1"></i> HOT NHẤT</span>
                <div>
                    <div class="icon-box icon-bg-info mx-auto shadow-sm">
                        <i class="bi bi-prescription2"></i>
                    </div>
                    <h4 class="fw-bolder mb-3 text-dark" data-lang="feat2_title">Tầm Soát Bệnh Lý</h4>
                    <p class="text-muted mb-4 px-2 lh-lg" data-lang="feat2_desc">Tương lai của y học dự phòng là bắt đầu từ hôm nay. Phù hợp đa dạng cho Nam, Nữ, Gia Đình và Doanh nghiệp.</p>
                </div>
                <a href="<?= BASE_URL ?>/package" class="text-info fw-bold text-decoration-none mt-auto hover-link mx-auto position-relative">
                    <span data-lang="feat2_link">Tra Cứu Các Gói Khám</span> <i class="bi bi-arrow-right-short fs-5 vertical-align-middle border border-info rounded-circle ms-1 p-1"></i>
                </a>
            </div>
        </div>

        <!-- Hỗ Trợ Trực Tuyến -->
        <div class="col-md-4">
            <div class="feature-card px-4 py-5 text-center d-flex flex-column justify-content-between h-100">
                <div>
                    <div class="icon-box icon-bg-success mx-auto shadow-sm">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4 class="fw-bolder mb-3 text-dark" data-lang="feat3_title">Đặt Lịch Khám</h4>
                    <p class="text-muted mb-4 px-2 lh-lg" data-lang="feat3_desc">Chức năng đặt lịch khám trực tuyến nhanh chóng và tiện lợi.</p>
                </div>
                <a href="<?= BASE_URL ?>/booking" class="text-success fw-bold text-decoration-none mt-auto hover-link mx-auto position-relative">
                    <span data-lang="feat3_link">Liên Hệ Ngay Bây Giờ</span> <i class="bi bi-arrow-right-short fs-5 vertical-align-middle border border-success rounded-circle ms-1 p-1"></i>
                </a>
            </div>
        </div>

    </div>
</section>

<!-- NHÚNG CSS MỚI CHO GIAO DIỆN DỊCH VỤ -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/services.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@500;700;800&display=swap');
    
    .hospital-section-title {
        font-family: 'Nunito', sans-serif;
        font-weight: 800;
        font-size: 2.4rem;
        background: linear-gradient(135deg, #0d6efd 10%, #0dcaf0 90%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.2rem;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
    }
    
    .hospital-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #0dcaf0);
        border-radius: 4px;
    }
    
    .hospital-section-subtitle {
        font-family: 'Nunito', sans-serif;
        color: #5c6c7b;
        font-size: 1.15rem;
        line-height: 1.6;
        max-width: 800px;
        margin: 0 auto;
        font-weight: 500;
    }

    .scroll-fade-in {
        opacity: 0;
        transform: translateY(25px) scale(0.98);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        will-change: opacity, transform;
    }
    
    .scroll-fade-in.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.scroll-fade-in').forEach(el => {
        observer.observe(el);
    });
});
</script>

<!-- DỊCH VỤ CỦA CHÚNG TÔI -->
<section id="dich-vu" class="container py-5 mt-4">
    <div class="text-center mb-5 scroll-fade-in">
        <h2 class="hospital-section-title" data-lang="srv_title">Dịch Vụ Của Chúng Tôi</h2>
        <p class="hospital-section-subtitle" data-lang="srv_desc">Mang đến trải nghiệm chăm sóc sức khỏe toàn diện và tiện ích nhất.</p>
    </div>

    <div id="quick-access-bar" class="d-none d-md-flex flex-column shadow-lg">

    <!-- Tiêu đề -->
    <div class="quick-title">
        <i class="bi bi-grid-fill"></i>
        <span class="title-text">
            <span class="text-main" data-lang="quick_menu_tien">Tiện</span>
            <span class="text-sub" data-lang="quick_menu_ich">Ích</span>
        </span>
    </div>

    <div class="quick-menu">
        <a href="#dich-vu" class="quick-item">  
            <i class="bi bi-briefcase-fill"></i>
            <span data-lang="quick_menu_services">Dịch Vụ Của Chúng Tôi</span>
        </a>

        <a href="#so-do" class="quick-item">
            <i class="bi bi-map-fill"></i>
            <span data-lang="quick_menu_map">Sơ Đồ Tổng Quan</span>
        </a>

        <a href="#bac-si" class="quick-item">
            <i class="bi bi-person-badge-fill"></i>
            <span data-lang="quick_menu_doctors">Đội Ngũ Bác Sĩ</span>
        </a>

        <a href="#chuyen-khoa" class="quick-item">
            <i class="bi bi-shield-check"></i>
            <span data-lang="quick_menu_specialties">Chuyên Khoa Mũi Nhọn</span>
        </a>

        <a href="#goi-kham" class="quick-item">
            <i class="bi bi-heart-pulse-fill"></i>
            <span data-lang="quick_menu_packages">Gói Chăm Sóc Sức Khỏe</span>
        </a>
    </div>
</div>

<style>
    :root {
        --hospital-blue: #0f52ba;       /* Xanh biển đậm chính */
        --hospital-teal: #00a896;       /* Xanh ngọc highlight */
        --hospital-text: #1e293b;       /* Màu chữ chính */
    }

    /* 1. Toàn bộ thanh menu trong suốt (Glassmorphism) */
    #quick-access-bar {
        position: fixed;
        left: 0;
        top: 20%;
        width: 65px;
        height: auto;
        z-index: 1060;

        /* Nền siêu trong suốt, tăng độ nhòe blur để không rối mắt với nền sau */
        background: rgba(255, 255, 255, 0.4); 
        backdrop-filter: blur(25px) saturate(180%);
        -webkit-backdrop-filter: blur(25px) saturate(180%);

        border-radius: 0 24px 24px 0;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-left: none;

        padding: 24px 8px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);
        transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1), background 0.4s, box-shadow 0.4s;
    }

    /* Khi hover vào thanh lớn: giữ độ trong suốt vừa phải để đọc chữ */
    #quick-access-bar:hover {
        width: 280px;
        background: rgba(255, 255, 255, 0.75); 
        box-shadow: 0 20px 40px rgba(15, 82, 186, 0.08) !important;
    }

    /* 2. Phần tiêu đề "TIỆN ÍCH" */
    .quick-title {
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        padding-left: 14px;
    }

    /* Đồng bộ màu Icon bốn ô vuông theo màu chữ */
    .quick-title i {
        font-size: 20px;
        min-width: 35px;
        background: linear-gradient(135deg, var(--hospital-blue), var(--hospital-teal));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Sửa lỗi dính chữ bằng cách thêm margin-left hợp lý */
    .quick-title .title-text {
        display: flex;
        gap: 4px; /* Tạo khoảng cách an toàn giữa "Tiện" và "Ích" */
        margin-left: 8px; 
        opacity: 0;
        visibility: hidden;
        white-space: nowrap;
        transition: opacity 0.2s ease, visibility 0.2s;
    }
    
    .quick-title .text-main { color: var(--hospital-blue); }
    .quick-title .text-sub { color: var(--hospital-teal); }

    #quick-access-bar:hover .title-text {
        opacity: 1;
        visibility: visible;
    }

    /* 3. Phần các ô tương tác (Items) */
    .quick-menu {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .quick-item {
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 12px 14px;
        border-radius: 14px;
        color: var(--hospital-text);
        background: transparent; /* Mặc định trong suốt hoàn toàn */
        transition: all 0.25s ease;
    }

    /* Khi hover vào từng ô vuông nhỏ: tạo một lớp nền trong suốt nhẹ mờ ảo */
    .quick-item:hover {
        background: rgba(15, 82, 186, 0.07); /* Trong suốt nhẹ màu xanh */
        color: var(--hospital-blue);
        transform: translateX(4px);
    }

    .quick-item i {
        font-size: 20px;
        color: var(--hospital-blue);
        min-width: 35px;
        display: inline-flex;
        align-items: center;
        transition: transform 0.25s ease, color 0.25s;
    }
    
    .quick-item:hover i {
        transform: scale(1.08);
        color: var(--hospital-teal); /* Đổi màu icon nhẹ nhàng khi hover */
    }

    .quick-item span {
        opacity: 0;
        visibility: hidden;
        white-space: nowrap;
        margin-left: 10px;
        font-size: 14px;
        font-weight: 600;
        transition: opacity 0.3s ease, visibility 0.3s ease; 
    }

    #quick-access-bar:hover .quick-item span {
        opacity: 1;
        visibility: visible;
    }

    /* Ẩn trên các thiết bị di động */
    @media (max-width: 767.98px) {
        #quick-access-bar {
            display: none !important;
        }
    }
</style>
    
<div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-6 g-3 medical-service-container">
    <div class="col">
        <a href="<?= BASE_URL ?>/payment" class="medical-service-card h-100">
            <div class="medical-icon-circle icon-orange-pastel">
                <i class="bi bi-credit-card"></i>
            </div>
            <h3 class="medical-service-title" data-lang="srv_1">Thanh toán viện phí</h3>
        </a>
    </div>
    
    <div class="col">
        <a href="<?= BASE_URL ?>/invoice" class="medical-service-card h-100">
            <div class="medical-icon-circle icon-orange-pastel">
                <i class="bi bi-receipt"></i>
            </div>
            <h3 class="medical-service-title" data-lang="srv_2">Hóa đơn điện tử</h3>
        </a>
    </div>
    
    <div class="col">
        <a href="<?= BASE_URL ?>/record" class="medical-service-card h-100">
            <div class="medical-icon-circle icon-teal-pastel">
                <i class="bi bi-file-earmark-medical"></i>
            </div>
            <h3 class="medical-service-title" data-lang="srv_3">Hồ sơ sức khỏe</h3>
        </a>
    </div>
    
    <div class="col">
        <a href="<?= BASE_URL ?>/laboratory" class="medical-service-card h-100">
            <div class="medical-icon-circle icon-teal-pastel">
                <i class="bi bi-clipboard2-pulse"></i>
            </div>
            <h3 class="medical-service-title" data-lang="srv_4">Kết quả cận lâm sàn</h3>
        </a>
    </div>
    
    <div class="col">
        <a href="<?= BASE_URL ?>/hospitalization" class="medical-service-card h-100">
            <div class="medical-icon-circle icon-pink-pastel">
                <i class="bi bi-hospital"></i>
            </div>
            <h3 class="medical-service-title" data-lang="srv_5">Đăng ký nhập viện</h3>
        </a>
    </div>
    
    <div class="col">
    <a href="<?= BASE_URL ?>/labtest" class="medical-service-card h-100">
        <div class="medical-icon-circle icon-blue-pastel" style="background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
            <i class="bi bi-droplet-fill"></i>
        </div>
        <h3 class="medical-service-title" data-lang="srv_6">Đăng ký xét nghiệm</h3>
    </a>
</div>
        
</section>

<!-- SƠ ĐỒ KIẾN TRÚC BỆNH VIỆN -->
<section id="so-do" class="container py-5 mt-4">
    <div class="text-center mb-5 scroll-fade-in">
    <h2 class="hospital-section-title" data-lang="map_main_title">
        Sơ đồ tổng quan bệnh viện
    </h2>
    <p class="hospital-section-subtitle" data-lang="map_main_desc">
        Khám phá quy mô và sơ đồ bố trí hiện đại của Bệnh Viện Đa khoa Liên Hoa, mang đến sự tiện lợi tối đa cho bệnh nhân khi thăm khám.
    </p>
</div>
    
    <div class="row align-items-center bg-white p-lg-4 p-3 rounded-4 shadow-sm border mx-1">
        <!-- BẢN ĐỒ BOOTSTRAP -->
        <div class="col-lg-7 mb-4 mb-lg-0 pe-lg-4">
            <div class="hospital-map-bs bg-white p-3 rounded-4 shadow-sm border border-2 border-primary border-opacity-25 d-flex flex-column h-100">
                <!-- Cổng và Bãi đỗ xe -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-5">
                        <div class="p-2 text-center rounded-3 bg-light border border-2 border-secondary border-dashed text-secondary fw-bold shadow-sm transition-all hover-scale" style="font-size: 0.9rem;">
                            <i class="bi bi-p-circle me-1"></i> <span data-lang="map_parking_i1">I1 (Ô tô)</span>
                        </div>
                    </div>
                    <div class="col-2 text-center text-primary">
                        <i class="bi bi-arrow-down-circle-fill fs-3 drop-shadow"></i>
                        <div style="font-size: 0.65rem; font-weight: 800;" data-lang="map_gate">CỔNG</div>
                    </div>
                    <div class="col-5">
                        <div class="p-2 text-center rounded-3 bg-light border border-2 border-secondary border-dashed text-secondary fw-bold shadow-sm transition-all hover-scale" style="font-size: 0.9rem;">
                            <i class="bi bi-bicycle me-1"></i> <span data-lang="map_parking_i2">I2 (Xe máy)</span>
                        </div>
                    </div>
                </div>

                <!-- Sân Bệnh viện -->
                <div class="text-center text-muted mb-3 small fst-italic">
                    <i class="bi bi-cone-striped text-warning me-1"></i> <span data-lang="map_courtyard">Sân Bệnh Viện / Khu Vực Chờ / Đường Đi</span>
                </div>

                <!-- Tòa Nhà -->
                <div class="row g-3 align-items-stretch flex-grow-1">
                    <!-- Khu Tòa A & J -->
                    <div class="col-md-6 d-flex flex-column gap-3">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden flex-grow-1">
                            <div class="bg-primary bg-gradient text-white text-center py-2 fw-bold" style="letter-spacing: 1px;"><i class="bi bi-building me-2"></i><span data-lang="map_building_a">TÒA NHÀ A</span></div>
                            <div class="d-flex flex-column h-100">
                                <div class="d-flex flex-fill">
                                    <div class="w-50 p-2 text-center border-end border-bottom border-primary border-opacity-25 map-subblock block-medical d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-html="true" title="<b>Khám Bệnh & Cấp Cứu</b><br>• Phòng Cấp Cứu 24/7<br>• Phòng Khám Đa Khoa<br>• Phòng Chờ Lấy Số<br>• Phòng Tiểu Phẫu">A1</div>
                                    <div class="w-50 p-2 text-center border-bottom border-primary border-opacity-25 map-subblock block-medical d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-html="true" title="<b>Nội Khoa, Tim Mạch, Tiêu Hóa</b><br>• Phòng Khám Nội<br>• Phòng Đo Điện Tim<br>• Phòng Nội Soi<br>• Trạm Điều Dưỡng">A4</div>
                                </div>
                                <div class="p-2 text-center border-bottom border-primary border-opacity-25 map-subblock block-medical flex-fill d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-html="true" title="<b>Phụ Sản & Nhi Khoa</b><br>• Phòng Sinh Đẻ<br>• Phòng Khám Thai & Siêu Âm<br>• Phòng Khám Nhi<br>• Phòng Tiêm Chủng Nhi">A3</div>
                                <div class="p-2 text-center map-subblock block-medical flex-fill d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-html="true" title="<b>Ngoại Khoa, CTCH, Thần Kinh</b><br>• Phòng Phẫu Thuật Nội Soi<br>• Phòng Hồi Sức Tích Cực<br>• Phòng Bó Bột<br>• Phòng Điều Trị Thần Kinh">A5</div>
                            </div>
                        </div>
                        
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-auto">
                            <div class="p-3 text-center map-subblock block-service d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-html="true" title="<b>Căn Tin & Dinh Dưỡng</b>..."><i class="bi bi-cup-hot-fill me-2"></i> <span data-lang="map_canteen">Căn Tin J</span></div>
                        </div>
                    </div>

                    <!-- Khu Tòa B -->
                    <div class="col-md-6 d-flex flex-column gap-3">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden flex-grow-1">
                            <div class="bg-danger bg-gradient text-white text-center py-2 fw-bold" style="letter-spacing: 1px;"><i class="bi bi-hospital me-2"></i><span data-lang="map_building_b">TÒA NHÀ B</span></div>
                            <div class="d-flex flex-column h-100">
                                <div class="p-2 text-center border-bottom border-danger border-opacity-25 map-subblock block-admin flex-fill d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Khối Hành Chính & Nhân Sự">B1</div>
                                <div class="p-2 text-center border-bottom border-danger border-opacity-25 map-subblock block-service flex-fill d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Khoa Dược & Cấp Phát Thuốc">B2</div>
                                <div class="p-2 text-center border-bottom border-danger border-opacity-25 map-subblock block-medical flex-fill d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Cận Lâm Sàng & Xét Nghiệm">B3</div>
                                <div class="p-2 text-center border-bottom border-danger border-opacity-25 map-subblock block-special flex-fill d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Trung Tâm Ung Bướu">B4</div>
                                <div class="p-2 text-center map-subblock block-admin flex-fill d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Ban Giám Đốc & Điều Hành">B5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CHÚ THÍCH -->
        <div class="col-lg-5">
            <div class="legend-box p-4 rounded-4 bg-light border h-100 overflow-auto" style="max-height: 520px;">
                <h4 class="fw-bold mb-3 text-primary border-bottom border-2 border-primary pb-2 d-inline-block"><i class="bi bi-list-ul me-2"></i><span data-lang="map_legend_title">Chú Thích Sơ Đồ</span></h4>
                
                <ul class="list-unstyled mb-0 legend-list">
                    <li class="fw-bold text-primary mb-2 mt-2"><i class="bi bi-building me-2"></i><span data-lang="map_building_a">TÒA NHÀ A</span></li>
                    <li><span class="legend-key block-medical shadow-sm">A1</span> <span class="fw-semibold" data-lang="map_a1">Khám Bệnh & Cấp Cứu</span> <small class="text-muted ms-2" data-lang="map_a1_desc">(Tầng Trệt)</small></li>
                    <li><span class="legend-key block-medical shadow-sm">A3</span> <span class="fw-semibold" data-lang="map_a3">Phụ Sản & Nhi Khoa</span> <small class="text-muted ms-2" data-lang="map_a3_desc">(Lầu 1)</small></li>
                    
		    <li><span class="legend-key block-medical shadow-sm">A4</span> <span class="fw-semibold" data-lang="map_a4">Nội Khoa, Tim Mạch, Tiêu Hóa</span> <small class="text-muted ms-2" data-lang="map_a4_desc">(Lầu 2)</small> <span class="badge bg-danger ms-auto" style="font-size: 0.65rem;" data-lang="map_specialty">Mũi nhọn</span></li>
<li><span class="legend-key block-medical shadow-sm">A5</span> <span class="fw-semibold" data-lang="map_a5_title">Ngoại Khoa, CTCH, Thần Kinh</span> <small class="text-muted ms-2" data-lang="map_a5_desc">(Lầu 3 - 4)</small> <span class="badge bg-danger ms-auto" style="font-size: 0.65rem;" data-lang="map_specialty">Mũi nhọn</span></li>

<li class="fw-bold text-danger mb-2 mt-3"><i class="bi bi-building me-2"></i><span data-lang="map_building_b">TÒA NHÀ B</span></li>
<li><span class="legend-key block-admin shadow-sm">B1</span> <span class="fw-semibold" data-lang="map_b1_title">Khối Hành Chính & Nhân Sự</span> <small class="text-muted ms-2" data-lang="map_b1_desc">(Tầng Trệt)</small></li>
<li><span class="legend-key block-service shadow-sm">B2</span> <span class="fw-semibold" data-lang="map_b2_title">Khoa Dược & Cấp Phát Thuốc</span> <small class="text-muted ms-2" data-lang="map_b2_desc">(Lầu 1)</small></li>
<li><span class="legend-key block-medical shadow-sm">B3</span> <span class="fw-semibold" data-lang="map_b3_title">Cận Lâm Sàng & Xét Nghiệm</span> <small class="text-muted ms-2" data-lang="map_b3_desc">(Lầu 2 - 3)</small></li>
<li><span class="legend-key block-special shadow-sm">B4</span> <span class="fw-semibold" data-lang="map_b4_title">Trung Tâm Ung Bướu</span> <small class="text-muted ms-2" data-lang="map_b4_desc">(Lầu 4)</small> <span class="badge bg-danger ms-auto" style="font-size: 0.65rem;" data-lang="map_specialty">Mũi nhọn</span></li>
<li><span class="legend-key block-admin shadow-sm">B5</span> <span class="fw-semibold" data-lang="map_b5_title">Ban Giám Đốc & Điều Hành</span> <small class="text-muted ms-2" data-lang="map_b5_desc">(Lầu 5)</small></li>

<li class="fw-bold text-secondary mb-2 mt-3"><i class="bi bi-geo-alt me-2"></i><span data-lang="map_other_areas">KHU VỰC KHÁC</span></li>
<li><span class="legend-key block-parking shadow-sm">I</span> <span class="fw-semibold" data-lang="map_i_title">Bãi Đỗ Xe</span> <span data-lang="map_parking_detail">(I1: Ô tô, I2: Xe máy)</span></li>
<li><span class="legend-key block-service shadow-sm">J</span> <span class="fw-semibold" data-lang="map_canteen">Căn Tin & Dinh Dưỡng</span></li>	
			
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
/* Hospital Map Styles (Bootstrap Version) */
.hospital-map-bs {
    min-height: 520px;
}

.map-block {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 1.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.map-subblock {
    font-weight: 800;
    font-size: 1.2rem;
    transition: all 0.2s ease;
    cursor: pointer;
    color: inherit;
}
.map-subblock:hover { filter: brightness(0.9); transform: translateY(-1px); }

.border-dashed { border-style: dashed !important; }
.hover-scale { transition: transform 0.2s ease; cursor: pointer; }
.hover-scale:hover { transform: scale(1.03); }
.drop-shadow { filter: drop-shadow(0px 3px 3px rgba(0,0,0,0.2)); }

/* Block Types */
.block-medical { background-color: #e0f2fe; color: #0369a1; }
.block-medical:hover { background-color: #0ea5e9; color: white; }

.block-special { background-color: #fee2e2; color: #b91c1c; }
.block-special:hover { background-color: #ef4444; color: white; }

.block-admin { background-color: #f1f5f9; color: #334155; }
.block-admin:hover { background-color: #64748b; color: white; }

.block-service { background-color: #fef3c7; color: #b45309; }
.block-service:hover { background-color: #f59e0b; color: white; }

.block-parking { background-color: #f3f4f6; color: #4b5563; }
.block-parking:hover { background-color: #9ca3af; color: white; }

/* Legend Styles */
.legend-list li { display: flex; align-items: center; margin-bottom: 10px; font-size: 0.9rem; color: #4b5563; }
.legend-key { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-weight: 800; margin-right: 12px; flex-shrink: 0; font-size: 0.9rem; cursor: default; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>

<!-- ĐỘI NGŨ BÁC SĨ -->
<section id="bac-si" class="doctor-team-section">
    <div class="container">
        <div class="text-center mb-5 scroll-fade-in">
            <h2 class="hospital-section-title" data-lang="doc_title">Đội ngũ bác sĩ chuyên gia</h2>
            <p class="hospital-section-subtitle" data-lang="doc_subtitle">Gặp gỡ các bác sĩ chuyên khoa phụ trách giàu kinh nghiệm của Bệnh Viện Liên Hoa, luôn tận tụy vì sức khỏe cộng đồng.</p>
        </div>
        
        <div class="position-relative">
            <div class="swiper doctorSwiper px-2">
                <div class="swiper-wrapper py-3">
                    <?php if (!empty($doctors)): ?>
                        <?php foreach ($doctors as $doctor): 
                            $dlDept = ''; $dlName = ''; $dlDesc = '';
                            if (strpos($doctor['ho_ten'], 'Nguyễn Văn An') !== false) {
                                $dlDept = 'data-lang="doc_dept1"';
                                $dlName = 'data-lang="doc_name1"';
                                $dlDesc = 'data-lang="doc_desc1"';
                            } elseif (strpos($doctor['ho_ten'], 'Trần Thanh Bình') !== false) {
                                $dlDept = 'data-lang="doc_dept2"';
                                $dlName = 'data-lang="doc_name2"';
                                $dlDesc = 'data-lang="doc_desc2"';
                            } elseif (strpos($doctor['ho_ten'], 'Lê Minh Tâm') !== false) {
                                $dlDept = 'data-lang="doc_dept_3"';
                                $dlName = 'data-lang="doc_name_3"';
                                $dlDesc = 'data-lang="doc_desc3"';
                            } elseif (strpos($doctor['ho_ten'], 'Phạm Quang Khải') !== false) {
                                $dlDept = 'data-lang="doc_dept4"';
                                $dlName = 'data-lang="doc_name4"';
                                $dlDesc = 'data-lang="doc_desc4"';
                            } elseif ((isset($doctor['id']) && $doctor['id'] == 5) || strpos($doctor['ho_ten'], 'Lê Quang Hải') !== false) {
                                $dlDept = 'data-lang="doc_dept5"';
                                $dlName = 'data-lang="doc_name5"';
                                $dlDesc = 'data-lang="doc_desc5"';
                            } elseif ((isset($doctor['id']) && $doctor['id'] == 6) || strpos($doctor['ho_ten'], 'Nguyễn Thị Trang') !== false) {
                                $dlDept = 'data-lang="doc_dept6"';
                                $dlName = 'data-lang="doc_name6"';
                                $dlDesc = 'data-lang="doc_desc6"';
                            }
                        ?>
                            <div class="swiper-slide">
                                <div class="doctor-card-modern h-100">
                                    <div class="doctor-img-wrap">
                                        <img src="<?= BASE_URL ?>/public/uploads/doctors/<?= !empty($doctor['hinh_anh']) ? htmlspecialchars($doctor['hinh_anh']) : 'default-doctor.png' ?>" 
                                             onerror="this.src='<?= BASE_URL ?>/assets/images/<?= !empty($doctor['hinh_anh']) ? htmlspecialchars($doctor['hinh_anh']) : 'default-doctor.png' ?>'; this.onerror=null;"
                                             alt="<?= htmlspecialchars($doctor['ho_ten']) ?>">
                                    </div>
                                    <div class="doctor-card-body d-flex flex-column">
                                        <span class="doctor-badge" <?= $dlDept ?>><?= htmlspecialchars($doctor['chuyen_khoa'] ?? 'Đa Khoa') ?></span>
                                        <h3 class="doctor-name" <?= $dlName ?>>BS. <?= htmlspecialchars($doctor['ho_ten']) ?></h3>
                                        <div class="doctor-desc flex-grow-1" <?= $dlDesc ?>><?= !empty($doctor['tieu_su']) ? htmlspecialchars($doctor['tieu_su']) : 'Chuyên gia giàu kinh nghiệm của Bệnh Viện Liên Hoa, luôn tận tụy vì sức khỏe cộng đồng.' ?></div>
                                        <a href="<?= BASE_URL ?>/doctor/detail/<?= $doctor['id'] ?>" class="doctor-card-link mt-auto"><span data-lang="btn_detail">Xem chi tiết</span> <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center w-100 text-muted">Hệ thống đang cập nhật danh sách bác sĩ.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Custom Navigation Arrows -->
            <div class="swiper-button-prev doctor-swiper-nav custom-swiper-nav shadow-sm"></div>
            <div class="swiper-button-next doctor-swiper-nav custom-swiper-nav shadow-sm"></div>
        </div>

        <style>
        .doctorSwiper { padding-left: 10px; padding-right: 10px; padding-bottom: 20px; }
        .doctorSwiper .swiper-slide { height: auto; }
        .doctor-swiper-nav.custom-swiper-nav { top: 316px !important; margin-top: 0 !important; transform: translateY(-50%); }
        .doctor-swiper-nav.swiper-button-prev { left: 0; margin-left: -20px; }
        .doctor-swiper-nav.swiper-button-next { right: 0; margin-right: -20px; }
        @media (max-width: 1200px) {
            .doctor-swiper-nav.swiper-button-prev { margin-left: 0; }
            .doctor-swiper-nav.swiper-button-next { margin-right: 0; }
        }
        </style>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var doctorSwiper = new Swiper(".doctorSwiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: ".doctor-swiper-nav.swiper-button-next",
                    prevEl: ".doctor-swiper-nav.swiper-button-prev",
                },
                breakpoints: {
                    768: { slidesPerView: 2, spaceBetween: 20 },
                    992: { slidesPerView: 3, spaceBetween: 25 },
                    1200: { slidesPerView: 4, spaceBetween: 30 },
                },
            });
        });
        </script>
    </div>
</section>

<!-- CHUYÊN KHOA MŨI NHỌN (HOAN MY STYLE) -->
<section id="chuyen-khoa" class="specialty-section py-5 bg-light">
    <div class="container">
        <div class="specialty-header text-center mb-5 scroll-fade-in">
            <h2 class="hospital-section-title" data-lang="spec_title">Chuyên khoa mũi nhọn</h2>
            <p data-lang="spec_subtitle" class="hospital-section-subtitle">Bệnh Viện Liên Hoa cung cấp một loạt chuyên khoa và dịch vụ y tế đa dạng, kết hợp kinh nghiệm y tế với công nghệ tiên tiến để cung cấp sự chăm sóc cao nhất cho bệnh nhân.</p>
        </div>

        <!-- Custom Tabs Navigation -->
        <ul class="nav nav-pills justify-content-center mb-5 custom-spec-tabs" id="specialtyTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 py-2" id="san-tab" data-bs-toggle="tab" data-bs-target="#san" type="button" role="tab" data-lang="spec_san">Sản Phụ Khoa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 mx-3" id="tim-tab" data-bs-toggle="tab" data-bs-target="#tim" type="button" role="tab" data-lang="spec_1">Trung tâm Tim Mạch</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2" id="tieuhoa-tab" data-bs-toggle="tab" data-bs-target="#tieuhoa" type="button" role="tab" data-lang="spec_2">Khoa Tiêu hóa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 mx-3" id="chanthuong-tab" data-bs-toggle="tab" data-bs-target="#chanthuong" type="button" role="tab" data-lang="spec_chanthuong">Chấn thương chỉnh hình</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2" id="thankinh-tab" data-bs-toggle="tab" data-bs-target="#thankinh" type="button" role="tab" data-lang="spec_thankinh">Thần kinh</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 mx-3" id="ungbuou-tab" data-bs-toggle="tab" data-bs-target="#ungbuou" type="button" role="tab" data-lang="spec_ungbuou">Ung Bướu</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2" id="ngoai-tab" data-bs-toggle="tab" data-bs-target="#ngoai" type="button" role="tab" data-lang="spec_ngoai">Ngoại Tổng Quát</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 mx-3" id="nhi-tab" data-bs-toggle="tab" data-bs-target="#nhi" type="button" role="tab" data-lang="spec_nhi">Khoa Nhi</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="specialtyTabContent">
            <!-- Sản Phụ Khoa -->
            <div class="tab-pane fade show active" id="san" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/san_phu_khoa_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_san_title">Sản Phụ Khoa</div>
                            <div class="hm-subtitle" data-lang="spec_san_subtitle">Chăm sóc thai sản toàn diện: thai kỳ an toàn, sinh con và hậu sản</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_san_desc">Đội ngũ Sản khoa mang đến chăm sóc tận tâm, chuyên môn suốt thai kỳ, chuyển dạ và hậu sản. Với theo dõi hiện đại và kế hoạch cá nhân hóa, chúng tôi đảm bảo mẹ tròn con vuông.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>

            <!-- Tim Mạch -->
            <div class="tab-pane fade" id="tim" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/tim_mach_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_tim_title">Trung tâm Tim mạch</div>
                            <div class="hm-subtitle" data-lang="spec_tim_subtitle">Công nghệ chẩn đoán và điều trị bệnh lý tim mạch tiên tiến</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_tim_desc">Quy tụ đội ngũ chuyên gia đầu ngành, cung cấp dịch vụ chẩn đoán, điều trị nội khoa và can thiệp ngoại khoa các bệnh lý tim mạch toàn diện, chuẩn quốc tế.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>

            <!-- Tiêu Hóa -->
            <div class="tab-pane fade" id="tieuhoa" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/tieu_hoa_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_tieuhoa_title">Khoa Tiêu Hóa</div>
                            <div class="hm-subtitle" data-lang="spec_tieuhoa_subtitle">Chăm sóc hệ tiêu hóa khỏe mạnh an toàn</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_tieuhoa_desc">Chuyên tầm soát, chẩn đoán và điều trị các bệnh lý ống tiêu hóa, gan, mật, tụy. Chúng tôi tự hào mang đến trải nghiệm khám chữa bệnh nhẹ nhàng, an toàn với các phương pháp nội soi tiên tiến.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>

            <!-- Chấn thương chỉnh hình -->
            <div class="tab-pane fade" id="chanthuong" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/chanthuong_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_chanthuong_title">Chấn thương chỉnh hình</div>
                            <div class="hm-subtitle" data-lang="spec_chanthuong_subtitle">Chăm sóc toàn diện hệ cơ xương khớp</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_chanthuong_desc">Chuyên tầm soát, chẩn đoán và điều trị các bệnh lý về cơ, xương, khớp. Mang lại khả năng vận động và chất lượng cuộc sống tốt nhất cho bệnh nhân với công nghệ điều trị và phẫu thuật hiện đại.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>

            <!-- Thần kinh -->
            <div class="tab-pane fade" id="thankinh" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/thankinh_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_thankinh_title">Thần kinh</div>
                            <div class="hm-subtitle" data-lang="spec_thankinh_subtitle">Chẩn đoán và điều trị chuyên sâu các bệnh lý thần kinh</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_thankinh_desc">Quy tụ các chuyên gia giàu kinh nghiệm trong lĩnh vực thần kinh, cung cấp các giải pháp tối ưu từ chẩn đoán đến điều trị nội và ngoại khoa các bệnh lý não, tủy sống và dây thần kinh.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>

            <!-- Ung bướu -->
            <div class="tab-pane fade" id="ungbuou" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/ungbuou_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_ungbuou_title">Ung Bướu</div>
                            <div class="hm-subtitle" data-lang="spec_ungbuou_subtitle">Đồng hành cùng bệnh nhân trong cuộc chiến chống ung thư</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_ungbuou_desc">Cung cấp các dịch vụ tầm soát, chẩn đoán sớm và phác đồ điều trị ung thư đa mô thức tiên tiến. Với sự chăm sóc tận tình, chúng tôi luôn sát cánh đem lại hy vọng cho bệnh nhân.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>

            <!-- Ngoại Tổng Quát -->
            <div class="tab-pane fade" id="ngoai" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/ngoai_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_ngoai_title">Khoa Ngoại Tổng Quát</div>
                            <div class="hm-subtitle" data-lang="spec_ngoai_subtitle">Phẫu thuật điều trị an toàn, phục hồi nhanh chóng</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_ngoai_desc">Chuyên thực hiện các phẫu thuật từ tiểu phẫu đến đại phẫu với kỹ thuật ít xâm lấn, đảm bảo an toàn tối đa và giúp bệnh nhân phục hồi sức khỏe nhanh chóng.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>

            <!-- Khoa Nhi -->
            <div class="tab-pane fade" id="nhi" role="tabpanel" tabindex="0">
                <div class="hoan-my-card">
                    <div class="col-md-6 hm-image-side" style="background-image: url('<?= BASE_URL ?>/assets/images/nhi_friendly.png');">
                        <div class="hm-gradient-overlay">
                            <div class="hm-title" data-lang="spec_nhi_title">Khoa Nhi</div>
                            <div class="hm-subtitle" data-lang="spec_nhi_subtitle">Chăm sóc sức khỏe toàn diện cho mầm non tương lai</div>
                        </div>
                    </div>
                    <div class="col-md-6 hm-text-side">
                        <div class="hm-desc" data-lang="spec_nhi_desc">Đội ngũ y bác sĩ nhi khoa tận tâm, yêu trẻ, chuyên chẩn đoán và điều trị các bệnh lý trẻ em với môi trường thân thiện, giúp các bé không sợ hãi khi khám bệnh.</div>
                        <a href="<?= BASE_URL ?>/booking" class="hm-link-btn"><i class="bi bi-chat-dots me-2"></i> <span data-lang="btn_contact">Liên hệ</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Thiết kế Hoàn Mỹ CSS */
.hoan-my-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    display: flex;
    flex-wrap: wrap;
    background: #fff;
    min-height: 450px;
}
.hm-image-side {
    position: relative;
    min-height: 450px;
    background-size: cover;
    background-position: center;
}
.hm-gradient-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 55%;
    background: linear-gradient(to top, rgba(13, 92, 117, 0.95), transparent);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 35px;
    color: white;
}
.hm-text-side {
    padding: 60px 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.hm-link-btn {
    background-color: #0d5c75;
    color: white;
    padding: 12px 35px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    align-self: flex-start;
    margin-top: 35px;
    transition: all 0.3sease;
    font-size: 1.1rem;
}
.hm-link-btn:hover { background-color: #0a4a5e; color: white; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(13,92,117,0.4); }
.hm-title { font-size: 2.5rem; font-weight: 700; margin-bottom: 12px; }
.hm-subtitle { font-size: 1.15rem; opacity: 0.95; line-height: 1.4; }
.hm-desc { font-size: 1.15rem; color: #555; line-height: 1.8; }

/* Custom Tabs */
.custom-spec-tabs .nav-link { color: #555; font-weight: 600; border: 2px solid transparent; font-size: 1.1rem; background-color: #f8f9fa; }
.custom-spec-tabs .nav-link.active { background-color: #0d5c75; color: white; box-shadow: 0 4px 10px rgba(13,92,117,0.3); }

@media (max-width: 768px) {
    .hm-image-side { min-height: 300px; }
    .hm-text-side { padding: 30px 20px; }
    .hm-title { font-size: 2rem; }
    .custom-spec-tabs .nav-link { margin-bottom: 10px; width: 100%; text-align: center; }
    .custom-spec-tabs .mx-3 { margin-left: 0 !important; margin-right: 0 !important; }
}
</style>

<!-- Thêm thư viện Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<!-- GÓI KHÁM NỔI BẬT -->
<section id="goi-kham" class="promo-section position-relative">
    <div class="container position-relative">
        <div class="text-center mb-5 scroll-fade-in">
            <h2 class="hospital-section-title" data-lang="pkg_title">Gói chăm sóc sức khỏe</h2>
            <p class="hospital-section-subtitle" data-lang="pkg_subtitle">Lựa chọn chăm sóc sức khỏe thông minh hơn với các gói dịch vụ giá trị tuyệt vời của Bệnh Viện Liên Hoa.</p>
        </div>
        
        <div class="position-relative">
            <!-- Swiper Container -->
            <div class="swiper packageSwiper px-2">
                <div class="swiper-wrapper py-3">
                    <?php if (!empty($packages)): ?>
                        <?php foreach ($packages as $pkg): ?>
                            <div class="swiper-slide">
                                <div class="promo-card h-100">
                                    <div class="promo-img-wrap">
                                        <!-- Hiển thị ảnh thực tế nếu có, nếu lỗi dùng ảnh mặc định Unsplash -->
                                        <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($pkg['hinh_anh'] ?? 'default_pkg.jpg') ?>" 
                                             onerror="this.src='https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80'" 
                                             alt="<?= htmlspecialchars($pkg['ten_goi']) ?>">
                                    </div>
                                    <div class="promo-card-body d-flex flex-column">
                                        <span class="promo-badge-hospital"><i class="bi bi-hospital me-1"></i><span data-lang="badge_hospital">Bệnh Viện Liên Hoa</span></span>
                                        <h3 class="promo-title mb-2" data-translate-text="true"><?= htmlspecialchars($pkg['ten_goi']) ?></h3>
                                        <div class="fw-bold fs-5 text-primary mb-2"><?= number_format($pkg['gia_tien'], 0, ',', '.') ?> VNĐ</div>
                                        <div class="promo-desc mb-4" data-translate-text="true" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($pkg['mo_ta']) ?></div>
                                        <a href="<?= BASE_URL ?>/package/detail/<?= $pkg['id'] ?>" class="promo-card-link mt-auto"><span data-lang="btn_more">Xem thêm</span> <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center w-100 text-muted">Chưa có gói khám nào.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Custom Navigation Arrows -->
            <div class="swiper-button-prev package-swiper-nav custom-swiper-nav shadow-sm"></div>
            <div class="swiper-button-next package-swiper-nav custom-swiper-nav shadow-sm"></div>
        </div>
    </div>
</section>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" onload="this.media='all'"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<style>
/* Swiper package styling */
.packageSwiper {
    padding-left: 10px;
    padding-right: 10px;
    padding-bottom: 20px;
}
.packageSwiper .swiper-slide {
    height: auto; /* Ensures all slides stretch to match the tallest one */
}
.promo-card {
    height: 100%;
}
/* Custom Navigation Arrows for Swiper */
.custom-swiper-nav {
    width: 50px;
    height: 50px;
    background-color: white;
    border-radius: 50%;
    color: var(--primary-color) !important;
    border: 1px solid #eef2f5;
    transition: all 0.3s ease;
}
.custom-swiper-nav:hover {
    background-color: var(--primary-color);
    color: white !important;
    transform: scale(1.1);
}
.custom-swiper-nav::after {
    font-size: 1.2rem !important;
    font-weight: 900;
}
/* Position arrows relative to section, centered exactly at the image boundary */
.package-swiper-nav.custom-swiper-nav {
    top: 266px !important;
    margin-top: 0 !important;
    transform: translateY(-50%);
}
.package-swiper-nav.swiper-button-prev {
    left: 0;
    margin-left: -20px;
}
.package-swiper-nav.swiper-button-next {
    right: 0;
    margin-right: -20px;
}
@media (max-width: 1200px) {
    .package-swiper-nav.swiper-button-prev { margin-left: 0; }
    .package-swiper-nav.swiper-button-next { margin-right: 0; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper(".packageSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 25,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });
});
</script>

<!-- MODALS CHI TIẾT CHUYÊN KHOA -->

<!-- 1. Modal Tim Mạch -->
<div class="modal fade" id="modalTimMach" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow" style="border-radius: 20px; overflow: hidden;">
      <div class="modal-header bg-primary text-white p-4">
        <h5 class="modal-title fw-bold">Trung tâm Tim mạch</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p><strong>Giới thiệu:</strong> Trung tâm Tim mạch Bệnh viện Liên Hoa quy tụ đội ngũ chuyên gia đầu ngành, cung cấp dịch vụ chẩn đoán, điều trị nội khoa và can thiệp ngoại khoa các bệnh lý tim mạch toàn diện, chuẩn quốc tế.</p>
        
        <h6 class="text-primary mt-3 mb-2 fw-bold">Dịch vụ chuyên trị:</h6>
        <ul class="list-group list-group-flush mb-3">
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Khám và điều trị cao huyết áp, mỡ máu, suy tim.</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Tầm soát bệnh lý mạch vành, nhồi máu cơ tim.</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Điều trị rối loạn nhịp tim.</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Tư vấn và can thiệp tim mạch ít xâm lấn.</li>
        </ul>
        
        <div class="alert alert-info border-0 mt-3" style="border-radius: 12px;">
          <strong><i class="bi bi-star-fill text-warning me-2"></i>Trang thiết bị nổi bật:</strong> Hệ thống máy chụp mạch máu xóa nền (DSA), Máy siêu âm tim 4D Doppler màu, Máy Holter theo dõi huyết áp và nhịp tim 24h.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 2. Modal Tiêu Hoá -->
<div class="modal fade" id="modalTieuHoa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow" style="border-radius: 20px; overflow: hidden;">
      <div class="modal-header bg-primary text-white p-4">
        <h5 class="modal-title fw-bold">Khoa Tiêu hóa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p><strong>Giới thiệu:</strong> Khoa Tiêu hóa chuyên tầm soát, chẩn đoán và điều trị các bệnh lý ống tiêu hóa, gan, mật, tụy. Chúng tôi tự hào mang đến trải nghiệm khám chữa bệnh nhẹ nhàng, an toàn với các phương pháp nội soi tiên tiến.</p>
        
        <h6 class="text-primary mt-3 mb-2 fw-bold">Dịch vụ chuyên trị:</h6>
        <ul class="list-group list-group-flush mb-3">
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Nội soi dạ dày, đại tràng không đau (nội soi tiền mê).</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Tầm soát ung thư đường tiêu hóa (Dạ dày, đại trực tràng).</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Xét nghiệm vi khuẩn HP (Helicobacter pylori) qua hơi thở.</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Điều trị viêm loét dạ dày, trào ngược dạ dày thực quản (GERD), viêm gan B/C.</li>
        </ul>
        
        <div class="alert alert-info border-0 mt-3" style="border-radius: 12px;">
          <strong><i class="bi bi-star-fill text-warning me-2"></i>Trang thiết bị nổi bật:</strong> Hệ thống nội soi ống mềm độ phân giải cao phóng đại dải tần hẹp (NBI), Máy siêu âm gan đàn hồi.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 3. Modal Phụ Sản -->
<div class="modal fade" id="modalPhuSan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow" style="border-radius: 20px; overflow: hidden;">
      <div class="modal-header bg-primary text-white p-4">
        <h5 class="modal-title fw-bold">Khoa Phụ sản</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p><strong>Giới thiệu:</strong> Khoa Phụ sản Bệnh viện Liên Hoa là người bạn đồng hành tin cậy của chị em phụ nữ. Chúng tôi cung cấp dịch vụ chăm sóc sức khỏe sinh sản toàn diện từ khi mang thai, sinh nở đến các vấn đề phụ khoa chuyên sâu.</p>
        
        <h6 class="text-primary mt-3 mb-2 fw-bold">Dịch vụ chuyên trị:</h6>
        <ul class="list-group list-group-flush mb-3">
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Khám thai định kỳ, siêu âm dị tật thai nhi.</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Dịch vụ Thai sản trọn gói (Sinh thường, sinh mổ không đau).</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Tầm soát ung thư cổ tử cung (Xét nghiệm Pap/HPV), ung thư vú.</li>
          <li class="list-group-item bg-transparent border-0 py-1"><i class="bi bi-check-circle-fill text-success me-2"></i> Khám và điều trị các bệnh lý viêm nhiễm phụ khoa, rối loạn nội tiết.</li>
        </ul>
        
        <div class="alert alert-info border-0 mt-3" style="border-radius: 12px;">
          <strong><i class="bi bi-star-fill text-warning me-2"></i>Trang thiết bị nổi bật:</strong> Máy siêu âm thai 5D thế hệ mới, Hệ thống phòng sanh gia đình tiện nghi, lồng ấp dưỡng nhi hiện đại.
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
<?php require_once APP_DIR . '/views/layouts/header.php'; ?>



<style>

    :root {

        --glass-bg: rgba(255, 255, 255, 0.95);

        --chart-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

    }

    body { background-color: #f8fafc; }

   

    .revenue-card {

        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

        border: none !important;

        background: var(--glass-bg);

    }

    .revenue-card:hover {

        transform: translateY(-8px);

        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;

    }

   

    .chart-container-card {

        background: white;

        border-radius: 24px;

        box-shadow: var(--chart-shadow);

        border: none;

    }



    .icon-box {

        width: 56px;

        height: 56px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 16px;

    }



    /* Hiệu ứng gradient cho tiêu đề */

    .text-gradient {

        background: linear-gradient(90deg, #10b981, #3b82f6);

        -webkit-background-clip: text;

        -webkit-text-fill-color: transparent;

    }

</style>



<div class="container py-5 min-vh-100">

    <!-- Header Section -->

    <div class="row mb-5 align-items-center">

        <div class="col-md-7">

            <h1 class="fw-extrabold display-6 mb-1">

                <span class="text-gradient"><i class="bi bi-graph-up-arrow me-2"></i>Báo Cáo Doanh Thu</span>

            </h1>

            <p class="text-muted fs-5 fw-light">Hệ thống phân tích tài chính bệnh viện thời gian thực.</p>

        </div>

        <div class="col-md-5 text-md-end">

            <button onclick="window.print()" class="btn btn-white shadow-sm border rounded-pill px-4 me-2">

                <i class="bi bi-printer me-2"></i>In báo cáo

            </button>

            <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-dark rounded-pill px-4 shadow-lg">

                <i class="bi bi-grid-fill me-2"></i>Bảng điều khiển

            </a>

        </div>

    </div>



    <!-- Stats Grid -->

    <div class="row g-4 mb-5">



        <div class="col-lg-6">

            <div class="card revenue-card shadow-sm rounded-4 p-4 border-start border-success border-5">

                <div class="d-flex align-items-center">

                    <div class="icon-box bg-success bg-opacity-10 text-success me-3">

                        <i class="bi bi-currency-exchange fs-3"></i>

                    </div>

                    <div>

                        <p class="text-uppercase small fw-bold text-muted mb-1">Doanh thu 2026</p>

                        <h2 class="fw-bold mb-0">

                            <?= number_format($yearlyRevenue ?? 0, 0, ',', '.') ?> <small class="fs-6 fw-normal">VNĐ</small>

                        </h2>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- Chart Section -->

    <div class="card chart-container-card p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-0">Biểu đồ tăng trưởng chi tiết</h4>

                <span class="text-muted small">Đơn vị tính: Triệu VNĐ</span>

            </div>

            <div class="dropdown">

                <button class="btn btn-light btn-sm rounded-pill px-3 border" type="button">

                    Dữ liệu: Năm 2026 <i class="bi bi-chevron-down ms-1"></i>

                </button>

            </div>

        </div>

        <div style="position: relative; height:450px; width:100%">

            <canvas id="revenueLineChart"></canvas>

        </div>

    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        const chartData = <?php echo json_encode($chartData); ?>;

        const ctx = document.getElementById('revenueLineChart').getContext('2d');



        // Tạo Gradient màu cho các đường

        const createGradient = (color) => {

            const grad = ctx.createLinearGradient(0, 0, 0, 400);

            grad.addColorStop(0, color.replace('1)', '0.3)'));

            grad.addColorStop(1, color.replace('1)', '0)'));

            return grad;

        };



        const config = {
    type: 'line',
    data: {
        labels: ['T.1','T.2','T.3','T.4','T.5','T.6','T.7','T.8','T.9','T.10','T.11','T.12'],
        datasets: [
            {
                label: 'Gói khám',
                data: Object.values(chartData.goi_kham),
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.15)',
                fill: true,
                tension: 0.55,
                cubicInterpolationMode: 'monotone',
                borderWidth: 4,
                pointRadius: 2,
                pointHoverRadius: 8
            },
            {
                label: 'Viện phí',   // 🔴 ĐƯỜNG ĐỎ
                data: Object.values(chartData.vien_phi),
                borderColor: '#f43f5e',
                backgroundColor: 'rgba(244, 63, 94, 0.15)',
                fill: true,
                tension: 0.55,
                cubicInterpolationMode: 'monotone',
                borderWidth: 4,
                pointRadius: 2,
                pointHoverRadius: 8
            }
        ]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        // 🔥 HIỆU ỨNG VẼ TỪ T.1 → T.12
        animation: {
            duration: 2200,
            easing: 'easeInOutQuart',
            delay: (context) => {
                if (context.type !== 'data') return 0;
                return context.dataIndex * 120;
            }
        },

        interaction: {
            mode: 'index',
            intersect: false,
        },

        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: { size: 14, weight: '600' }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                padding: 15,
                cornerRadius: 12,
                callbacks: {
                    label: function(context) {
                        return ` ${context.dataset.label}: ${context.parsed.y.toLocaleString('vi-VN')} ₫`;
                    }
                }
            }
        },

        scales: {
            x: {
                grid: { display: false },
                ticks: { color: '#64748b', font: { size: 12, weight: '500' } }
            },
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' },
                border: { display: false },
                ticks: {
                    color: '#64748b',
                    callback: v => v >= 1000000 ? (v / 1000000) + ' Tr' : v.toLocaleString()
                }
            }
        }
    }
};


        new Chart(ctx, config);

    });

</script>



<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
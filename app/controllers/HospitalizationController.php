<?php

class HospitalizationController extends BaseController
{
    /** @var HospitalizationModel */
    private HospitalizationModel $model;

    public function __construct()
    {
        $this->model = new HospitalizationModel();

        // Yêu cầu đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }
    }

    /**
     * Hiển thị form đăng ký nhập viện
     * @return void
     */
    public function index(): void
    {
        require_once APP_DIR . '/views/hospitalization/index.php';
    }

    /**
     * Xử lý lưu thông tin đăng ký nhập viện
     * @return void
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Làm sạch và lấy dữ liệu
            $raw_room_type = $_POST['room_type'] ?? '';
            $tong_tien = 800000;
            if ($raw_room_type === 'Phòng dịch vụ') {
                $tong_tien = 1200000;
            } elseif ($raw_room_type === 'Phòng VIP') {
                $tong_tien = 2500000;
            }
            $room_type = filter_var($raw_room_type, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'patient_name'   => filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_SPECIAL_CHARS),
                'phone'          => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS),
                'cccd'           => filter_input(INPUT_POST, 'cccd', FILTER_SANITIZE_SPECIAL_CHARS),
                'patient_id'     => filter_input(INPUT_POST, 'patient_id', FILTER_SANITIZE_SPECIAL_CHARS),
                'department'     => filter_input(INPUT_POST, 'department', FILTER_SANITIZE_SPECIAL_CHARS),
                'reason'         => filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_SPECIAL_CHARS),
                'admission_date' => filter_input(INPUT_POST, 'admission_date', FILTER_SANITIZE_SPECIAL_CHARS),
                'room_type'      => $room_type,
                'tong_tien'      => $tong_tien
            ];

            // Kiểm tra các trường bắt buộc
            if (empty($data['patient_name']) || empty($data['phone']) || empty($data['department']) || empty($data['admission_date'])) {
                echo "<script>
                        alert('Vui lòng điền đầy đủ các trường bắt buộc!');
                        window.history.back();
                      </script>";
                return;
            }

            // Gọi Model để lưu
            $hospitalizationId = $this->model->create($data);
            if ($hospitalizationId) {
                // Chuyển hướng sang trang hóa đơn nhập viện
                header("Location: " . BASE_URL . "/hospitalization/success/" . $hospitalizationId);
                exit;
            } else {
                echo "<script>
                        alert('Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau!');
                        window.history.back();
                      </script>";
            }
        } else {
            header("Location: " . BASE_URL . "/hospitalization");
            exit;
        }
    }
    /**
     * Hiển thị kết quả đăng ký nhập viện thành công
     */
    public function success($id): void
    {
        $hospitalization = $this->model->find($id);

        if (!$hospitalization) {
            header("Location: " . BASE_URL . "/");
            exit;
        }

        require_once APP_DIR . '/views/hospitalization/success.php';
    }
}

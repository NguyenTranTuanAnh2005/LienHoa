<?php

class LabtestController extends BaseController
{
    /** @var LabTestModel */
    private LabTestModel $model;

    public function __construct()
    {
        $this->model = new LabTestModel();

        // Yêu cầu đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }
    }

    /**
     * Hiển thị form đăng ký xét nghiệm
     * @return void
     */
    public function index(): void
    {
        require_once APP_DIR . '/views/lab_test/index.php';
    }

    /**
     * Xử lý lưu thông tin đăng ký xét nghiệm
     * @return void
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Làm sạch và lấy dữ liệu
            $test_type = filter_input(INPUT_POST, 'test_type', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $tong_tien = 300000;
            switch ($test_type) {
                case 'Xét nghiệm sinh hóa':
                    $tong_tien = 500000;
                    break;
                case 'Xét nghiệm miễn dịch':
                    $tong_tien = 600000;
                    break;
                case 'Xét nghiệm vi sinh & ký sinh trùng':
                    $tong_tien = 400000;
                    break;
                case 'Xét nghiệm sinh học phân tử':
                    $tong_tien = 1000000;
                    break;
                case 'Xét nghiệm giải phẫu bệnh':
                    $tong_tien = 1500000;
                    break;
                case 'Xét nghiệm huyết học':
                default:
                    $tong_tien = 300000;
                    break;
            }

            $data = [
                'user_id'      => $_SESSION['user_id'],
                'patient_name' => filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_SPECIAL_CHARS),
                'phone'        => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS),
                'cccd'         => filter_input(INPUT_POST, 'cccd', FILTER_SANITIZE_SPECIAL_CHARS),
                'patient_id'   => filter_input(INPUT_POST, 'patient_id', FILTER_SANITIZE_SPECIAL_CHARS),
                'gender'       => filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS),
                'test_type'    => $test_type,
                'sample_date'  => filter_input(INPUT_POST, 'sample_date', FILTER_SANITIZE_SPECIAL_CHARS),
                'notes'        => filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS),
                'tong_tien'    => $tong_tien
            ];

            // Kiểm tra các trường bắt buộc
            if (empty($data['patient_name']) || empty($data['phone']) || empty($data['test_type']) || empty($data['sample_date'])) {
                echo "<script>
                        alert('Vui lòng điền đầy đủ các trường bắt buộc!');
                        window.history.back();
                      </script>";
                return;
            }

            // Gọi Model để lưu
            $labTestId = $this->model->create($data);
            if ($labTestId) {
                // Chuyển hướng sang trang hóa đơn (success page)
                header("Location: " . BASE_URL . "/labtest/success/" . $labTestId);
                exit;
            } else {
                echo "<script>
                        alert('Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau!');
                        window.history.back();
                      </script>";
            }
        } else {
            header("Location: " . BASE_URL . "/labtest");
            exit;
        }
    }

    /**
     * Hiển thị kết quả đăng ký xét nghiệm thành công
     */
    public function success($id): void
    {
        $labTest = $this->model->find($id);

        if (!$labTest) {
            header("Location: " . BASE_URL . "/");
            exit;
        }

        require_once APP_DIR . '/views/lab_test/success.php';
    }
}

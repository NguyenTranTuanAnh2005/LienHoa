<?php

class ProfileController extends BaseController
{
    private $patientModel;
    private $bookingModel;
    private $userModel;
    private $hospitalizationModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
        $this->bookingModel = new BookingModel();
        $this->userModel = new UserModel();
        require_once APP_DIR . '/models/HospitalizationModel.php';
        $this->hospitalizationModel = new HospitalizationModel();
    }

    /**
     * Hiển thị giao diện Hồ sơ y tế
     */
    public function index()
    {
        $this->requireLogin();

        // Admin có trang dashboard riêng, không dùng chung profile
        if ($_SESSION['user_role'] === 'admin') {
            header("Location: " . BASE_URL . "/admin/dashboard");
            exit;
        }

        $patientId = $_SESSION['patient_id'] ?? null;
        
        // Fallback: Nếu session bị thiếu patient_id (do lỗi cũ), tải lại từ CSDL
        if (!$patientId && isset($_SESSION['user_id'])) {
            $user = $this->userModel->getById($_SESSION['user_id']);
            if ($user && !empty($user['patient_id'])) {
                $_SESSION['patient_id'] = $user['patient_id'];
                $patientId = $user['patient_id'];
            }
        }

        $patient = null;
        $bookings = [];

        if ($patientId) {
            $patient = $this->patientModel->getById($patientId);
            if ($patient) {
                // Lấy lịch sử từ dat_lich
                $bookings = $this->bookingModel->findByPatientCodeOrPhone($patient['patient_code'], $patient['phone']);
                
                // Lấy lịch sử từ hospitalizations
                $hospitalizations = $this->hospitalizationModel->findByPatientCode($patient['patient_code']);
                
                // Chuyển đổi hospitalizations thành format giống bookings để gộp chung hiển thị
                foreach ($hospitalizations as $h) {
                    // Chuyển đổi trạng thái tiếng Anh của hospitalizations sang giống dat_lich
                    $trang_thai = 'dang_cho';
                    if (isset($h['status'])) {
                        if (strtolower($h['status']) === 'approved') $trang_thai = 'da_xac_nhan';
                        if (strtolower($h['status']) === 'completed') $trang_thai = 'hoan_thanh';
                        if (strtolower($h['status']) === 'rejected' || strtolower($h['status']) === 'cancelled') $trang_thai = 'da_huy';
                    }

                    $bookings[] = [
                        'is_hospitalization' => true,
                        'department' => $h['department'],
                        'room_type' => $h['room_type'] ?? '',
                        'ngay_hen' => $h['admission_date'],
                        'trang_thai' => $trang_thai,
                        'ten_bac_si' => ''
                    ];
                }

                // Lấy lịch sử từ lab_tests
                require_once APP_DIR . '/models/LabTestModel.php';
                $labTestModel = new LabTestModel();
                $labTests = $labTestModel->findByPatientCodeOrPhone($patient['patient_code'], $patient['phone']);
                
                foreach ($labTests as $l) {
                    $trang_thai = 'dang_cho';
                    if (isset($l['status'])) {
                        if (strtolower($l['status']) === 'approved') $trang_thai = 'da_xac_nhan';
                        if (strtolower($l['status']) === 'completed') $trang_thai = 'hoan_thanh';
                        if (strtolower($l['status']) === 'rejected' || strtolower($l['status']) === 'cancelled') $trang_thai = 'da_huy';
                    }

                    $bookings[] = [
                        'is_lab_test' => true,
                        'test_type' => $l['test_type'],
                        'ngay_hen' => $l['sample_date'],
                        'trang_thai' => $trang_thai,
                        'ten_bac_si' => ''
                    ];
                }

                // Sắp xếp lại toàn bộ bookings theo ngay_hen giảm dần
                usort($bookings, function($a, $b) {
                    return strtotime($b['ngay_hen']) - strtotime($a['ngay_hen']);
                });

                // Fetch invoice history
                require_once APP_DIR . '/models/PaymentModel.php';
                $paymentModel = new PaymentModel();
                $historicalInvoice = $paymentModel->getInvoiceData($patient['patient_code'], 'Đã thanh toán');
                if ($historicalInvoice && empty($historicalInvoice['services'])) {
                    $historicalInvoice = null;
                }
            }
        }

        $viewFile = APP_DIR . '/views/profile/index.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy giao diện.";
        }
    }

    /**
     * API Cập nhật thông tin cá nhân
     * POST /profile/update
     */
    public function update()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Phương thức không hợp lệ']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST;
        }

        $patientId = $_SESSION['patient_id'] ?? null;
        
        // Fallback: Nếu session bị thiếu patient_id
        if (!$patientId && isset($_SESSION['user_id'])) {
            $user = $this->userModel->getById($_SESSION['user_id']);
            if ($user && !empty($user['patient_id'])) {
                $_SESSION['patient_id'] = $user['patient_id'];
                $patientId = $user['patient_id'];
            }
        }

        if (!$patientId) {
            echo json_encode(['success' => false, 'error' => 'Không tìm thấy hồ sơ bệnh nhân.']);
            return;
        }

        $updateData = [
            'full_name' => trim($input['full_name'] ?? ''),
            'gender'    => trim($input['gender'] ?? ''),
            'birthday'  => trim($input['birthday'] ?? ''),
            'phone'     => trim($input['phone'] ?? ''),
            'email'     => trim($input['email'] ?? ''),
            'address'   => trim($input['address'] ?? ''),
            'cccd'      => trim($input['cccd'] ?? '')
        ];

        // Validate basic
        if (empty($updateData['full_name']) || empty($updateData['phone'])) {
            echo json_encode(['success' => false, 'error' => 'Họ tên và số điện thoại không được để trống']);
            return;
        }

        // Cập nhật bảng patients
        $success = $this->patientModel->update($patientId, $updateData);

        if ($success) {
            // Cập nhật lại session full_name
            $_SESSION['full_name'] = $updateData['full_name'];
            
            // Nếu có password mới, cập nhật bảng users
            if (!empty($input['password'])) {
                $userId = $_SESSION['user_id'];
                $newPassword = password_hash($input['password'], PASSWORD_DEFAULT);
                
                $db = (new Database())->getConnection();
                $stmt = $db->prepare("UPDATE users SET password = :pwd WHERE id = :id");
                $stmt->execute([':pwd' => $newPassword, ':id' => $userId]);
            }

            echo json_encode(['success' => true, 'message' => 'Cập nhật hồ sơ thành công']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Có lỗi xảy ra hoặc không có thay đổi nào.']);
        }
    }

    /**
     * API Đánh dấu đã đọc OTP
     * GET /profile/clearOtpDot
     */
    public function clearOtpDot()
    {
        $this->requireLogin();
        if (isset($_SESSION)) {
            foreach ($_SESSION as $key => $value) {
                if (strpos($key, 'payment_otp_') === 0 && is_array($value)) {
                    $_SESSION[$key]['is_read'] = true;
                }
            }
        }
        echo json_encode(['success' => true]);
    }
}

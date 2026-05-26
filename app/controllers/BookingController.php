<?php

class BookingController
{
    private $bookingModel;

    public function __construct()
    {
        // Khởi tạo model dùng chung
        $this->bookingModel = new BookingModel();

        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }
    }

    /**
     * View 1: Form đặt lịch theo chuyên khoa
     */
    public function index(): void
    {
        $current_patient = $this->getCurrentPatient();
        require_once APP_DIR . '/views/booking/index.php';
    }

    /**
     * View 2: Form đăng ký gói khám
     */
    public function package(): void
    {
        // Lấy và validate package_id từ URL
        $package_id = filter_input(INPUT_GET, 'package_id', FILTER_VALIDATE_INT);

        if (!$package_id || $package_id <= 0) {
            header("Location: " . BASE_URL . "/packages");
            exit;
        }

        // Lấy thông tin gói khám
        $packageModel = new PackageModel();
        $selected_package = $packageModel->find($package_id);

        if (!$selected_package) {
            header("Location: " . BASE_URL . "/packages");
            exit;
        }

        $current_patient = $this->getCurrentPatient();

        require_once APP_DIR . '/views/booking/package_form.php';
    }

    /**
     * Xử lý lưu booking (Dùng chung cho cả khám chuyên khoa và gói khám)
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/booking");
            exit;
        }

        // 1. Thu thập và làm sạch dữ liệu
        $data = [
            'patient_name'     => trim(filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_SPECIAL_CHARS)),
            'phone'            => trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS)),
            'email'            => trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)),
            'dob'              => $_POST['dob'] ?? null,
            'gender'           => $_POST['gender'] ?? 'Nam',
            'address'          => trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS)),
            'cccd'             => trim(filter_input(INPUT_POST, 'cccd', FILTER_SANITIZE_SPECIAL_CHARS)) ?: null,
            'hospital'         => $_POST['hospital'] ?? 'Bệnh Viện Liên Hoa',
            'appointment_date' => $_POST['appointment_date'] ?? null,
            'notes'            => trim(filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS)),

            // Dữ liệu tùy chọn (có thể null nếu đặt lịch theo chuyên khoa/gói)
            'specialty'        => $_POST['specialty'] ?? null,
            'package_id'       => filter_input(INPUT_POST, 'package_id', FILTER_VALIDATE_INT) ?: null,
            'package_name'     => trim(filter_input(INPUT_POST, 'package_name', FILTER_SANITIZE_SPECIAL_CHARS)) ?: null,
            'doctor_id'        => filter_input(INPUT_POST, 'doctor_id', FILTER_VALIDATE_INT) ?: null,
        ];

        $currentPatient = $this->getCurrentPatient();
        if ($currentPatient && isset($currentPatient['patient_code'])) {
            $data['patient_code'] = $currentPatient['patient_code'];
        } else {
            // Tạo trực tiếp bệnh nhân mới để cấp mã theo chuẩn BN202600x
            require_once APP_DIR . '/models/PatientModel.php';
            $patientModel = new PatientModel();
            $newPatientId = $patientModel->create([
                'full_name' => $data['patient_name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'birthday' => $data['dob'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'cccd' => $data['cccd']
            ]);
            if ($newPatientId) {
                $newPatient = $patientModel->getById($newPatientId);
                $data['patient_code'] = $newPatient['patient_code'];
            } else {
                $data['patient_code'] = 'LH-' . date('ymd') . strtoupper(substr(uniqid(), -4)); // fallback
            }
        }

        // 3. Kiểm tra dữ liệu bắt buộc (Validation)
        if (empty($data['patient_name']) || empty($data['phone']) || empty($data['appointment_date'])) {
            $this->backWithError("Vui lòng điền đủ thông tin bắt buộc!");
            return;
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->backWithError("Email không hợp lệ!");
            return;
        }

        if (!preg_match('/^[0-9]{9,11}$/', $data['phone'])) {
            $this->backWithError("Số điện thoại không hợp lệ!");
            return;
        }

        // 4. Thực hiện lưu vào database
        $bookingId = $this->bookingModel->create($data);

        if ($bookingId) {
            // Chuyển hướng sang trang thông báo thành công kèm theo ID vừa tạo
            header("Location: " . BASE_URL . "/booking/success/" . $bookingId);
            exit;
        } else {
            $this->backWithError("Có lỗi xảy ra trong quá trình lưu, vui lòng thử lại!");
        }
    }

    /**
     * View 3: Hiển thị kết quả đặt lịch thành công
     */
    public function success($id): void
    {
        $booking = $this->bookingModel->find($id);

        if (!$booking) {
            header("Location: " . BASE_URL . "/");
            exit;
        }

        if (!empty($booking['ten_goi_kham']) || !empty($booking['id_goi_kham'])) {
            require_once APP_DIR . '/views/booking/package_success.php';
        } else {
            require_once APP_DIR . '/views/booking/success.php';
        }
    }

    /**
     * Helper: Quay lại trang trước kèm thông báo lỗi
     */
    private function backWithError(string $message): void
    {
        echo "<script>alert('$message'); window.history.back();</script>";
        exit;
    }

    /**
     * Helper: Lấy thông tin bệnh nhân từ session
     */
    private function getCurrentPatient()
    {
        if (isset($_SESSION['patient_id'])) {
            $patientModel = new PatientModel();
            return $patientModel->getById($_SESSION['patient_id']);
        }
        return null;
    }
}
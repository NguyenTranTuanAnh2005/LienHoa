<?php

class InvoiceController
{
    public function index()
    {
        $code = '';
        $searched = false;
        $data = null;

        $code = trim($_GET['code'] ?? '');
        if (!empty($code)) {
            $searched = true;
            $model = new InvoiceModel();
            $data = $model->findByCode($code);
        }

        $viewFile = APP_DIR . '/views/invoice/index.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view {$viewFile}";
        }
    }

    public function view()
    {
        $code = isset($_GET['code']) ? trim($_GET['code']) : '';
        $action = isset($_GET['action']) ? trim($_GET['action']) : 'view';
        $isHistory = isset($_GET['history']) && $_GET['history'] == 1;
        
        if (empty($code)) {
            die("Không tìm thấy mã hóa đơn.");
        }

        $model = new InvoiceModel();
        $data = $model->findByCode($code, $isHistory);

        if (!$data) {
            die("Hóa đơn không tồn tại.");
        }

        $viewFile = APP_DIR . '/views/invoice/view.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view {$viewFile}";
        }
    }
    public function sendotp()
    {
        header('Content-Type: application/json');
        $code = trim($_POST['code'] ?? '');
        
        if (empty($code)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã tra cứu.']);
            return;
        }

        $model = new InvoiceModel();
        $record = $model->findByCode($code);
        
        if (!$record) {
            echo json_encode(['success' => false, 'message' => 'Mã tra cứu không tồn tại.']);
            return;
        }

        require_once APP_DIR . '/models/BookingModel.php';
        $bookingModel = new BookingModel();
        $otp = rand(100000, 999999);
        $bookingModel->updateOTP($code, $otp);

        echo json_encode([
            'success' => true,
            'message' => 'Mã OTP đã được gửi.',
            'otp_debug' => $otp
        ]);
    }

    public function verify()
    {
        header('Content-Type: application/json');
        $code = trim($_POST['code'] ?? '');
        $otp = trim($_POST['otp'] ?? '');

        if (empty($code) || empty($otp)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã OTP.']);
            return;
        }

        require_once APP_DIR . '/models/BookingModel.php';
        $bookingModel = new BookingModel();
        
        if (!$bookingModel->verifyOTP($code, $otp)) {
            echo json_encode(['success' => false, 'message' => 'OTP không chính xác hoặc đã hết hạn.']);
            return;
        }

        echo json_encode(['success' => true]);
    }
}

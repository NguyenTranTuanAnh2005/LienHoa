<?php

class RecordController
{
    public function index()
    {
        $code = '';
        $searched = false;
        $data = null;

        $code = trim($_GET['code'] ?? '');
        if (!empty($code)) {
            $searched = true;
            $model = new RecordModel();
            $data = $model->findByPid($code);
        }

        $viewFile = APP_DIR . '/views/record/index.php';
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
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã y tế (PID).']);
            return;
        }

        $model = new RecordModel();
        $record = $model->findByPid($code);
        
        if (!$record) {
            echo json_encode(['success' => false, 'message' => 'Mã bệnh nhân không tồn tại hoặc không có hồ sơ.']);
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

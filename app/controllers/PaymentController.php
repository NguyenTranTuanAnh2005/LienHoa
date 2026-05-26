<?php

class PaymentController
{
    private $bookingModel;
    private $paymentModel;

    public function __construct()
    {
        require_once APP_DIR . '/models/BookingModel.php';
        require_once APP_DIR . '/models/PaymentModel.php';

        $this->bookingModel = new BookingModel();
        $this->paymentModel = new PaymentModel();
    }

    /**
     * Render view
     */
    private function render($viewName, $data = [])
    {
        if (is_array($data)) {
            extract($data);
        }

        $viewFile = APP_DIR . '/views/' . $viewName . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("Lỗi: Không tìm thấy file view tại {$viewFile}");
        }
    }

    /**
     * Trang thanh toán viện phí
     */
    public function index()
    {
        $code = trim($_GET['code'] ?? '');
        $searched = false;
        $data = null;
        $invoiceData = null;
        $successMsg = '';

        // Sau xác thực OTP redirect về
        if (!empty($code)) {
            $searched = true;
            $data = $this->paymentModel->findByCode($code);
            if ($data) {
                $invoiceData = $this->paymentModel->getInvoiceData($code);
            }
        }

        // Sau thanh toán thành công
        if (
            isset($_GET['success'])
            && $_GET['success'] == 1
        ) {

            $successMsg =
                "Thanh toán hệ thống nội bộ thành công!";

            $code = $_GET['code'] ?? '';

            if (!empty($code)) {
                $searched = true;
                $data = $this->paymentModel->findByCode($code);
                if ($data) {
                    $invoiceData = $this->paymentModel->getInvoiceData($code);
                }
            }
        }

        $this->render('payment/index', [
            'code' => $code,
            'searched' => $searched,
            'data' => $data,
            'invoiceData' => $invoiceData,
            'successMsg' => $successMsg
        ]);
    }

    /**
     * API gửi OTP
     * URL: /payment/sendotp
     */
    public function sendotp()
    {
        header('Content-Type: application/json');

        $code = trim($_POST['code'] ?? '');

        if (empty($code)) {

            echo json_encode([
                'success' => false,
                'message' =>
                    'Vui lòng nhập mã bệnh nhân.'
            ]);

            return;
        }

        // Kiểm tra bệnh nhân
        $patient = $this->paymentModel->findByCode($code);

        if (!$patient) {

            echo json_encode([
                'success' => false,
                'message' =>
                    'Mã bệnh nhân không tồn tại.'
            ]);

            return;
        }

        // Sinh OTP
        $otp = rand(100000, 999999);

        // Update DB
        $updated =
            $this->bookingModel
            ->updateOTP($code, $otp);

        if ($updated) {

            echo json_encode([
                'success' => true,
                'message' =>
                    'Mã OTP đã được gửi.',
                'otp_debug' => $otp
            ]);

        } else {

            echo json_encode([
                'success' => false,
                'message' =>
                    'Không thể tạo OTP.'
            ]);
        }
    }

    /**
     * API verify OTP
     * URL: /payment/verify
     */
    public function verify()
    {
        header('Content-Type: application/json');

        $code = trim($_POST['code'] ?? '');
        $otp = trim($_POST['otp'] ?? '');

        if (
            empty($code)
            || empty($otp)
        ) {

            echo json_encode([
                'success' => false,
                'message' =>
                    'Vui lòng nhập OTP.'
            ]);

            return;
        }

        $valid =
            $this->bookingModel
            ->verifyOTP(
                $code,
                $otp
            );

        if (!$valid) {

            echo json_encode([
                'success' => false,
                'message' =>
                    'OTP không chính xác hoặc đã hết hạn.'
            ]);

            return;
        }

        echo json_encode([
            'success' => true
        ]);
    }

    /**
     * Chọn ngân hàng
     */
    public function select_bank()
    {
        $code = $_GET['code'] ?? '';

        if (empty($code)) {
            header(
                'Location: ' .
                BASE_URL .
                '/payment'
            );
            exit;
        }

        $data =
            $this->paymentModel
            ->findByCode($code);

        if (
            !$data
            || ($data['trang_thai'] ?? '')
            === 'Đã thanh toán'
        ) {

            header(
                'Location: ' .
                BASE_URL .
                '/payment'
            );

            exit;
        }

        $this->render(
            'payment/select_bank',
            [
                'data' => $data,
                'code' => $code
            ]
        );
    }

    /**
     * Xử lý chọn hình thức thanh toán
     */
    public function process()
    {
        $code = $_GET['code'] ?? '';
        $method = $_GET['payment_method'] ?? '';

        if (empty($code) || empty($method)) {
            header('Location: ' . BASE_URL . '/payment');
            exit;
        }

        if ($method === 'counter') {
            header('Location: ' . BASE_URL . '/payment/checkout?code=' . urlencode($code) . '&method=Tại quầy');
            exit;
        }

        header('Location: ' . BASE_URL . '/payment/select_bank?code=' . urlencode($code));
        exit;
    }

    /**
     * Checkout QR
     */
    public function checkout()
    {
        $code = $_GET['code'] ?? '';
        $method = $_GET['method'] ?? 'vcb';

        if (empty($code)) {
            header(
                'Location: ' .
                BASE_URL .
                '/payment'
            );
            exit;
        }

        $data =
            $this->paymentModel
            ->findByCode($code);

        if (!$data) {
            header(
                'Location: ' .
                BASE_URL .
                '/payment'
            );
            exit;
        }

        $this->render(
            'payment/checkout',
            [
                'data' => $data,
                'code' => $code,
                'method' => $method
            ]
        );
    }

    /**
     * Thanh toán thành công
     */
    public function success()
    {
        $code = $_GET['code'] ?? '';

        if (!empty($code)) {
            // Get unpaid items first to display on the invoice specifically for this transaction
            $invoiceData = $this->paymentModel->getInvoiceData($code, 'Chưa thanh toán');
            if ($invoiceData && !empty($invoiceData['services'])) {
                $sessKey = 'invoice_' . $code . '_' . time();
                $_SESSION[$sessKey] = $invoiceData;
                $this->paymentModel->markAsPaid($code);
                header('Location: ' . BASE_URL . '/payment/invoice?code=' . urlencode($code) . '&sk=' . urlencode($sessKey));
                exit;
            }

            $this->paymentModel->markAsPaid($code);

            // Chuyển hướng sang trang hóa đơn
            header('Location: ' . BASE_URL . '/payment/invoice?code=' . urlencode($code));
            exit;
        }

        header('Location: ' . BASE_URL . '/payment');
        exit;
    }

    /**
     * Hiển thị hóa đơn thanh toán
     */
    public function invoice()
    {
        $code = $_GET['code'] ?? '';
        $sk = $_GET['sk'] ?? '';

        if (empty($code)) {
            header('Location: ' . BASE_URL . '/payment');
            exit;
        }
        
        $invoiceData = null;
        if (!empty($sk) && isset($_SESSION[$sk])) {
            $invoiceData = $_SESSION[$sk];
        } else {
            $invoiceData = $this->paymentModel->getInvoiceData($code, 'ALL');
        }

        if (!$invoiceData) {
            die("Không tìm thấy thông tin hóa đơn.");
        }

        $this->render('payment/invoice', [
            'code' => $code,
            'invoiceData' => $invoiceData
        ]);
    }
}
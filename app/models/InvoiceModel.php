<?php

class InvoiceModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByCode($code, $isHistory = false)
    {
        // Sử dụng chung logic tính toán hóa đơn với PaymentModel
        require_once APP_DIR . '/models/PaymentModel.php';
        $paymentModel = new PaymentModel();
        
        // Lấy dữ liệu hóa đơn hiện tại (chưa thanh toán để đồng bộ nếu đã thanh toán thì về 0)
        // Nếu là history (xem lịch sử), ta lấy 'Đã thanh toán'
        $status = $isHistory ? 'Đã thanh toán' : 'Chưa thanh toán';
        $invoiceData = $paymentModel->getInvoiceData($code, $status);
        
        if (!$invoiceData) {
            return null;
        }

        // Định dạng dữ liệu trả về cho InvoiceController
        return [
            'ma_tra_cuu' => $code,
            'so_hoa_don' => $invoiceData['patient_info']['ma_hoa_don'],
            'ngay_lap' => $invoiceData['patient_info']['ngay_lap'],
            'tong_tien' => $invoiceData['tong_tien'],
            'services' => $invoiceData['services']
        ];
    }
}

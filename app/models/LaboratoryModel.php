<?php

class LaboratoryModel
{
    private $conn;

    public function __construct()
    {
        // Khởi tạo database giống NoticeModel để fix lỗi vàng
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByCode($code)
    {
        if (!$this->conn) return null;

        $query = "SELECT cls.*, p.full_name AS ten_benh_nhan 
                  FROM can_lam_sang cls
                  LEFT JOIN patients p ON cls.ma_benh_nhan = p.patient_code
                  WHERE cls.ma_benh_nhan = :code LIMIT 1";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("LaboratoryModel Error: " . $e->getMessage());
            return null;
        }
    }
}
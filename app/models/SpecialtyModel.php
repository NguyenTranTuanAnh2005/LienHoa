<?php

class SpecialtyModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllSpecialties()
    {
        // Đồng bộ với cấu trúc bảng chuyen_khoa (chỉ có id, ten_khoa, mo_ta)
        $query = "SELECT id, ten_khoa, mo_ta FROM chuyen_khoa";
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getSpecialtyById($id)
    {
        // Thay vì slug không có trong db, ta tìm bằng ID
        $query = "SELECT id, ten_khoa, mo_ta FROM chuyen_khoa WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getDoctorsBySpecialty($id_chuyen_khoa)
    {
        // Join 2 bảng bac_si và chuyen_khoa theo đúng schema SQL hiện tại
        $query = "SELECT 
                    b.id, 
                    b.ho_ten, 
                    c.ten_khoa, 
                    b.hinh_anh 
                  FROM bac_si b
                  INNER JOIN chuyen_khoa c ON b.id_chuyen_khoa = c.id
                  WHERE b.id_chuyen_khoa = :id_chuyen_khoa";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_chuyen_khoa', $id_chuyen_khoa, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}

<?php

class DoctorManagementModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        try {
            $this->conn->exec("ALTER TABLE bac_si ADD COLUMN lich_lam_viec TEXT");
        } catch (PDOException $e) {
            // Cột đã tồn tại
        }
    }

    /**
     * Lấy danh sách tất cả bác sĩ với thông tin chuyên khoa
     */
    public function getAll($search = '')
    {
        $query = "SELECT 
                    bac_si.id,
                    bac_si.ho_ten, 
                    bac_si.id_chuyen_khoa,
                    chuyen_khoa.ten_khoa as chuyen_khoa, 
                    bac_si.hinh_anh,
                    bac_si.tieu_su,
                    bac_si.lich_lam_viec
                  FROM bac_si 
                  LEFT JOIN chuyen_khoa ON bac_si.id_chuyen_khoa = chuyen_khoa.id
                  WHERE 1=1";
        
        $params = [];

        if (!empty($search)) {
            $query .= " AND (bac_si.ho_ten LIKE :search OR chuyen_khoa.ten_khoa LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        $query .= " ORDER BY bac_si.ho_ten ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông tin chi tiết một bác sĩ
     */
    public function getById($id)
    {
        $query = "SELECT 
                    bac_si.*,
                    chuyen_khoa.ten_khoa as chuyen_khoa,
                    chuyen_khoa.mo_ta as mo_ta_khoa
                  FROM bac_si 
                  LEFT JOIN chuyen_khoa ON bac_si.id_chuyen_khoa = chuyen_khoa.id 
                  WHERE bac_si.id = :id 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Thêm bác sĩ mới
     */
    public function create($data)
    {
        $query = "INSERT INTO bac_si (ho_ten, id_chuyen_khoa, hinh_anh, tieu_su, lich_lam_viec) 
                  VALUES (:ho_ten, :id_chuyen_khoa, :hinh_anh, :tieu_su, :lich_lam_viec)";
        
        $stmt = $this->conn->prepare($query);
        
        $params = [
            ':ho_ten' => $data['ho_ten'] ?? '',
            ':id_chuyen_khoa' => $data['id_chuyen_khoa'] ?? null,
            ':hinh_anh' => $data['hinh_anh'] ?? null,
            ':tieu_su' => $data['tieu_su'] ?? '',
            ':lich_lam_viec' => $data['lich_lam_viec'] ?? null
        ];

        if ($stmt->execute($params)) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    /**
     * Cập nhật thông tin bác sĩ
     */
    public function update($id, $data)
    {
        $fields = [];
        $params = [':id' => $id];
        
        $allowedFields = ['ho_ten', 'id_chuyen_khoa', 'hinh_anh', 'tieu_su', 'lich_lam_viec'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            return false;
        }

        $query = "UPDATE bac_si SET " . implode(", ", $fields) . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Xóa bác sĩ
     */
    public function delete($id)
    {
        $query = "DELETE FROM bac_si WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Lấy danh sách chuyên khoa (để sử dụng trong form dropdown)
     */
    public function getSpecialties()
    {
        $query = "SELECT id, ten_khoa, mo_ta FROM chuyen_khoa ORDER BY ten_khoa ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
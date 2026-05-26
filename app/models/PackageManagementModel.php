<?php

class PackageManagementModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Lấy danh sách tất cả gói khám
     */
    public function getAll($search = '')
    {
        $query = "SELECT id, ten_goi, mo_ta, gia_tien 
                  FROM goi_kham 
                  WHERE 1=1";
        
        $params = [];

        if (!empty($search)) {
            $query .= " AND (ten_goi LIKE :search OR mo_ta LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        $query .= " ORDER BY ten_goi ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông tin chi tiết một gói khám
     */
    public function getById($id)
    {
        $query = "SELECT id, ten_goi, mo_ta, gia_tien 
                  FROM goi_kham 
                  WHERE id = :id 
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
     * Thêm gói khám mới
     */
    public function create($data)
    {
        $query = "INSERT INTO goi_kham (ten_goi, mo_ta, gia_tien) 
                  VALUES (:ten_goi, :mo_ta, :gia_tien)";
        
        $stmt = $this->conn->prepare($query);
        
        $params = [
            ':ten_goi' => $data['ten_goi'] ?? '',
            ':mo_ta' => $data['mo_ta'] ?? '',
            ':gia_tien' => $data['gia_tien'] ?? 0
        ];

        if ($stmt->execute($params)) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    /**
     * Cập nhật thông tin gói khám
     */
    public function update($id, $data)
    {
        $fields = [];
        $params = [':id' => $id];
        
        $allowedFields = ['ten_goi', 'mo_ta', 'gia_tien'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            return false;
        }

        $query = "UPDATE goi_kham SET " . implode(", ", $fields) . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Xóa gói khám
     */
    public function delete($id)
    {
        $query = "DELETE FROM goi_kham WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

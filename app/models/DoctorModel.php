<?php

class DoctorModel 
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
     * Lấy tất cả bác sĩ kèm tên chuyên khoa
     */
    public function getAll()
    {
        $query = "
            SELECT
                bac_si.*,
                chuyen_khoa.ten_khoa AS chuyen_khoa
            FROM bac_si
            LEFT JOIN chuyen_khoa
            ON bac_si.id_chuyen_khoa = chuyen_khoa.id
            ORDER BY bac_si.id ASC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm bác sĩ theo ID
     */
    public function find($id)
    {
        $query = "
            SELECT *
            FROM bac_si
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm bác sĩ mới
     */
    public function create($data)
    {
        $query = "
            INSERT INTO bac_si
            (
                ho_ten,
                id_chuyen_khoa,
                tieu_su,
                hinh_anh,
                lich_lam_viec
            )
            VALUES
            (
                :ho_ten,
                :id_chuyen_khoa,
                :tieu_su,
                :hinh_anh,
                :lich_lam_viec
            )
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':ho_ten'         => $data['ho_ten'],
            ':id_chuyen_khoa' => $data['id_chuyen_khoa'],
            ':tieu_su'        => $data['tieu_su'],
            ':hinh_anh'       => $data['hinh_anh'],
            ':lich_lam_viec'  => $data['lich_lam_viec'] ?? null
        ]);
    }

    /**
     * Cập nhật thông tin bác sĩ
     */
    public function update($id, $data)
    {
        // ĐÃ SỬA: Loại bỏ ký tự thực thể HTML '&emsp;' bị dính vào trong chuỗi truy vấn SQL
        $query = "
            UPDATE bac_si
            SET
                ho_ten = :ho_ten,
                id_chuyen_khoa = :id_chuyen_khoa,
                tieu_su = :tieu_su,
                hinh_anh = :hinh_anh,
                lich_lam_viec = :lich_lam_viec
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id'             => $id,
            ':ho_ten'         => $data['ho_ten'],
            ':id_chuyen_khoa' => $data['id_chuyen_khoa'],
            ':tieu_su'        => $data['tieu_su'],
            ':hinh_anh'       => $data['hinh_anh'],
            ':lich_lam_viec'  => $data['lich_lam_viec'] ?? null
        ]);
    }

    /**
     * Xóa bác sĩ (Có cơ chế kiểm tra ràng buộc khóa ngoại)
     */
    public function delete($id)
    {
        try {
            $query = "
                DELETE FROM bac_si
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($query);
            
            return $stmt->execute([
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            // Nếu lỗi 23000 xảy ra (Ràng buộc khóa ngoại do bác sĩ đã có lịch hẹn đặt trước)
            if ($e->getCode() == '23000') {
                return false; 
            }
            throw $e;
        }
    }
}
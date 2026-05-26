<?php

class LabTestModel
{
    /** @var PDO */
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Lưu thông tin đăng ký xét nghiệm
     * @param array $data Dữ liệu xét nghiệm
     * @return bool|int
     */
    public function create(array $data)
    {
        $query = "INSERT INTO lab_tests (
                    user_id, patient_name, phone, cccd, patient_id, test_type, sample_date, notes, tong_tien, status
                  ) VALUES (
                    :user_id, :patient_name, :phone, :cccd, :patient_id, :test_type, :sample_date, :notes, :tong_tien, 'pending'
                  )";
                  
        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':user_id'      => $data['user_id'] ?? null,
            ':patient_name' => $data['patient_name'] ?? null,
            ':phone'        => $data['phone'] ?? null,
            ':cccd'         => $data['cccd'] ?? null,
            ':patient_id'   => $data['patient_id'] ?? null,
            ':test_type'    => $data['test_type'] ?? null,
            ':sample_date'  => $data['sample_date'] ?? null,
            ':notes'        => $data['notes'] ?? null,
            ':tong_tien'    => $data['tong_tien'] ?? 300000
        ]);

        return $result ? (int)$this->conn->lastInsertId() : false;
    }

    /**
     * Lấy thông tin đơn đăng ký xét nghiệm theo ID
     */
    public function find($id): ?array
    {
        $query = "SELECT * FROM lab_tests WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }
    public function getAll(): array
    {
        $query = "SELECT * FROM lab_tests ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByPatientCodeOrPhone($code, $phone): array
    {
        $query = "SELECT * FROM lab_tests WHERE patient_id = :code1 OR user_id = :code2 OR phone = :phone ORDER BY sample_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':code1' => $code,
            ':code2' => $code,
            ':phone' => $phone
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status): bool
    {
        $query = "UPDATE lab_tests SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }
}

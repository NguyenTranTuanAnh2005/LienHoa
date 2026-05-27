<?php

class HospitalizationModel
{
    /** @var PDO */
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Lưu thông tin đăng ký nhập viện
     * @param array $data Dữ liệu nhập viện
     * @return bool
     */
    public function create(array $data)
    {
        $query = "INSERT INTO hospitalizations (
                    patient_name, phone, cccd, patient_id, gender,
                    department, reason, admission_date, room_type, tong_tien, status
                  ) VALUES (
                    :patient_name, :phone, :cccd, :patient_id, :gender,
                    :department, :reason, :admission_date, :room_type, :tong_tien, 'Waiting'
                  )";
                  
        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':patient_name'   => $data['patient_name'] ?? null,
            ':phone'          => $data['phone'] ?? null,
            ':cccd'           => $data['cccd'] ?? null,
            ':patient_id'     => $data['patient_id'] ?? null,
            ':gender'         => $data['gender'] ?? null,
            ':department'     => $data['department'] ?? null,
            ':reason'         => $data['reason'] ?? null,
            ':admission_date' => $data['admission_date'] ?? null,
            ':room_type'      => $data['room_type'] ?? null,
            ':tong_tien'      => $data['tong_tien'] ?? 800000
        ]);

        return $result ? (int)$this->conn->lastInsertId() : false;
    }

    /**
     * Lấy thông tin nhập viện theo ID
     */
    public function find($id): ?array
    {
        $query = "SELECT * FROM hospitalizations WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    /**
     * Lấy danh sách đăng ký nhập viện của một bệnh nhân
     */
    public function findByPatientCode($code): array
    {
        $query = "SELECT * FROM hospitalizations WHERE patient_id = :code ORDER BY admission_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':code' => $code]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll($search = ''): array
    {
        $query = "SELECT h.*, p.patient_code as linked_patient_code FROM hospitalizations h LEFT JOIN patients p ON h.phone = p.phone WHERE 1=1";
        
        $params = [];
        if (!empty($search)) {
            $query .= " AND (h.patient_name LIKE :search1 OR h.phone LIKE :search2 OR h.patient_id LIKE :search3 OR p.patient_code LIKE :search4)";
            $searchTerm = '%' . $search . '%';
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
            $params[':search4'] = $searchTerm;
        }

        $query .= " ORDER BY h.admission_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $query = "UPDATE hospitalizations SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }
}

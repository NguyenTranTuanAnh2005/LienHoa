<?php

class PatientModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAll($search = '')
    {
        $query = "SELECT * FROM patients WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $query .= " AND (full_name LIKE :search1 OR phone LIKE :search2 OR patient_code LIKE :search3)";
            $searchTerm = '%' . $search . '%';
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
        }

        $query .= " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM patients WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        // Tự động tạo mã bệnh nhân: BN + YYYY + số thứ tự (ví dụ BN2026001)
        $year = date('Y');
        
        // Tìm số thứ tự lớn nhất trong năm hiện tại
        $queryCode = "SELECT MAX(CAST(SUBSTRING(patient_code, 7) AS UNSIGNED)) as max_code 
                      FROM patients 
                      WHERE patient_code LIKE :prefix";
        $stmtCode = $this->conn->prepare($queryCode);
        $stmtCode->execute([':prefix' => "BN{$year}%"]);
        $result = $stmtCode->fetch(PDO::FETCH_ASSOC);
        
        $maxCode = $result['max_code'] ? (int)$result['max_code'] : 0;
        $newCode = "BN" . $year . str_pad($maxCode + 1, 3, "0", STR_PAD_LEFT);

        $query = "INSERT INTO patients (patient_code, full_name, gender, birthday, phone, address, cccd, email, diagnosis) 
                  VALUES (:patient_code, :full_name, :gender, :birthday, :phone, :address, :cccd, :email, :diagnosis)";
        
        $stmt = $this->conn->prepare($query);
        
        $params = [
            ':patient_code' => $newCode,
            ':full_name' => $data['full_name'] ?? '',
            ':gender' => $data['gender'] ?? 'Khác',
            ':birthday' => $data['birthday'] ?? null,
            ':phone' => $data['phone'] ?? '',
            ':address' => $data['address'] ?? null,
            ':cccd' => $data['cccd'] ?? null,
            ':email' => $data['email'] ?? null,
            ':diagnosis' => $data['diagnosis'] ?? null
        ];

        if ($stmt->execute($params)) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function update($id, $data)
    {
        // Chỉ cập nhật những trường được truyền vào
        $fields = [];
        $params = [':id' => $id];
        
        $allowedFields = ['full_name', 'gender', 'birthday', 'phone', 'address', 'cccd', 'status', 'diagnosis'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            return false; // Không có gì để cập nhật
        }

        $query = "UPDATE patients SET " . implode(", ", $fields) . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $query = "DELETE FROM patients WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

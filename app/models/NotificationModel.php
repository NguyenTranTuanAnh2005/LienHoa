<?php
class NotificationModel extends Database {
    public function getByPatient($patientCode) {
        $query = "SELECT * FROM notifications WHERE patient_code = :code ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':code' => $patientCode]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $query = "INSERT INTO notifications (patient_code, title, content, type) 
                  VALUES (:patient_code, :title, :content, :type)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function markRead($id) {
        $query = "UPDATE notifications SET status = 'read' WHERE id = :id";
        return $this->conn->prepare($query)->execute([':id' => $id]);
    }
}
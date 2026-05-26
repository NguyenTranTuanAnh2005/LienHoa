<?php

class RecordModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        if ($this->conn === null) {
            error_log("RecordModel Error: Không thể kết nối Database.");
        }
    }

    public function findByPid($pid)
    {
        if (!$this->conn) return null;

        $query = "SELECT * FROM ho_so_suc_khoe WHERE ma_benh_nhan = :pid";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':pid', $pid);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query Error: " . $e->getMessage());
            return null;
        }
    }
}
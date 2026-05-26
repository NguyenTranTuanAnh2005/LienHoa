<?php

class NoticeModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        if ($this->conn === null) {
            error_log("NoticeModel Error: Không thể kết nối Database.");
        }
    }

    /**
     * Lấy tất cả thông báo
     */
    public function all()
    {
        if (!$this->conn) return [];

        // BỎ "WHERE status = 1" vì bảng notices của bạn không khai báo cột này
        $query = "SELECT * FROM notices ORDER BY created_at DESC"; 
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi truy vấn NoticeModel::all : " . $e->getMessage());
            return [];
        }
    }

    /**
     * Tìm chi tiết 1 thông báo theo ID
     */
    public function find($id)
    {
        if (!$this->conn) return null;

        $query = "SELECT * FROM notices WHERE id = :id LIMIT 1";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi truy vấn NoticeModel::find : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Tạo thông báo mới
     */
    public function create(array $data)
    {
        if (!$this->conn) return false;
        $query = "INSERT INTO notices (title, slug, summary, content, image, category) 
                  VALUES (:title, :slug, :summary, :content, :image, :category)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':title' => $data['title'] ?? '',
                ':slug' => $data['slug'] ?? '',
                ':summary' => $data['summary'] ?? '',
                ':content' => $data['content'] ?? '',
                ':image' => $data['image'] ?? null,
                ':category' => $data['category'] ?? 'Thông báo chung'
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Lỗi tạo notice: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật thông báo
     */
    public function update($id, array $data)
    {
        if (!$this->conn) return false;
        $query = "UPDATE notices SET title=:title, slug=:slug, summary=:summary, content=:content, image=:image, category=:category WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':id' => $id,
                ':title' => $data['title'] ?? '',
                ':slug' => $data['slug'] ?? '',
                ':summary' => $data['summary'] ?? '',
                ':content' => $data['content'] ?? '',
                ':image' => $data['image'] ?? null,
                ':category' => $data['category'] ?? 'Thông báo chung'
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật notice: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa thông báo
     */
    public function delete($id)
    {
        if (!$this->conn) return false;
        $query = "DELETE FROM notices WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Lỗi xóa notice: " . $e->getMessage());
            return false;
        }
    }
}
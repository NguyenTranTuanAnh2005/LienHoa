<?php

class DoctorManagementController extends BaseController
{
    private $doctorModel;

    public function __construct()
    {
        $this->doctorModel = new DoctorManagementModel();
    }

    // Helper: Trả về JSON Response
    private function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Helper: Lấy dữ liệu JSON từ request body
    private function getJsonInput()
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }

    /**
     * Hiển thị giao diện Quản lý bác sĩ
     * GET /doctormanagement
     * GET /doctormanagement/index
     */
    public function index()
    {
        // Phân quyền: Chỉ admin được truy cập trang quản lý
        $this->requireRole('admin');
        
        $viewFile = APP_DIR . '/views/doctormanagement/index.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy giao diện.";
        }
    }

    /**
     * API: Lấy danh sách bác sĩ (hỗ trợ search)
     * GET /doctormanagement/apiList
     * GET /doctormanagement/apiList?search=từ_khóa
     */
    public function apiList()
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $doctors = $this->doctorModel->getAll($search);

        $this->jsonResponse([
            'success' => true,
            'data' => $doctors
        ]);
    }

    /**
     * API: Lấy thông tin chi tiết một bác sĩ
     * GET /doctormanagement/show/{id}
     */
    public function show($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID bác sĩ là bắt buộc'], 400);
        }

        $doctor = $this->doctorModel->getById($id);

        if ($doctor) {
            $this->jsonResponse([
                'success' => true,
                'data' => $doctor
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Không tìm thấy bác sĩ'
            ], 404);
        }
    }

    /**
     * API: Lấy danh sách chuyên khoa (để populate dropdown)
     * GET /doctormanagement/getSpecialties
     */
    public function getSpecialties()
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        $specialties = $this->doctorModel->getSpecialties();

        $this->jsonResponse([
            'success' => true,
            'data' => $specialties
        ]);
    }

    /**
     * API: Thêm bác sĩ mới
     * POST /doctormanagement/store
     */
    public function store()
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        $data = $this->getJsonInput();

        // Validation cơ bản
        if (empty($data['ho_ten']) || empty($data['id_chuyen_khoa'])) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Vui lòng cung cấp họ tên và chuyên khoa'
            ], 400);
        }

        $insertId = $this->doctorModel->create($data);

        if ($insertId) {
            $newDoctor = $this->doctorModel->getById($insertId);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Thêm bác sĩ thành công',
                'data' => $newDoctor
            ], 201);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Lỗi hệ thống khi thêm bác sĩ'
            ], 500);
        }
    }

    /**
     * API: Cập nhật thông tin bác sĩ
     * PUT (hoặc POST) /doctormanagement/update/{id}
     */
    public function update($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID bác sĩ là bắt buộc'], 400);
        }

        $data = $this->getJsonInput();

        if (empty($data)) {
            $this->jsonResponse(['error' => 'Không có dữ liệu cập nhật'], 400);
        }

        $updated = $this->doctorModel->update($id, $data);

        if ($updated) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Không thể cập nhật hoặc không có dữ liệu thay đổi'
            ], 400);
        }
    }

    /**
     * API: Xóa bác sĩ
     * DELETE /doctormanagement/delete/{id}
     */
    public function delete($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID bác sĩ là bắt buộc'], 400);
        }

        $doctor = $this->doctorModel->getById($id);
        if (!$doctor) {
            $this->jsonResponse(['error' => 'Không tìm thấy bác sĩ'], 404);
        }

        $deleted = $this->doctorModel->delete($id);

        if ($deleted) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Xóa bác sĩ thành công'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Lỗi hệ thống khi xóa bác sĩ'
            ], 500);
        }
    }
}
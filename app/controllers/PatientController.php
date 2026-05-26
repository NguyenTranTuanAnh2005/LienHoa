<?php

class PatientController extends BaseController
{
    private $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
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

    // Hiển thị giao diện Quản lý bệnh nhân
    // GET /patient
    // GET /patient/index
    public function index()
    {
        // Phân quyền: Chỉ admin được truy cập trang quản lý
        $this->requireRole('admin');
        
        $viewFile = APP_DIR . '/views/patient/index.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy giao diện.";
        }
    }

    // API: Lấy danh sách bệnh nhân (hỗ trợ search)
    // GET /patient/apiList
    // GET /patient/apiList?search=từ_khóa
    public function apiList()
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $patients = $this->patientModel->getAll($search);

        $this->jsonResponse([
            'success' => true,
            'data' => $patients
        ]);
    }

    // API: Lấy thông tin chi tiết một bệnh nhân
    // GET /patient/show/{id}
    public function show($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID bệnh nhân là bắt buộc'], 400);
        }

        $patient = $this->patientModel->getById($id);

        if ($patient) {
            $this->jsonResponse([
                'success' => true,
                'data' => $patient
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Không tìm thấy bệnh nhân'
            ], 404);
        }
    }

    // API: Thêm bệnh nhân mới
    // POST /patient/store
    public function store()
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        $data = $this->getJsonInput();

        // Validation cơ bản
        if (empty($data['full_name']) || empty($data['phone'])) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Vui lòng cung cấp họ tên và số điện thoại'
            ], 400);
        }

        if (empty($data['birthday'])) {
            $data['birthday'] = null;
        }

        $insertId = $this->patientModel->create($data);

        if ($insertId) {
            // Lấy lại thông tin bệnh nhân vừa tạo (để lấy mã patient_code được tự động tạo)
            $newPatient = $this->patientModel->getById($insertId);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Thêm bệnh nhân thành công',
                'data' => $newPatient
            ], 201);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Lỗi hệ thống khi thêm bệnh nhân'
            ], 500);
        }
    }

    // API: Cập nhật thông tin bệnh nhân
    // PUT (hoặc POST) /patient/update/{id}
    public function update($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID bệnh nhân là bắt buộc'], 400);
        }

        $data = $this->getJsonInput();

        if (empty($data)) {
            $this->jsonResponse(['error' => 'Không có dữ liệu cập nhật'], 400);
        }

        if (empty($data['birthday'])) {
            $data['birthday'] = null;
        }

        // Cập nhật thông tin
        $updated = $this->patientModel->update($id, $data);

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

    // API: Xóa bệnh nhân
    // DELETE /patient/delete/{id}
    public function delete($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID bệnh nhân là bắt buộc'], 400);
        }

        // Kiểm tra xem bệnh nhân có tồn tại hay không
        $patient = $this->patientModel->getById($id);
        if (!$patient) {
            $this->jsonResponse(['error' => 'Không tìm thấy bệnh nhân'], 404);
        }

        $deleted = $this->patientModel->delete($id);

        if ($deleted) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Xóa bệnh nhân thành công'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Lỗi hệ thống khi xóa bệnh nhân'
            ], 500);
        }
    }
}

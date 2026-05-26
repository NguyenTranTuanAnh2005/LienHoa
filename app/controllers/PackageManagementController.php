<?php

class PackageManagementController extends BaseController
{
    private $packageModel;

    public function __construct()
    {
        $this->packageModel = new PackageManagementModel();
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
     * Hiển thị giao diện Quản lý danh sách gói khám
     * GET /packagemanagement
     * GET /packagemanagement/index
     */
    public function index()
    {
        // Phân quyền: Chỉ admin được truy cập trang quản lý
        $this->requireRole('admin');
        
        $viewFile = APP_DIR . '/views/packagemanagement/index.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy giao diện.";
        }
    }

    /**
     * API: Lấy danh sách gói khám (hỗ trợ search)
     * GET /packagemanagement/apiList
     */
    public function apiList()
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $packages = $this->packageModel->getAll($search);

        $this->jsonResponse([
            'success' => true,
            'data' => $packages
        ]);
    }

    /**
     * API: Lấy thông tin chi tiết một gói khám
     * GET /packagemanagement/show/{id}
     */
    public function show($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID gói khám là bắt buộc'], 400);
        }

        $package = $this->packageModel->getById($id);

        if ($package) {
            $this->jsonResponse([
                'success' => true,
                'data' => $package
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Không tìm thấy gói khám'
            ], 404);
        }
    }

    /**
     * API: Thêm gói khám mới
     * POST /packagemanagement/store
     */
    public function store()
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        $data = $this->getJsonInput();

        // Validation cơ bản
        if (empty($data['ten_goi']) || empty($data['gia_tien'])) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Vui lòng cung cấp tên gói và giá tiền'
            ], 400);
        }

        $insertId = $this->packageModel->create($data);

        if ($insertId) {
            $newPackage = $this->packageModel->getById($insertId);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Thêm gói khám thành công',
                'data' => $newPackage
            ], 201);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Lỗi hệ thống khi thêm gói khám'
            ], 500);
        }
    }

    /**
     * API: Cập nhật thông tin gói khám
     * PUT (hoặc POST) /packagemanagement/update/{id}
     */
    public function update($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID gói khám là bắt buộc'], 400);
        }

        $data = $this->getJsonInput();

        if (empty($data)) {
            $this->jsonResponse(['error' => 'Không có dữ liệu cập nhật'], 400);
        }

        $updated = $this->packageModel->update($id, $data);

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
     * API: Xóa gói khám
     * DELETE /packagemanagement/delete/{id}
     */
    public function delete($id = null)
    {
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
        }

        if (!$id) {
            $this->jsonResponse(['error' => 'ID gói khám là bắt buộc'], 400);
        }

        $package = $this->packageModel->getById($id);
        if (!$package) {
            $this->jsonResponse(['error' => 'Không tìm thấy gói khám'], 404);
        }

        $deleted = $this->packageModel->delete($id);

        if ($deleted) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Xóa gói khám thành công'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Lỗi hệ thống khi xóa gói khám'
            ], 500);
        }
    }
}

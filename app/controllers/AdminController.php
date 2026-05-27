<?php

class AdminController extends BaseController
{
    private $bookingModel;
    private $doctorModel;

    /**
     * Khởi tạo Controller và nạp các Model cần thiết
     */
    public function __construct()
    {
        // Kiểm tra quyền admin ngay khi khởi tạo
        $this->requireRole('admin');

        require_once APP_DIR . '/models/BookingModel.php';
        $this->bookingModel = new BookingModel();

        require_once APP_DIR . '/models/DoctorModel.php';
        $this->doctorModel = new DoctorModel();
    }

    /**
     * Dashboard chính của Admin
     */
    public function dashboard()
    {
        require_once APP_DIR . '/views/admin/dashboard.php';
    }

    /**
     * Báo cáo doanh thu (Biểu đồ 12 tháng + Thống kê nhanh)
     * Kết hợp lấy dữ liệu doanh thu tổng hợp
     */
    public function revenue()
{
    // Lấy dữ liệu 3 đường doanh thu
    $data = $this->bookingModel->getRevenueComparison();
    
    // Lấy tổng doanh thu viện phí 2026
    $yearlyRevenue = $this->bookingModel->getTotalVienPhi2026();
    
    // Khởi tạo mảng 12 tháng: T1-T6 là 0, T7-T12 là null để biểu đồ kết thúc ở T6
    $chartData = [
        'goi_kham' => [],
        'kham_le'  => [],
        'vien_phi' => []
    ];
    for ($i = 1; $i <= 12; $i++) {
        $val = ($i <= 6) ? 0 : null;
        $chartData['goi_kham'][$i] = $val;
        $chartData['kham_le'][$i]  = $val;
        $chartData['vien_phi'][$i] = $val;
    }

    foreach ($data as $row) {
        $m = (int)$row['thang'];
        if ($m <= 6) {
            $chartData['goi_kham'][$m] = (float)$row['doanh_thu_goi'];
            $chartData['kham_le'][$m]  = (float)$row['doanh_thu_le'];
            $chartData['vien_phi'][$m] = (float)$row['doanh_thu_vien_phi'];
        }
    }

    require_once APP_DIR . '/views/admin/revenue.php';
}

    /**
     * Quản lý danh sách bác sĩ
     */
    public function doctormanagement()
    {
        $doctors = $this->doctorModel->getAll();
        require_once APP_DIR . '/views/admin/doctormanagement.php';
    }

    /**
     * Thêm mới bác sĩ
     */
    public function storeDoctor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $ho_ten = isset($_POST['ho_ten']) ? trim($_POST['ho_ten']) : '';
        $id_chuyen_khoa = isset($_POST['id_chuyen_khoa']) ? (int)$_POST['id_chuyen_khoa'] : 0;
        $tieu_su = isset($_POST['tieu_su']) ? trim($_POST['tieu_su']) : '';
        $lich_lam_viec = isset($_POST['lich_lam_viec']) ? trim($_POST['lich_lam_viec']) : null;
        
        $fileName = $this->handleImageUpload($_FILES['hinh_anh'] ?? null);

        $this->doctorModel->create([
            'ho_ten' => $ho_ten,
            'id_chuyen_khoa' => $id_chuyen_khoa,
            'tieu_su' => $tieu_su,
            'hinh_anh' => $fileName,
            'lich_lam_viec' => $lich_lam_viec
        ]);

        header("Location: " . BASE_URL . "/admin/doctormanagement");
        exit;
    }

    /**
     * Cập nhật thông tin bác sĩ
     */
    public function updateDoctor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) die("Yêu cầu không hợp lệ.");

        $doctor = $this->doctorModel->find($id);
        if (!$doctor) die("Không tìm thấy bác sĩ.");

        $ho_ten = isset($_POST['ho_ten']) ? trim($_POST['ho_ten']) : '';
        $id_chuyen_khoa = isset($_POST['id_chuyen_khoa']) ? (int)$_POST['id_chuyen_khoa'] : 0;
        $tieu_su = isset($_POST['tieu_su']) ? trim($_POST['tieu_su']) : '';
        $lich_lam_viec = isset($_POST['lich_lam_viec']) ? trim($_POST['lich_lam_viec']) : null;

        // Xử lý ảnh: Nếu có ảnh mới thì upload và xóa ảnh cũ, nếu không thì giữ ảnh cũ
        $fileName = $this->handleImageUpload($_FILES['hinh_anh'] ?? null, $doctor['hinh_anh']);

        $this->doctorModel->update($id, [
            'ho_ten' => $ho_ten,
            'id_chuyen_khoa' => $id_chuyen_khoa,
            'tieu_su' => $tieu_su,
            'hinh_anh' => $fileName,
            'lich_lam_viec' => $lich_lam_viec
        ]);

        header("Location: " . BASE_URL . "/admin/doctormanagement");
        exit;
    }

    /**
     * Xóa bác sĩ và tệp tin ảnh đi kèm
     */
    public function deleteDoctor($id)
    {
        $doctor = $this->doctorModel->find($id);
        
        if ($doctor && !empty($doctor['hinh_anh']) && $doctor['hinh_anh'] !== 'default-doctor.png') {
            $imgPath = ROOT_DIR . '/public/uploads/doctors/' . $doctor['hinh_anh'];
            if (is_file($imgPath) && file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        $result = $this->doctorModel->delete($id);
        if (!$result) {
            echo "<script>alert('Không thể xóa bác sĩ này vì đã có dữ liệu liên quan (lịch khám, v.v.)!'); window.location.href = '" . BASE_URL . "/admin/doctormanagement';</script>";
            exit;
        }
        header("Location: " . BASE_URL . "/admin/doctormanagement");
        exit;
    }

    /**
     * Danh sách đặt lịch khám (Bác sĩ/Chuyên khoa)
     */
    public function bookings()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $bookings = $this->bookingModel->getDoctorBookings($search);
        
        require_once APP_DIR . '/models/HospitalizationModel.php';
        $hospModel = new HospitalizationModel();
        $hospitalizations = $hospModel->getAll($search);
        
        foreach ($hospitalizations as $h) {
            $trang_thai = 'dang_cho';
            if (isset($h['status'])) {
                if (strtolower($h['status']) === 'approved') $trang_thai = 'da_xac_nhan';
                if (strtolower($h['status']) === 'completed') $trang_thai = 'hoan_thanh';
                if (strtolower($h['status']) === 'rejected' || strtolower($h['status']) === 'cancelled') $trang_thai = 'da_huy';
            }
            
            $bookings[] = [
                'id' => $h['id'],
                'is_hospitalization' => true,
                'patient_code' => $h['patient_id'],
                'ten_benh_nhan' => $h['patient_name'],
                'so_dien_thoai' => $h['phone'],
                'email' => '',
                'gioi_tinh' => 'N/A',
                'department' => $h['department'],
                'room_type' => $h['room_type'] ?? '',
                'ngay_hen' => $h['admission_date'],
                'trang_thai' => $trang_thai
            ];
        }
        
        usort($bookings, function($a, $b) {
            return strtotime($b['ngay_hen'] ?? 'now') - strtotime($a['ngay_hen'] ?? 'now');
        });

        require_once APP_DIR . '/views/admin/bookings.php';
    }

    /**
     * Danh sách đăng ký Gói Khám Thể Chất
     */
    public function package()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $packageBookings = $this->bookingModel->getPackageBookings($search);
        
        // Lấy thêm dữ liệu doanh thu bổ trợ cho trang quản lý gói khám (nếu cần hiển thị Card nhỏ)
        $yearlyRevenue = $this->bookingModel->getYearlyRevenue(); 
        $monthlyRevenue30Days = $this->bookingModel->getMonthlyRevenue();
        
        require_once APP_DIR . '/views/admin/packages.php';
    }

    /**
     * Cập nhật trạng thái Booking qua AJAX
     */
    public function updateBookingStatus()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $id = (int)($input['id'] ?? 0);
        $status = trim($input['status'] ?? '');
        $is_hosp = !empty($input['is_hospitalization']);

        $validStatuses = ['dang_cho', 'da_xac_nhan', 'hoan_thanh', 'da_huy'];

        if ($id <= 0 || !in_array($status, $validStatuses)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }

        if ($is_hosp) {
            require_once APP_DIR . '/models/HospitalizationModel.php';
            $hospModel = new HospitalizationModel();
            
            $hospStatus = 'Waiting';
            if ($status === 'da_xac_nhan') $hospStatus = 'Approved';
            if ($status === 'hoan_thanh') $hospStatus = 'Completed';
            if ($status === 'da_huy') $hospStatus = 'Cancelled';
            
            $success = $hospModel->updateStatus($id, $hospStatus);
        } else {
            $success = $this->bookingModel->updateStatus($id, $status);
        }
        
        echo json_encode(['success' => $success]);
    }

    /**
     * Chuyển hướng nhanh sang khu vực bệnh nhân
     */
    public function patient()
    {
        header("Location: " . BASE_URL . "/patient");
        exit;
    }

    /**
     * Xử lý upload ảnh (Hàm dùng chung)
     */
    private function handleImageUpload($file, $oldImage = null)
    {
        if (isset($file['name']) && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_DIR . '/public/uploads/doctors/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Xóa ảnh cũ nếu có (tránh xóa ảnh mặc định)
            if ($oldImage && $oldImage !== 'default-doctor.png') {
                $oldImagePath = $uploadDir . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Đặt tên file mới để tránh trùng lặp
            $fileName = time() . '_' . basename($file['name']);
            
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
                return $fileName;
            }
        }
        
        return $oldImage ?: 'default-doctor.png';
    }

    /**
     * Danh sách đăng ký Xét Nghiệm
     */
    public function labtest()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        require_once APP_DIR . '/models/LabTestModel.php';
        $labTestModel = new LabTestModel();
        $labTests = $labTestModel->getAll($search);
        
        require_once APP_DIR . '/views/admin/lab_test.php';
    }

    /**
     * Cập nhật trạng thái Lab Test qua AJAX
     */
    public function updateLabStatus()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $id = (int)($input['id'] ?? 0);
        $status = trim($input['status'] ?? '');

        $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];

        if ($id <= 0 || !in_array($status, $validStatuses)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }

        require_once APP_DIR . '/models/LabTestModel.php';
        $labTestModel = new LabTestModel();
        $success = $labTestModel->updateStatus($id, $status);
        echo json_encode(['success' => $success]);
    }

    /**
     * Quản lý thông báo
     */
    public function notices()
    {
        require_once APP_DIR . '/models/NoticeModel.php';
        $noticeModel = new NoticeModel();
        $notices = $noticeModel->all();
        require_once APP_DIR . '/views/admin/notices.php';
    }

    public function storeNotice()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        require_once APP_DIR . '/models/NoticeModel.php';
        $noticeModel = new NoticeModel();

        $title = $_POST['title'] ?? '';
        $slug = time() . '-' . substr(md5($title), 0, 5); // Simple slug
        $summary = $_POST['summary'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? 'Thông báo chung';
        
        $fileName = $this->handleNoticeImageUpload($_FILES['image'] ?? null);

        $noticeModel->create([
            'title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'content' => $content,
            'category' => $category,
            'image' => $fileName
        ]);

        header("Location: " . BASE_URL . "/admin/notices");
        exit;
    }

    public function updateNotice()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        require_once APP_DIR . '/models/NoticeModel.php';
        $noticeModel = new NoticeModel();

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) die("Yêu cầu không hợp lệ.");

        $notice = $noticeModel->find($id);
        if (!$notice) die("Không tìm thấy thông báo.");

        $title = $_POST['title'] ?? '';
        $summary = $_POST['summary'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? 'Thông báo chung';

        $fileName = $this->handleNoticeImageUpload($_FILES['image'] ?? null, $notice['image']);

        $noticeModel->update($id, [
            'title' => $title,
            'slug' => $notice['slug'],
            'summary' => $summary,
            'content' => $content,
            'category' => $category,
            'image' => $fileName
        ]);

        header("Location: " . BASE_URL . "/admin/notices");
        exit;
    }

    public function deleteNotice($id)
    {
        require_once APP_DIR . '/models/NoticeModel.php';
        $noticeModel = new NoticeModel();

        $notice = $noticeModel->find($id);
        
        if ($notice && !empty($notice['image']) && $notice['image'] !== 'default-notice.png') {
            $imgPath = ROOT_DIR . '/public/uploads/notices/' . $notice['image'];
            if (is_file($imgPath) && file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        $noticeModel->delete($id);
        header("Location: " . BASE_URL . "/admin/notices");
        exit;
    }

    private function handleNoticeImageUpload($file, $oldImage = null)
    {
        if (isset($file['name']) && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_DIR . '/public/uploads/notices/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            if ($oldImage && $oldImage !== 'default-notice.png') {
                $oldImagePath = $uploadDir . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $fileName = time() . '_' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
                return $fileName;
            }
        }
        return $oldImage ?: 'default-notice.png';
    }
}
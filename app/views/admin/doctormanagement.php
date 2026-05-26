<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<div class="container py-5 min-vh-100">

    <!-- HEADER -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">

        <div>

            <h1 class="fw-bold mb-2" style="color: #0dcaf0;">

                <i class="bi bi-hospital me-2"></i>

                Quản Lý Bác Sĩ

            </h1>

            <p class="text-muted mb-0">

                Quản lý danh sách bác sĩ trong hệ thống bệnh viện

            </p>

        </div>

        <!-- BUTTON THÊM -->
        <button
            class="btn rounded-pill px-4 py-2 fw-semibold shadow-sm"
            style="
                background: #0dcaf0;
                color: white;
                border: none;
            "
            onclick="openAddModal()"
        >

            <i class="bi bi-plus-circle-fill me-2"></i>

            Thêm Bác Sĩ

        </button>

    </div>

    <!-- CARD -->
    <div
        class="card border-0 shadow-lg rounded-4 overflow-hidden"
        style="background: #ffffff;"
    >

        <!-- TOP BAR -->
        <div
            class="px-4 py-3"
            style="
                background: linear-gradient(
                    135deg,
                    #0dcaf0,
                    #0aa2c0
                );
            "
        >

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="text-white fw-bold mb-0">

                    <i class="bi bi-person-badge-fill me-2"></i>

                    Danh Sách Bác Sĩ

                </h5>

                <span class="badge bg-light text-info px-3 py-2">

                    <?= count($doctors ?? []) ?> bác sĩ

                </span>

            </div>

        </div>

        <!-- TABLE -->
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <!-- HEAD -->
                    <thead
                        style="
                            background: #e9f9fd;
                        "
                    >

                        <tr>

                            <th class="py-3 px-4 text-secondary">
                                ID
                            </th>

                            <th class="py-3 text-secondary">
                                Họ Tên
                            </th>

                            <th class="py-3 text-secondary">
                                Chuyên Khoa
                            </th>

                            <th class="py-3 text-center text-secondary">
                                Thao Tác
                            </th>

                        </tr>

                    </thead>

                    <!-- BODY -->
                    <tbody>

                    <?php if (!empty($doctors)): ?>

                        <?php foreach ($doctors as $doctor): ?>

                            <tr
                                class="border-top"
                                style="
                                    transition: 0.2s;
                                "
                                onmouseover="
                                    this.style.background='#f5fdff'
                                "
                                onmouseout="
                                    this.style.background='white'
                                "
                            >

                                <!-- ID -->
                                <td class="fw-bold px-4">

                                    #<?= htmlspecialchars($doctor['id']) ?>

                                </td>

                                <!-- HỌ TÊN -->
                                <td>

                                    <div class="d-flex align-items-center">

                                        <!-- Avatar -->
                                        <div
                                            class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="
                                                width: 45px;
                                                height: 45px;
                                                background: rgba(13,202,240,0.15);
                                                color: #0dcaf0;
                                                font-size: 20px;
                                            "
                                        >

                                            <i class="bi bi-person-fill"></i>

                                        </div>

                                        <!-- Name -->
                                        <div>

                                            <div class="fw-bold text-dark">

                                                <?= htmlspecialchars($doctor['ho_ten']) ?>

                                            </div>

                                            <small class="text-muted">

                                                Bác sĩ chuyên khoa

                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <!-- CHUYÊN KHOA -->
                                <td>

                                    <span
                                        class="badge rounded-pill px-3 py-2"
                                        style="
                                            background: rgba(13,202,240,0.15);
                                            color: #0dcaf0;
                                            font-size: 13px;
                                        "
                                    >

                                        <?= htmlspecialchars($doctor['chuyen_khoa']) ?>

                                    </span>

                                </td>

                                <!-- ACTION -->
                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- EDIT -->
                                        <button
                                            class="btn btn-sm rounded-pill px-3"
                                            style="
                                                background: #0dcaf0;
                                                color: white;
                                            "
                                            onclick='openEditModal(<?= json_encode($doctor, JSON_UNESCAPED_UNICODE) ?>)'
                                        >

                                            <i class="bi bi-pencil-square me-1"></i>

                                            Sửa

                                        </button>

                                        <!-- DELETE -->
                                        <a
                                            href="<?= BASE_URL ?>/admin/deleteDoctor/<?= $doctor['id'] ?>"
                                            class="btn btn-danger btn-sm rounded-pill px-3"
                                            onclick="return confirm('Bạn có chắc muốn xóa bác sĩ này?')"
                                        >

                                            <i class="bi bi-trash me-1"></i>

                                            Xóa

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <!-- EMPTY -->
                        <tr>

                            <td colspan="4" class="text-center py-5">

                                <div class="py-4">

                                    <i
                                        class="bi bi-inbox"
                                        style="
                                            font-size: 70px;
                                            color: #0dcaf0;
                                            opacity: 0.5;
                                        "
                                    ></i>

                                    <h5 class="mt-3 text-muted">

                                        Chưa có bác sĩ nào

                                    </h5>

                                    <p class="text-muted mb-0">

                                        Hãy thêm bác sĩ đầu tiên vào hệ thống

                                    </p>

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- MODAL -->
<div
    class="modal fade"
    id="doctorModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">

            <!-- HEADER -->
            <div
                class="modal-header border-0"
                style="
                    background: linear-gradient(
                        135deg,
                        #0dcaf0,
                        #0aa2c0
                    );
                "
            >

                <h4
                    class="modal-title fw-bold text-white"
                    id="modalTitle"
                >

                    Thêm Bác Sĩ

                </h4>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <!-- FORM -->
            <form
                id="doctorForm"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="modal-body p-4">

                    <!-- ID -->
                    <input
                        type="hidden"
                        name="id"
                        id="doctorId"
                    >

                    <!-- HỌ TÊN -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">

                            Họ tên bác sĩ

                        </label>

                        <input
                            type="text"
                            name="ho_ten"
                            id="ho_ten"
                            class="form-control rounded-3 py-2"
                            required
                        >

                    </div>

                    <!-- CHUYÊN KHOA -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Chuyên khoa

                        </label>

                        <select
                            name="id_chuyen_khoa"
                            id="id_chuyen_khoa"
                            class="form-select rounded-3 py-2"
                            required
                        >

                            <option value="1">
                                Khoa Ngoại Tổng Quát
                            </option>

                            <option value="2">
                                Khoa Tim Mạch
                            </option>

                            <option value="3">
                                Khoa Ngoại
                            </option>

                            <option value="4">
                                Khoa Nhi
                            </option>

                            <option value="5">
                                Thần Kinh
                            </option>

                            <option value="6">
                                Khoa Ung Bướu
                            </option>

                        </select>

                    </div>

                    <!-- TIỂU SỬ -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Chi tiết / Tiểu sử
                        </label>
                        <textarea
                            name="tieu_su"
                            id="tieu_su"
                            class="form-control rounded-3 py-2"
                            rows="4"
                        ></textarea>
                    </div>

                    <!-- HÌNH ẢNH -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Hình ảnh bác sĩ
                        </label>
                        <input
                            type="file"
                            name="hinh_anh"
                            id="hinh_anh"
                            class="form-control rounded-3 py-2"
                            accept="image/*"
                        >
                    </div>

                    <!-- LỊCH LÀM VIỆC -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-clock-history me-1"></i> Thời gian làm việc định kỳ
                        </label>
                        <input type="hidden" name="lich_lam_viec" id="lich_lam_viec_hidden">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="work_T2" checked>
                                    <label class="form-check-label fw-medium" for="work_T2">T2</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="work_T3" checked>
                                    <label class="form-check-label fw-medium" for="work_T3">T3</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="work_T4" checked>
                                    <label class="form-check-label fw-medium" for="work_T4">T4</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="work_T5" checked>
                                    <label class="form-check-label fw-medium" for="work_T5">T5</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="work_T6" checked>
                                    <label class="form-check-label fw-medium" for="work_T6">T6</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="work_T7">
                                    <label class="form-check-label fw-medium" for="work_T7">T7</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="work_CN">
                                    <label class="form-check-label fw-medium" for="work_CN">CN</label>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border"><i class="bi bi-sun text-warning"></i> Sáng</span>
                                        <input type="text" class="form-control border" id="ca_sang" value="09:00 AM - 11:00 AM">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border"><i class="bi bi-moon-stars text-info"></i> Tối</span>
                                        <input type="text" class="form-control border" id="ca_toi" value="10:00 PM - 20:00 PM">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 px-4 pb-4">

                    <button
                        type="button"
                        class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal"
                    >

                        Hủy

                    </button>

                    <button
                        type="submit"
                        class="btn rounded-pill px-4 text-white"
                        style="
                            background: #0dcaf0;
                        "
                    >

                        <i class="bi bi-save me-2"></i>

                        Lưu

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

let doctorModal;
document.addEventListener('DOMContentLoaded', function() {
    doctorModal = new bootstrap.Modal(document.getElementById('doctorModal'));
});

/**
 * ADD
 */
function openAddModal() {

    document.getElementById('modalTitle').innerText =
        'Thêm Bác Sĩ';

    document.getElementById('doctorForm').action =
        '<?= BASE_URL ?>/admin/storeDoctor';

    document.getElementById('doctorForm').reset();

    document.getElementById('doctorId').value = '';
    document.getElementById('tieu_su').value = '';
    document.getElementById('hinh_anh').value = '';

    document.getElementById('work_T2').checked = true;
    document.getElementById('work_T3').checked = true;
    document.getElementById('work_T4').checked = true;
    document.getElementById('work_T5').checked = true;
    document.getElementById('work_T6').checked = true;
    document.getElementById('work_T7').checked = false;
    document.getElementById('work_CN').checked = false;
    document.getElementById('ca_sang').value = '09:00 AM - 11:00 AM';
    document.getElementById('ca_toi').value = '10:00 PM - 20:00 PM';
    document.getElementById('lich_lam_viec_hidden').value = '';

    doctorModal.show();
}

/**
 * EDIT
 */
function openEditModal(doctor) {

    document.getElementById('modalTitle').innerText =
        'Chỉnh Sửa Bác Sĩ';

    document.getElementById('doctorForm').action =
        '<?= BASE_URL ?>/admin/updateDoctor/' + doctor.id;

    document.getElementById('doctorId').value =
        doctor.id;

    document.getElementById('ho_ten').value =
        doctor.ho_ten;

    document.getElementById('id_chuyen_khoa').value =
        doctor.id_chuyen_khoa;

    document.getElementById('tieu_su').value =
        doctor.tieu_su || '';
        
    document.getElementById('hinh_anh').value = '';

    if (doctor.lich_lam_viec) {
        try {
            const lich = JSON.parse(doctor.lich_lam_viec);
            if (lich.days) {
                document.getElementById('work_T2').checked = !!lich.days["T2"];
                document.getElementById('work_T3').checked = !!lich.days["T3"];
                document.getElementById('work_T4').checked = !!lich.days["T4"];
                document.getElementById('work_T5').checked = !!lich.days["T5"];
                document.getElementById('work_T6').checked = !!lich.days["T6"];
                document.getElementById('work_T7').checked = !!lich.days["T7"];
                document.getElementById('work_CN').checked = !!lich.days["CN"];
            }
            document.getElementById('ca_sang').value = lich.ca_sang || '09:00 AM - 11:00 AM';
            document.getElementById('ca_toi').value = lich.ca_toi || '10:00 PM - 20:00 PM';
        } catch (e) {}
    } else {
        document.getElementById('work_T2').checked = true;
        document.getElementById('work_T3').checked = true;
        document.getElementById('work_T4').checked = true;
        document.getElementById('work_T5').checked = true;
        document.getElementById('work_T6').checked = true;
        document.getElementById('work_T7').checked = false;
        document.getElementById('work_CN').checked = false;
        document.getElementById('ca_sang').value = '09:00 AM - 11:00 AM';
        document.getElementById('ca_toi').value = '10:00 PM - 20:00 PM';
    }

    doctorModal.show();
}

document.getElementById('doctorForm').addEventListener('submit', function() {
    const lichLamViec = {
        days: {
            "T2": document.getElementById('work_T2').checked,
            "T3": document.getElementById('work_T3').checked,
            "T4": document.getElementById('work_T4').checked,
            "T5": document.getElementById('work_T5').checked,
            "T6": document.getElementById('work_T6').checked,
            "T7": document.getElementById('work_T7').checked,
            "CN": document.getElementById('work_CN').checked
        },
        ca_sang: document.getElementById('ca_sang').value.trim(),
        ca_toi: document.getElementById('ca_toi').value.trim()
    };
    document.getElementById('lich_lam_viec_hidden').value = JSON.stringify(lichLamViec);
});

</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
<?php
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/HospitalizationModel.php';

$_POST = [
    'patient_name' => 'Test',
    'phone' => '123',
    'cccd' => '123',
    'patient_id' => '123',
    'department' => 'Khoa Nội',
    'reason' => 'Test',
    'admission_date' => '2026-05-22',
    'room_type' => 'Phòng VIP'
];
$_SERVER['REQUEST_METHOD'] = 'POST';

$raw_room_type = $_POST['room_type'] ?? '';
$tong_tien = 800000;
if ($raw_room_type === 'Phòng dịch vụ') {
    $tong_tien = 1200000;
} elseif ($raw_room_type === 'Phòng VIP') {
    $tong_tien = 2500000;
}
$room_type = filter_var($raw_room_type, FILTER_SANITIZE_SPECIAL_CHARS);

$data = [
    'patient_name'   => filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_SPECIAL_CHARS),
    'phone'          => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS),
    'cccd'           => filter_input(INPUT_POST, 'cccd', FILTER_SANITIZE_SPECIAL_CHARS),
    'patient_id'     => filter_input(INPUT_POST, 'patient_id', FILTER_SANITIZE_SPECIAL_CHARS),
    'department'     => filter_input(INPUT_POST, 'department', FILTER_SANITIZE_SPECIAL_CHARS),
    'reason'         => filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_SPECIAL_CHARS),
    'admission_date' => filter_input(INPUT_POST, 'admission_date', FILTER_SANITIZE_SPECIAL_CHARS),
    'room_type'      => $room_type,
    'tong_tien'      => $tong_tien
];

$model = new HospitalizationModel();
$id = $model->create($data);
$record = $model->find($id);

echo "Record tong_tien: " . $record['tong_tien'] . "\n";

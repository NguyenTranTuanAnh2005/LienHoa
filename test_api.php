<?php
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/models/PatientModel.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $model = new PatientModel();
    $data = $model->getAll();
    echo json_encode(['success' => true, 'data' => $data]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
}

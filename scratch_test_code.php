<?php
require 'app/config/database.php';
require 'app/models/PatientModel.php';

$model = new PatientModel();
$id = $model->create([
    'full_name' => 'Test Patient',
    'phone' => '0123456789'
]);

echo "Created ID: $id\n";
if ($id) {
    $patient = $model->getById($id);
    echo "Patient Code: " . $patient['patient_code'] . "\n";
}

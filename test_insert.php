<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=smart_hospital', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("INSERT INTO hospitalizations (patient_name, phone, department, admission_date, room_type) VALUES ('Test', '123', 'Khoa Nội', :date, 'Phòng thường')");
    $stmt->execute(['date' => '2026-05-24T10:35']);
    $stmt2 = $conn->query("SELECT admission_date FROM hospitalizations ORDER BY id DESC LIMIT 1;");
    print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

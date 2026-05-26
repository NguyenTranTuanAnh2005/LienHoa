<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=smart_hospital', 'root', '');
    $stmt = $conn->query("SELECT admission_date FROM hospitalizations LIMIT 5;");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($results);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

<?php
require_once __DIR__ . '/app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Update existing record
$updateTitle = "Thông tin lịch nghỉ lễ 30/4/2026 đến 2/5/2026";
$stmt = $conn->prepare("UPDATE notices SET title = :title WHERE title LIKE '%Lịch nghỉ lễ 30/4 và 1/5%' OR id = 1");
$stmt->execute(['title' => $updateTitle]);
echo "Updated title for Lịch nghỉ lễ.\n";

// Insert "Kiến Thức Y Khoa & Sống Khỏe"
$stmt = $conn->prepare("INSERT INTO notices (title, slug, summary, content, image, category, created_at) VALUES (:title, :slug, :summary, :content, :image, :category, NOW())");
$stmt->execute([
    'title' => 'Kiến Thức Y Khoa & Sống Khỏe',
    'slug' => 'kien-thuc-y-khoa-song-khoe',
    'summary' => 'Cập nhật những kiến thức y khoa mới nhất và bí quyết sống khỏe mỗi ngày...',
    'content' => '<p>Chuyên mục chia sẻ các kiến thức về y khoa, phòng chống bệnh tật và hướng dẫn chăm sóc sức khỏe tại nhà.</p>',
    'image' => 'kien-thuc.jpg',
    'category' => 'Kiến Thức'
]);
echo "Inserted Kiến Thức Y Khoa & Sống Khỏe.\n";

// Insert "Hoạt Động & Sự Kiện Bệnh Viện"
$stmt->execute([
    'title' => 'Hoạt Động & Sự Kiện Bệnh Viện',
    'slug' => 'hoat-dong-su-kien-benh-vien',
    'summary' => 'Thông tin về các hoạt động, sự kiện và hội thảo diễn ra tại bệnh viện...',
    'content' => '<p>Cập nhật chi tiết các sự kiện sắp tới, hội thảo y khoa và các hoạt động cộng đồng của bệnh viện.</p>',
    'image' => 'su-kien.jpg',
    'category' => 'Sự Kiện'
]);
echo "Inserted Hoạt Động & Sự Kiện Bệnh Viện.\n";

?>

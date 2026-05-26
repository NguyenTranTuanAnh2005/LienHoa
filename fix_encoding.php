<?php
$files = [
    'app/views/booking/index.php',
    'app/views/home/index.php',
    'app/views/layouts/footer.php',
    'app/views/layouts/header.php',
    'app/views/packages/index.php'
];
foreach($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);
    $fixed = mb_convert_encoding($content, 'Windows-1252', 'UTF-8');
    file_put_contents($file, $fixed);
    echo "Fixed $file\n";
}

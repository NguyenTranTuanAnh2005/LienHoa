<?php
$raw = "Phòng dịch vụ";
$sanitized = filter_var($raw, FILTER_SANITIZE_SPECIAL_CHARS);
echo "Sanitized: $sanitized\n";
echo "Dich vu match: " . (strpos($sanitized, 'dịch vụ') !== false ? 'YES' : 'NO') . "\n";
echo "VIP match: " . (strpos(filter_var("Phòng VIP", FILTER_SANITIZE_SPECIAL_CHARS), 'VIP') !== false ? 'YES' : 'NO') . "\n";

<?php
$password = "Admin123@"; // Thay bằng mật khẩu bạn muốn
$hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
echo "Mật khẩu đã mã hóa: " . $hashedPassword;
?>


<!-- username = admin -->
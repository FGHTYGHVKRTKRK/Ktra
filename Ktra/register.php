<?php
session_start();
include 'db_connect.php';

// if ($_SESSION['role'] !== 'admin') {
//     echo "Bạn không có quyền truy cập!";
//     exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role']; // Chỉ Admin có thể gán quyền

    $stmt = $conn->prepare("INSERT INTO User (username, password, fullname, email, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password, $fullname, $email, $role);

    if ($stmt->execute()) {
        echo "Thêm tài khoản thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Tài khoản</title>
</head>
<body>
<h2>Thêm Tài khoản Mới</h2>
<form method="POST">
    Tên đăng nhập: <input type="text" name="username" required><br>
    Mật khẩu: <input type="password" name="password" required><br>
    Họ và tên: <input type="text" name="fullname" required><br>
    Email: <input type="email" name="email" required><br>
    Vai trò:
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Thêm</button>
</form>
</body>
</html>

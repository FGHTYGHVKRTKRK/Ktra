<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn kiểm tra tài khoản
    $sql = "SELECT * FROM User WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Kiểm tra nếu tồn tại user và mật khẩu đúng
    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

        header("Location: index.php"); // Chuyển hướng về trang chính
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>

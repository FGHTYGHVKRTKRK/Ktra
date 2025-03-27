<?php
include 'db_connect.php';
include 'edit_nv.php';

// Lấy danh sách phòng ban
$phongban_result = $conn->query("SELECT MaPhong, TenPhong FROM PhongBan");

// Lấy thông tin nhân viên cần sửa
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM NhanVien WHERE MaNV='$id'");
    $nhanvien = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TenNV = $_POST['TenNV'];
    $Phai = $_POST['Phai'];
    $NoiSinh = $_POST['NoiSinh'];
    $MaPhong = $_POST['MaPhong'];
    $Luong = $_POST['Luong'];

    $sql = "UPDATE NhanVien SET TenNV='$TenNV', Phai='$Phai', NoiSinh='$NoiSinh', MaPhong='$MaPhong', Luong='$Luong' WHERE MaNV='$id'";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Nhân viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Sửa Nhân viên</h2>
    <form method="POST">
        Tên NV: <input type="text" name="TenNV" value="<?= $nhanvien['TenNV'] ?>" required><br>
        Phái: 
        <select name="Phai">
            <option value="Nam" <?= ($nhanvien['Phai'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
            <option value="Nữ" <?= ($nhanvien['Phai'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
        </select><br>
        Nơi Sinh: <input type="text" name="NoiSinh" value="<?= $nhanvien['NoiSinh'] ?>" required><br>
        
        Mã Phòng:
        <select name="MaPhong" required>
            <option value="">-- Chọn phòng ban --</option>
            <?php while ($row = $phongban_result->fetch_assoc()) { ?>
                <option value="<?= $row['MaPhong'] ?>" <?= ($nhanvien['MaPhong'] == $row['MaPhong']) ? 'selected' : '' ?>>
                    <?= $row['TenPhong'] ?>
                </option>
            <?php } ?>
        </select><br>
        
        Lương: <input type="number" name="Luong" value="<?= $nhanvien['Luong'] ?>" required><br>
        <button type="submit">Lưu</button>
    </form>
</div>
</body>
</html>

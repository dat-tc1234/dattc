<?php
function connect_db() {
    $servername = "localhost"; // Địa chỉ máy chủ
    $username = "root";        // Tên người dùng
    $password = "";            // Mật khẩu
    $dbname = "fanimation";    // Tên cơ sở dữ liệu

    try {
        // Tạo kết nối PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Thiết lập chế độ lỗi của PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; // Trả về kết nối nếu thành công
    } catch (PDOException $e) {
        // Ghi log hoặc hiển thị thông báo lỗi nếu cần
        echo "Kết nối thất bại: " . $e->getMessage();
        return null; // Trả về null nếu không thể kết nối
    }
}

function close_db_connection($conn) {
    $conn = null; // Đóng kết nối
}
?>

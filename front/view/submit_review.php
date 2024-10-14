<?php
session_start();
require_once 'C:\xampp\htdocs\Project\database\connect_db.php';
$conn = connect_db();

// Kiểm tra nếu request là POST và các dữ liệu đánh giá tồn tại
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $danh_gia = $_POST['danh_gia'] ?? null;
    $binh_luan = $_POST['binh_luan'] ?? null;
    $id_san_pham = $_POST['id_san_pham'] ?? null;
    $id_khach_hang = $_POST['id_khach_hang'] ?? null;

    // Kiểm tra nếu tất cả dữ liệu cần thiết đều tồn tại
    if ($danh_gia && $binh_luan && $id_san_pham && $id_khach_hang) {
        try {
            // Thêm đánh giá vào bảng `review`
            $stmt = $conn->prepare("INSERT INTO review (danh_gia, binh_luan, id_san_pham, id_khach_hang) VALUES (?, ?, ?, ?)");
            $stmt->execute([$danh_gia, $binh_luan, $id_san_pham, $id_khach_hang]);

            // Chuyển hướng trở lại trang chi tiết sản phẩm với trạng thái thành công
            header("Location: pd_detail.php?product_id=$id_san_pham&status=success");
            exit();
        } catch (PDOException $e) {
            // Ghi log lỗi và chuyển hướng với trạng thái lỗi
            error_log("Lỗi khi thêm đánh giá: " . $e->getMessage());
            header("Location: pd_detail.php?product_id=$id_san_pham&status=error");
            exit();
        }
    } else {
        // Nếu thiếu dữ liệu, chuyển hướng với trạng thái thiếu dữ liệu
        header("Location: pd_detail.php?product_id=$id_san_pham&status=missing_data");
        exit();
    }
} else {
    // Nếu request không hợp lệ, chuyển hướng về trang sản phẩm
    header("Location: pd_detail.php?product_id=" . ($_POST['id_san_pham'] ?? ''));
    exit();
}

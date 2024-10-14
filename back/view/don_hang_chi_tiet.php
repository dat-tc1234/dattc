<?php
session_start();
require_once 'C:\xampp\htdocs\Project\database\connect_db.php';

$conn = connect_db();
if (!$conn) {
    die("Unable to connect to the database.");
}

$order_id = $_GET['order_id'] ?? null;

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Đơn hàng không tồn tại.");
}

// Fetch order items
$stmt = $conn->prepare("SELECT * FROM chi_tiet_orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Chi Tiết Đơn Hàng #<?php echo $order['id']; ?></h1>

    <h5>Thông Tin Khách Hàng</h5>
    <p><strong>Tên:</strong> <?php echo htmlspecialchars($order['ten_nguoi_nhan']); ?></p>
    <p><strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($order['so_dien_thoai']); ?></p>
    <p><strong>Địa Chỉ:</strong> <?php echo htmlspecialchars($order['dia_chi']); ?></p>
    <p><strong>Ngày Đặt:</strong> <?php echo $order['ngay_dat']; ?></p>
    <p><strong>Tổng Giá:</strong> <?php echo number_format($order['tong_gia'], 0, ',', '.'); ?>₫</p>

    <h5 class="mt-4">Sản Phẩm</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Giá</th>
                <th>Tổng Cộng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['ten_san_pham']); ?></td>
                    <td><?php echo $item['so_luong']; ?></td>
                    <td><?php echo number_format($item['gia'], 0, ',', '.'); ?>₫</td>
                    <td><?php echo number_format($item['so_luong'] * $item['gia'], 0, ',', '.'); ?>₫</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="don_hang.php" class="btn btn-secondary">Quay lại</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

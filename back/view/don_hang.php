<?php
// Bắt đầu phiên làm việc nếu chưa bắt đầu
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'C:\xampp\htdocs\Project\database\connect_db.php';

$conn = connect_db();
if (!$conn) {
    die("Không thể kết nối đến cơ sở dữ liệu.");
}

// Xử lý các yêu cầu AJAX cho các hành động
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Lấy chi tiết đơn hàng và sản phẩm trong đơn hàng
    if ($action === 'view_details') {
        $order_id = $_POST['order_id'];
        
        // Lấy thông tin đơn hàng và tên khách hàng
        $stmt = $conn->prepare("
            SELECT orders.*, user.user_name 
            FROM orders 
            JOIN user ON orders.id_khach_hang = user.id 
            WHERE orders.id = ?
        ");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            // Lấy chi tiết các sản phẩm trong đơn hàng
            $stmt_products = $conn->prepare("
                SELECT p.ten_sp, cto.so_luong, cto.gia 
                FROM chi_tiet_orders cto
                JOIN products p ON cto.id_sp = p.id
                WHERE cto.order_id = ?
            ");
            $stmt_products->execute([$order_id]);
            $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

            // Trả về thông tin đơn hàng và danh sách sản phẩm
            echo json_encode(['order' => $order, 'products' => $products]);
        } else {
            echo json_encode(['error' => 'Không tìm thấy đơn hàng.']);
        }
        exit;
    }

    // Xác nhận đơn hàng
    if ($action === 'confirm_order') {
        $order_id = $_POST['order_id'];
        $stmt = $conn->prepare("UPDATE orders SET status = 'confirmed' WHERE id = ?");
        $stmt->execute([$order_id]);

        echo json_encode(['message' => 'Đơn hàng đã được xác nhận.']);
        exit;
    }

    // Hủy đơn hàng
    if ($action === 'cancel_order') {
        $order_id = $_POST['order_id'];
        $stmt = $conn->prepare("UPDATE orders SET status = 'canceled' WHERE id = ?");
        $stmt->execute([$order_id]);

        echo json_encode(['message' => 'Đơn hàng đã bị hủy.']);
        exit;
    }
}

// Lấy các đơn hàng để hiển thị
$orders = $conn->query("SELECT orders.*, user.user_name FROM orders JOIN user ON orders.id_khach_hang = user.id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center">Quản Lý Đơn Hàng</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Tổng Giá</th>
                <th>Ngày Đặt Hàng</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['user_name']) ?></td>
                    <td><?= number_format($order['tong_gia'], 0, ',', '.') ?>₫</td>
                    <td><?= htmlspecialchars($order['ngay_dat']) ?></td>
                    <td>
                        <button class="btn btn-info btn-sm view-details" data-id="<?= $order['id'] ?>">Xem</button>
                        <button class="btn btn-success btn-sm confirm-order" data-id="<?= $order['id'] ?>">Xác Nhận</button>
                        <button class="btn btn-danger btn-sm cancel-order" data-id="<?= $order['id'] ?>">Hủy</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Chi Tiết Đơn Hàng -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Chi Tiết Đơn Hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <!-- Nội dung chi tiết đơn hàng sẽ được tải ở đây -->
                <div id="order-details-content"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Xem chi tiết
        $('.view-details').click(function() {
            const orderId = $(this).data('id');
            $.post('/project/back/view/don_hang.php', { action: 'view_details', order_id: orderId }, function(response) {
                const result = JSON.parse(response);
                if (result.error) {
                    alert(result.error);
                } else {
                    const order = result.order;
                    const products = result.products;

                    let productListHtml = '<h5>Danh sách sản phẩm</h5><ul>';
                    products.forEach(product => {
                        productListHtml += `<li>${product.ten_sp} - Số lượng: ${product.so_luong} - Giá: ${new Intl.NumberFormat().format(product.gia)}₫</li>`;
                    });
                    productListHtml += '</ul>';

                    $('#order-details-content').html(`
                        <p><strong>Mã Đơn Hàng:</strong> ${order.id}</p>
                        <p><strong>Tên Khách Hàng:</strong> ${order.user_name}</p>
                        <p><strong>Tổng Giá:</strong> ${new Intl.NumberFormat().format(order.tong_gia)}₫</p>
                        <p><strong>Ngày Đặt:</strong> ${order.ngay_dat}</p>
                        <p><strong>Người Nhận:</strong> ${order.ten_nguoi_nhan}</p>
                        <p><strong>Số Điện Thoại:</strong> ${order.so_dien_thoai}</p>
                        <p><strong>Địa Chỉ:</strong> ${order.dia_chi}</p>
                        ${productListHtml}
                    `);
                    $('#orderDetailsModal').modal('show');
                }
            });
        });

        // Xác nhận đơn hàng
        $('.confirm-order').click(function() {
            const orderId = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn xác nhận đơn hàng này?')) {
                $.post('don_hang.php', { action: 'confirm_order', order_id: orderId }, function(response) {
                    const result = JSON.parse(response);
                    alert(result.message);
                    location.reload();
                });
            }
        });

        // Hủy đơn hàng
        $('.cancel-order').click(function() {
            const orderId = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
                $.post('don_hang.php', { action: 'cancel_order', order_id: orderId }, function(response) {
                    const result = JSON.parse(response);
                    alert(result.message);
                    location.reload();
                });
            }
        });
    });
</script>

</body>
</html>

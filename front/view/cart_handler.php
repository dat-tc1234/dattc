<?php
session_start();

// Kết nối cơ sở dữ liệu
require_once 'C:\xampp\htdocs\Project\database\connect_db.php';
$conn = connect_db();

if (!$conn) {
    die("Unable to connect to the database.");
}

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kiểm tra nếu request là POST và có action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Ghi log giá trị action nhận được
    error_log("Action received: " . $action);
    
    switch ($action) {
        case 'add_to_cart':
            // Lấy thông tin sản phẩm từ POST
            $productId = $_POST['product_id'] ?? null;
            $productName = $_POST['product_name'] ?? null;
            $productPrice = isset($_POST['product_price']) ? (float)$_POST['product_price'] : null;
            $productImage = $_POST['product_image'] ?? '/img/default-product.jpg';
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            // Kiểm tra thông tin sản phẩm đầy đủ
            if (!$productId || !$productName || !$productPrice) {
                echo json_encode(['status' => 'error', 'message' => 'Thông tin sản phẩm không đầy đủ!']);
                exit;
            }

            // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
            $productFound = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] === $productId) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }

            // Thêm sản phẩm mới nếu chưa có trong giỏ hàng
            if (!$productFound) {
                $_SESSION['cart'][] = [
                    'id' => $productId,
                    'name' => $productName,
                    'price' => $productPrice,
                    'image' => $productImage,
                    'quantity' => $quantity
                ];
            }

            echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được thêm vào giỏ hàng!']);
            break;

        case 'remove_all':
            $_SESSION['cart'] = [];
            echo json_encode(['status' => 'success', 'message' => 'Giỏ hàng đã được xóa thành công.']);
            break;

        case 'remove_item':
            $productId = $_POST['product_id'] ?? null;
            if ($productId && isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($productId) {
                    return $item['id'] !== $productId;
                });
                echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm để xóa.']);
            }
            break;

        case 'update_quantity':
            $productId = $_POST['product_id'] ?? null;
            $updateAction = $_POST['update_action'] ?? null;

            if ($productId && isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] === $productId) {
                        if ($updateAction === 'increase') {
                            $item['quantity']++;
                        } elseif ($updateAction === 'decrease' && $item['quantity'] > 1) {
                            $item['quantity']--;
                        }
                        break;
                    }
                }

                $newTotal = array_reduce($_SESSION['cart'], function ($sum, $item) {
                    return $sum + ($item['price'] * $item['quantity']);
                }, 0);

                echo json_encode([
                    'status' => 'success',
                    'new_quantity' => $item['quantity'],
                    'new_total' => $newTotal
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm để cập nhật.']);
            }
            break;

        case 'checkout':
            // Xử lý logic thanh toán tại đây
            if (!empty($_SESSION['cart'])) {
                // Giả lập xử lý thanh toán thành công
                $_SESSION['cart'] = []; // Xóa giỏ hàng sau khi thanh toán
                echo json_encode(['status' => 'success', 'message' => 'Thanh toán thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Giỏ hàng trống.']);
            }
            break;

        default:
            // Thêm giá trị action vào thông báo lỗi để dễ dàng kiểm tra
            echo json_encode(['status' => 'error', 'message' => "Hành động không hợp lệ: $action"]);
            break;
    }
} else {
    // Thông báo lỗi nếu không phải POST hoặc không có action
    echo json_encode(['status' => 'error', 'message' => 'Phương thức yêu cầu không hợp lệ hoặc không có hành động.']);
}

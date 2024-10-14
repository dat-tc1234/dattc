<?php
session_start();

// Database connection (if needed)
require_once 'C:\xampp\htdocs\Project\database\connect_db.php';
$conn = connect_db();

if (!$conn) {
    die("Unable to connect to the database.");
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'add_to_cart':
            $productId = $_POST['product_id'] ?? null;
            $productName = $_POST['product_name'] ?? null;
            $productPrice = isset($_POST['product_price']) ? (float)$_POST['product_price'] : null;
            $productImage = $_POST['product_image'] ?? '/img/default-product.jpg';
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if (!$productId || !$productName || !$productPrice) {
                echo json_encode(['status' => 'error', 'message' => 'Thông tin sản phẩm không đầy đủ!']);
                exit;
            }

            $productFound = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] === $productId) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }

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

        default:
            echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ.']);
            break;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức yêu cầu không hợp lệ.']);
}

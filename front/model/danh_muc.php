<?php
require_once __DIR__ . '/../../database/connect_db.php'; // File kết nối cơ sở dữ liệu

// Hàm lấy tên danh mục theo ID
function get_category_name($category_id) {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT ten_danh_muc FROM category WHERE id = :category_id");
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['ten_danh_muc'] : 'Danh mục không xác định';
}

// Hàm đếm tổng số sản phẩm trong danh mục
function get_total_products_by_category($category_id) {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE id_danh_muc = :category_id");
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}
?>

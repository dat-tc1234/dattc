<?php
require_once __DIR__ . '/../../database/connect_db.php'; // File kết nối cơ sở dữ liệu
require_once __DIR__ . '/danh_muc.php'; // Đảm bảo nạp các hàm về danh mục

// Hàm lấy sản phẩm mới
function get_new_arrivals() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM products WHERE new_arrival = 1 AND hien_thi_sp = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm lấy sản phẩm nổi bật
function get_featured_products() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM products WHERE featured = 1 AND hien_thi_sp = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm lấy sản phẩm bán chạy
function get_best_sellers() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM products WHERE best_seller = 1 AND hien_thi_sp = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm lấy chi tiết sản phẩm
function get_product($product_id) {
    $conn = connect_db();
    $sql = "SELECT * FROM products WHERE id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Hàm lấy sản phẩm theo danh mục với phân trang và sắp xếp
function get_products_by_category($category_id, $offset, $limit, $order_by = 'ASC') {
    $conn = connect_db();
    $sql = "SELECT * FROM products WHERE id_danh_muc = :category_id ORDER BY gia $order_by LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm tìm kiếm sản phẩm theo tên
function search_products($query) {
    $conn = connect_db();
    $sql = "SELECT * FROM products WHERE ten_sp LIKE :query AND hien_thi_sp = 1";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

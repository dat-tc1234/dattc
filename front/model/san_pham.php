<?php
    require_once __DIR__ . '/../../database/connect_db.php';
    function get_new_arrivals() {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM products WHERE new_arrival = 1 AND hien_thi_sp = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function get_featured_products() {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM products WHERE featured = 1 AND hien_thi_sp = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_best_sellers() {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM products WHERE best_seller = 1 AND hien_thi_sp = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_product($product_id) {
        $conn = connect_db();
        $sql = "SELECT * FROM products WHERE id = :product_id"; // Truy vấn để lấy sản phẩm theo ID
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin sản phẩm
    }
    function get_products_by_category($category_id, $offset, $limit, $order_by) {
        $conn = connect_db();
        $sql = "SELECT * FROM products WHERE id_danh_muc = :category_id ORDER BY gia $order_by LIMIT :limit OFFSET :offset"; // Thay đổi category_id thành id_danh_muc
        $stmt = $conn->prepare($sql);
        
        // Ràng buộc các tham số
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách sản phẩm
    }

    function search_products($query) {
        $conn = connect_db();
        $sql = "SELECT * FROM products WHERE ten_sp LIKE :query AND hien_thi_sp = 1"; // Tìm kiếm sản phẩm
        $stmt = $conn->prepare($sql);
        $searchTerm = '%' . $query . '%'; // Thêm ký tự % để tìm kiếm
        $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách sản phẩm
    }
    ?>
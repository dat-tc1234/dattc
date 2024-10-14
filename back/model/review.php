<?php
function get_all_reviews() {
    $conn = connect_db();
    $sql = "SELECT r.*, p.ten_sp, u.user_name 
            FROM review r 
            JOIN products p ON r.id_san_pham = p.id 
            JOIN user u ON r.id_khach_hang = u.id 
            WHERE r.hien_thi_bl = 1"; // Chỉ lấy bình luận hiện
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function add_review($id_san_pham, $id_khach_hang, $danh_gia, $binh_luan) {
    $conn = connect_db();
    $sql = "INSERT INTO review (id_san_pham, id_khach_hang, danh_gia, binh_luan, ngay_bl, hien_thi_bl) 
            VALUES (:id_san_pham, :id_khach_hang, :danh_gia, :binh_luan, NOW(), 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_san_pham', $id_san_pham, PDO::PARAM_INT);
    $stmt->bindParam(':id_khach_hang', $id_khach_hang, PDO::PARAM_INT);
    $stmt->bindParam(':danh_gia', $danh_gia, PDO::PARAM_INT);
    $stmt->bindParam(':binh_luan', $binh_luan, PDO::PARAM_STR);
    return $stmt->execute();
}

function hide_review($id) {
    $conn = connect_db();
    $sql = "UPDATE review SET hien_thi_bl = 0 WHERE id = :id"; // Sử dụng tên bảng đúng
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function restore_review($id) {
    $conn = connect_db();
    $sql = "UPDATE review SET hien_thi_bl = 1 WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function get_hidden_reviews() {
    $conn = connect_db();
    $sql = "SELECT r.*, p.ten_sp, u.user_name 
            FROM review r 
            JOIN products p ON r.id_san_pham = p.id 
            JOIN user u ON r.id_khach_hang = u.id 
            WHERE r.hien_thi_bl = 0
            ORDER BY r.ngay_bl DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
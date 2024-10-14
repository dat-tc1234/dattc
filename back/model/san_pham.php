<?php
    function insert_product($id_danh_muc, $ten_sp, $gia, $so_luong_hang, $mo_ta_sp, $images, $cong_suat, $cong_nghe, $chat_lieu, $chuc_nang, $so_canh, $toc_do, $new_arrival, $featured, $best_seller) {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->execute([$id_danh_muc]);
        $category = $stmt->fetch();
        if ($category) {
            $sql = "INSERT INTO products (id_danh_muc, ten_sp, gia, so_luong_hang, mo_ta_sp, images, cong_suat, cong_nghe, chat_lieu, chuc_nang, so_canh, toc_do, new_arrival, featured, best_seller) 
                    VALUES (:id_danh_muc, :ten_sp, :gia, :so_luong_hang, :mo_ta_sp, :images, :cong_suat, :cong_nghe, :chat_lieu, :chuc_nang, :so_canh, :toc_do, :new_arrival, :featured, :best_seller)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id_danh_muc' => $id_danh_muc,
                ':ten_sp' => $ten_sp,
                ':gia' => $gia,
                ':so_luong_hang' => $so_luong_hang,
                ':mo_ta_sp' => $mo_ta_sp,
                ':images' => json_encode($images), 
                ':cong_suat' => $cong_suat,
                ':cong_nghe' => $cong_nghe,
                ':chat_lieu' => $chat_lieu,
                ':chuc_nang' => $chuc_nang,
                ':so_canh' => $so_canh,
                ':toc_do' => $toc_do,
                ':new_arrival' => $new_arrival,
                ':featured' => $featured,
                ':best_seller' => $best_seller
            ]);
        } else {
            echo "Lỗi: Danh mục không tồn tại.";
        }
    }

    function getall_sp() {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM products WHERE hien_thi_sp = 1");
        $stmt->execute();
        $kq = $stmt->fetchAll();
        return $kq;
    }

    function get_product($id){
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $kq = $stmt->fetch(PDO::FETCH_ASSOC);
        return $kq;
    }

    function update_product($id, $ten_sp, $gia, $so_luong_hang, $mo_ta_sp, $id_danh_muc, $cong_suat, $cong_nghe, $chat_lieu, $chuc_nang, $so_canh, $toc_do, $images = "", $new_arrival, $featured, $best_seller) {
        $conn = connect_db();
        if($images == "") {
            $sql = "UPDATE products SET ten_sp = :ten_sp, gia = :gia, so_luong_hang = :so_luong_hang, 
                    mo_ta_sp = :mo_ta_sp, id_danh_muc = :id_danh_muc, cong_suat = :cong_suat, 
                    cong_nghe = :cong_nghe, chat_lieu = :chat_lieu, chuc_nang = :chuc_nang, 
                    so_canh = :so_canh, toc_do = :toc_do, new_arrival = :new_arrival, 
                    featured = :featured, best_seller = :best_seller WHERE id = :id";
        } else {
            $sql = "UPDATE products SET ten_sp = :ten_sp, gia = :gia, so_luong_hang = :so_luong_hang, 
                    mo_ta_sp = :mo_ta_sp, id_danh_muc = :id_danh_muc, cong_suat = :cong_suat, 
                    cong_nghe = :cong_nghe, chat_lieu = :chat_lieu, chuc_nang = :chuc_nang, 
                    so_canh = :so_canh, toc_do = :toc_do, images = :images, 
                    new_arrival = :new_arrival, featured = :featured, best_seller = :best_seller WHERE id = :id";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ten_sp', $ten_sp);
        $stmt->bindParam(':gia', $gia);
        $stmt->bindParam(':so_luong_hang', $so_luong_hang);
        $stmt->bindParam(':mo_ta_sp', $mo_ta_sp);
        $stmt->bindParam(':id_danh_muc', $id_danh_muc);
        $stmt->bindParam(':cong_suat', $cong_suat);
        $stmt->bindParam(':cong_nghe', $cong_nghe);
        $stmt->bindParam(':chat_lieu', $chat_lieu);
        $stmt->bindParam(':chuc_nang', $chuc_nang);
        $stmt->bindParam(':so_canh', $so_canh);
        $stmt->bindParam(':toc_do', $toc_do);
        $stmt->bindParam(':new_arrival', $new_arrival);
        $stmt->bindParam(':featured', $featured);
        $stmt->bindParam(':best_seller', $best_seller);
        $stmt->bindParam(':id', $id);
        if($images != "") {
            $stmt->bindParam(':images', $images);
        }
        
        $stmt->execute();
    }

    function delete_product($id) {
        $conn = connect_db();
        $sql = "UPDATE products SET hien_thi_sp = 0 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    function restore_product($id) {
        $conn = connect_db();
        $sql = "UPDATE products SET hien_thi_sp = 1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    function get_hidden_products() {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM products WHERE hien_thi_sp = 0");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Phân trang
    function count_san_pham() {
        $conn = connect_db();
        $sql = "SELECT COUNT(*) FROM products WHERE hien_thi_sp = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    function get_products_paginated($start, $limit) {
        $conn = connect_db();
        $sql = "SELECT * FROM products WHERE hien_thi_sp = 1 ORDER BY id DESC LIMIT :start, :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function is_product_exists($ten_sp) {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE ten_sp = :ten_sp");
        $stmt->bindParam(':ten_sp', $ten_sp);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        return $count > 0; 
    }

    function get_products_based_on_filters() {
        global $current_page, $items_per_page; 
    
        $conn = connect_db();
        $offset = ($current_page - 1) * $items_per_page; 
    
        
        $sql = "SELECT * FROM products WHERE hien_thi_sp = 1 ORDER BY ngay_dang DESC LIMIT :limit OFFSET :offset"; 
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
?>
<?php
function getall_dm() {
    $conn = connect_db();
    $sql = "SELECT *, 
            CASE 
                WHEN parent_id = 0 OR parent_id IS NULL THEN 0 
                ELSE 1 
            END AS level 
            FROM category 
            WHERE hien_thi_dm = 1 
            ORDER BY parent_id, id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}

function add_category($ten_danh_muc, $parent_id) {
    $conn = connect_db();
    $sql = "INSERT INTO category (ten_danh_muc, parent_id) VALUES (:ten_danh_muc, :parent_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ten_danh_muc', $ten_danh_muc);
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->execute();
}

function update_category($id, $ten_danh_muc, $parent_id) {
    $conn = connect_db();
    $sql = "UPDATE category SET ten_danh_muc = :ten_danh_muc, parent_id = :parent_id WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':ten_danh_muc', $ten_danh_muc);
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->execute();
}

function delete_category($id) {
    $conn = connect_db();
    $sql = "UPDATE category SET hien_thi_dm = 0 WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function get_category($id) {
    $conn = connect_db();
    $sql = "SELECT * FROM category WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function restore_category($id) {
    $conn = connect_db();
    $sql = "UPDATE category SET hien_thi_dm = 1 WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function get_hidden_categories() {
    $conn = connect_db();
    $sql = "SELECT * FROM category WHERE hien_thi_dm = 0 ORDER BY parent_id, id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_categories_hierarchical() {
    $categories = getall_dm();
    $tree = [];
    foreach ($categories as $category) {
        $category['children'] = [];
        if (!$category['parent_id']) {
            $tree[$category['id']] = $category;
        } else {
            $parent = &find_parent($tree, $category['parent_id']);
            if ($parent) {
                $parent['children'][$category['id']] = $category;
            }
        }
    }
    return $tree;
}

function &find_parent(&$categories, $parent_id) {
    foreach ($categories as &$category) {
        if ($category['id'] == $parent_id) {
            return $category;
        }
        if ($category['children']) {
            $result = &find_parent($category['children'], $parent_id);
            if ($result) {
                return $result;
            }
        }
    }
    $result = null;
    return $result;
}



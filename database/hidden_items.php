<?php
require_once 'connect_db.php';

function getHiddenCategories() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM category WHERE hien_thi_dm = 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHiddenProducts() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM products WHERE hien_thi_sp = 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHiddenUsers() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM user WHERE hien_thi_user = 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHiddenReviews() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM review WHERE hien_thi_bl = 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

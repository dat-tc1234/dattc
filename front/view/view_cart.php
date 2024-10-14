<?php
session_start();
header('Content-Type: application/json');

// Trả về nội dung giỏ hàng từ session
if (isset($_SESSION['cart'])) {
    echo json_encode($_SESSION['cart']);
} else {
    echo json_encode([]);
}

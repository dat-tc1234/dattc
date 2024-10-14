<?php
session_start();
ob_start();
require_once '../database/connect_db.php'; 
require_once 'model/user.php';  
require_once 'model/san_pham.php'; 

connect_db();  
require_once '../back/model/danh_muc.php';

$categories = get_categories_hierarchical(); 
include 'view/header.php'; 

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

// Lấy dữ liệu sản phẩm trực tiếp từ cơ sở dữ liệu
$new_arrivals = get_new_arrivals(); // Không cần truyền tham số
$featured_products = get_featured_products(); 
$best_sellers = get_best_sellers(); 

if (isset($_GET['id'])) {
    $category_id = $_GET['id']; 
    include 'view/category_products.php'; 
    exit; 
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product = get_product($product_id); 
    include 'view/pd_detail.php'; 
    exit; 
}

if (isset($_POST['comment'])) {
    $product_id = $_GET['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id']; // Giả sử bạn đã lưu ID người dùng trong session

    // Gọi hàm để thêm bình luận vào cơ sở dữ liệu
    add_review($product_id, $user_id, $rating, $comment);

    $_SESSION['success'] = "Bình luận của bạn đã được gửi!";
    header("Location: index.php?act=pd_detail&product_id=" . $product_id);
    exit;
}

if (isset($_POST['filter'])) {
    if (isset($_POST['new_arrival'])) {
        $new_arrivals = get_new_arrivals(20); 
    }
    if (isset($_POST['featured'])) {
        $featured_products = get_featured_products(); 
    }
    if (isset($_POST['best_seller'])) {
        $best_sellers = get_best_sellers(); 
    }
}

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'login':
            include 'view/login.php';  
            break;

        case 'register':
            include 'view/register.php';  
            break;

        case 'category':
            $category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; 
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 8; 
            $offset = ($page - 1) * $limit; 
            $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; 
            $order_by = ($order === 'desc') ? 'DESC' : 'ASC';
            $products = get_products_by_category($category_id, $offset, $limit, $order_by); 
            $category_name = get_category_name($category_id);
            $total_products = get_total_products_by_category($category_id);
            $total_pages = ceil($total_products / $limit); 
            include 'view/category_products.php'; 
            exit; 
        
        case 'pd_detail': 
            if (isset($_GET['product_id'])) {
                $product_id = $_GET['product_id'];
                $product = get_product($product_id);
                include 'view/pd_detail.php'; 
                exit; 
            } else {
                echo "<p>Sản phẩm không tồn tại.</p>";
                exit;
            }

        case 'body':
            include 'view/body.php'; 
            break;  

        default:
            include 'view/body.php'; 
            break;
    }
} else {
    include 'view/body.php'; 
}

include 'view/footer.php';  
?>
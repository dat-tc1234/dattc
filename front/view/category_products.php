<?php
session_start();
include 'header.php'; 
require_once __DIR__ . '/../model/danh_muc.php'; 
require_once __DIR__ . '/../model/san_pham.php';
require_once __DIR__ . '/../view/pagination.php'; // Nạp hàm phân trang

// Kiểm tra và khởi tạo các biến
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

// Xác định thứ tự sắp xếp mặc định
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$order_by = ($order === 'desc') ? 'DESC' : 'ASC';

// Lấy sản phẩm theo danh mục và tên danh mục
$products = get_products_by_category($category_id, $offset, $limit, $order_by);
$category_name = get_category_name($category_id);
$total_products = get_total_products_by_category($category_id);
$total_pages = ceil($total_products / $limit);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục sản phẩm - <?php echo htmlspecialchars($category_name); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        /* CSS Tùy chỉnh */
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
        }

        .card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            object-fit: cover;
            height: 200px;
        }

        .market-button {
            background-color: #28a745;
            color: #fff;
            border-radius: 20px;
            padding: 8px 16px;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 8px;
        }

        .market-button:hover {
            background-color: #218838;
            color: #fff;
        }

        /* Phân trang */
        .pagination {
            justify-content: center;
        }

        .pagination .page-link {
            color: #333;
            border: none;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container mt-5"> 
    <div class="d-flex justify-content-between align-items-center mb-4"> 
        <h2>Sản phẩm trong danh mục: <?php echo htmlspecialchars($category_name); ?></h2>
        <form method="GET" class="form-inline">
            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category_id); ?>">
            <select name="order" class="form-control" onchange="this.form.submit()">
                <option value="asc" <?php echo ($order === 'asc') ? 'selected' : ''; ?>>Giá: Thấp đến Cao</option>
                <option value="desc" <?php echo ($order === 'desc') ? 'selected' : ''; ?>>Giá: Cao đến Thấp</option>
            </select>
        </form>
    </div>

    <div class="row">
        <?php if (!empty($products) && is_array($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <?php 
                        $images = json_decode($product['images'], true);
                        $first_image = !empty($images) ? 'http://localhost/Project/upload/' . $images[0] : '/img/default-product.jpg';
                        ?>
                        <a href="../index.php?act=pd_detail&product_id=<?php echo $product['id']; ?>">
                            <img src="<?php echo htmlspecialchars($first_image); ?>" alt="<?php echo htmlspecialchars($product['ten_sp']); ?>" class="card-img-top">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['ten_sp']); ?></h5>
                            <p class="card-text"><?php echo number_format($product['gia'], 0, ',', '.'); ?>₫</p>
                            <a href="#" class="market-button add-to-cart" 
                               data-id="<?php echo $product['id']; ?>" 
                               data-name="<?php echo htmlspecialchars($product['ten_sp']); ?>" 
                               data-price="<?php echo $product['gia']; ?>" 
                               data-image="<?php echo htmlspecialchars($first_image); ?>">Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Không có sản phẩm nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
    <?php renderPagination($page, $total_pages, $category_id); ?>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
include 'header.php';
require_once __DIR__ . '/../model/san_pham.php';

// Kiểm tra và lấy truy vấn tìm kiếm từ URL, đảm bảo $query luôn được khởi tạo
$query = isset($_GET['query']) ? $_GET['query'] : '';
$products = [];

// Định nghĩa đường dẫn cơ sở cho hình ảnh sản phẩm
$imageBasePath = 'http://localhost/Project/upload/';

// Nếu truy vấn không trống, thực hiện tìm kiếm
if (!empty($query)) {
    $products = search_products($query);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        /* CSS Tùy Chỉnh */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 30px;
        }
        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }
        .card-img-top:hover {
            opacity: 0.9;
        }
        .card-title {
            font-weight: bold;
            font-size: 1.1rem;
            color: #007bff;
            text-align: center;
        }
        .card-text {
            font-size: 1rem;
            color: #555;
            text-align: center;
            margin-bottom: 15px;
        }
        .market-button {
            display: block;
            color: #fff;
            background-color: #28a745;
            padding: 10px 0;
            text-align: center;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .market-button:hover {
            background-color: #218838;
            text-decoration: none;
        }
        .search-results-title {
            color: #007bff;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        .no-results {
            font-size: 1.2rem;
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container main-container">
        <h2 class="search-results-title">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($query); ?>"</h2>
        
        <div class="row my-5">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php 
                            $images = json_decode($product['images'], true);
                            $first_image = (!empty($images) && is_array($images)) ? $imageBasePath . $images[0] : '/img/default-product.jpg';
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
                <p class="no-results">Không tìm thấy sản phẩm nào phù hợp với từ khóa này.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="http://localhost/Project/public/JS/cart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'C:\xampp\htdocs\Project\database\connect_db.php';

// Kết nối cơ sở dữ liệu
$conn = connect_db();

// Kiểm tra đăng nhập
$logged_in = isset($_SESSION['user_id']);
$user_id = $_SESSION['user_id'] ?? null;

// Lấy thông tin sản phẩm
$product_id = $_GET['product_id'] ?? null;
if (!$product_id) {
    die("ID sản phẩm không hợp lệ.");
}

// Hàm lấy thông tin sản phẩm theo ID
function get_product_by_id($id, $conn)
{
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$product = get_product_by_id($product_id, $conn);
if (!$product) {
    die("Sản phẩm không tồn tại.");
}

// Xử lý đánh giá khi form được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_review') {
    if ($logged_in) {
        $danh_gia = $_POST['danh_gia'] ?? null;
        $binh_luan = $_POST['binh_luan'] ?? null;

        if ($danh_gia && $binh_luan && $product_id && $user_id) {
            try {
                $stmt = $conn->prepare("INSERT INTO review (danh_gia, binh_luan, id_san_pham, id_khach_hang) VALUES (?, ?, ?, ?)");
                $stmt->execute([$danh_gia, $binh_luan, $product_id, $user_id]);
                $review_status = 'success';
            } catch (PDOException $e) {
                error_log("Lỗi khi thêm đánh giá: " . $e->getMessage());
                $review_status = 'error';
            }
        } else {
            $review_status = 'missing_data';
        }
    } else {
        $review_status = 'login_required';
    }
}

// Lấy các đánh giá cho sản phẩm hiện tại
$stmt = $conn->prepare("SELECT r.danh_gia, r.binh_luan, r.ngay_bl, u.user_name FROM review r JOIN user u ON r.id_khach_hang = u.id WHERE r.id_san_pham = ?");
$stmt->execute([$product_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy hình ảnh sản phẩm
$images = json_decode($product['images'], true);
$first_image = (!empty($images) && !empty($images[0])) ? htmlspecialchars($images[0]) : '/img/default-product.jpg';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/Project/public/css/pd_detail.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <?php if (isset($product)): ?>
            <div class="row">
                <div class="col-md-6 product-image-container">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $image): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="image-wrapper">
                                        <img src="<?php echo htmlspecialchars($image); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['ten_sp']); ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="d-flex justify-content-start mt-3">
                        <?php foreach ($images as $index => $image): ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" class="img-thumbnail thumbnail-small" alt="<?php echo htmlspecialchars($product['ten_sp']); ?>" onclick="changeImage('<?php echo htmlspecialchars($image); ?>', this)">
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <h1><?php echo htmlspecialchars($product['ten_sp']); ?></h1>
                    <h4>Giá bán: <?php echo number_format($product['gia'], 0, ',', '.'); ?>₫</h4>
                    <table class="table table-bordered mt-3">
                        <tbody>
                            <tr>
                                <th>Công suất</th>
                                <td><?php echo htmlspecialchars($product['cong_suat']); ?></td>
                            </tr>
                            <tr>
                                <th>Số cánh</th>
                                <td><?php echo htmlspecialchars($product['so_canh']); ?></td>
                            </tr>
                            <tr>
                                <th>Công nghệ</th>
                                <td><?php echo htmlspecialchars($product['cong_nghe']); ?></td>
                            </tr>
                            <tr>
                                <th>Tốc độ</th>
                                <td><?php echo htmlspecialchars($product['toc_do']); ?></td>
                            </tr>
                            <tr>
                                <th>Chất liệu</th>
                                <td><?php echo htmlspecialchars($product['chat_lieu']); ?></td>
                            </tr>
                            <tr>
                                <th>Chức năng</th>
                                <td><?php echo htmlspecialchars($product['chuc_nang']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex align-items-center mt-3">
                        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control quantity-input" style="width: 100px; margin-right: 10px;">
                        <button class="btn btn-primary btn-md add-to-cart"
                            data-id="<?php echo $product['id']; ?>"
                            data-name="<?php echo htmlspecialchars($product['ten_sp']); ?>"
                            data-price="<?php echo $product['gia']; ?>"
                            data-image="<?php echo $first_image; ?>">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-4 border p-3" style="border: 1px solid #ccc; border-radius: 5px;">
                <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($product['mo_ta_sp']); ?></p>
            </div>

            <!-- Phần hiển thị đánh giá -->
            <?php if (isset($review_status)): ?>
                <div class="alert <?php echo $review_status === 'success' ? 'alert-success' : ($review_status === 'error' ? 'alert-danger' : 'alert-warning'); ?>">
                    <?php
                    echo $review_status === 'success' ? "Đánh giá của bạn đã được ghi nhận!" : ($review_status === 'error' ? "Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại." : ($review_status === 'missing_data' ? "Vui lòng điền đầy đủ thông tin đánh giá." : "Bạn cần <a href='login.php'>đăng nhập</a> để đánh giá sản phẩm này."));
                    ?>
                </div>
            <?php endif; ?>

            <!-- Form gửi đánh giá (chỉ hiển thị khi đã đăng nhập) -->
            <?php if ($logged_in): ?>
                <h2>Đánh giá sản phẩm</h2>
                <form action="" method="POST">
                    <input type="hidden" name="action" value="submit_review">
                    <div class="mb-3">
                        <label class="form-label">Đánh giá:</label>
                        <div class="star-rating">
                            <input type="radio" name="danh_gia" value="5" id="star-5">
                            <label for="star-5" title="5 sao">&#9733;</label>
                            <input type="radio" name="danh_gia" value="4" id="star-4">
                            <label for="star-4" title="4 sao">&#9733;</label>
                            <input type="radio" name="danh_gia" value="3" id="star-3">
                            <label for="star-3" title="3 sao">&#9733;</label>
                            <input type="radio" name="danh_gia" value="2" id="star-2">
                            <label for="star-2" title="2 sao">&#9733;</label>
                            <input type="radio" name="danh_gia" value="1" id="star-1">
                            <label for="star-1" title="1 sao">&#9733;</label>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Bình luận:</label>
                            <textarea id="comment" name="binh_luan" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </form>
            <?php else: ?>
                <p>Vui lòng <a href="login.php">đăng nhập</a> để gửi đánh giá.</p>
            <?php endif; ?>

            <!-- Hiển thị các đánh giá hiện có -->
            <h2 class="mt-5">Đánh giá từ người dùng</h2>
            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="border rounded p-3 mb-3">
                        <p><strong>Người dùng:</strong> <?php echo htmlspecialchars($review['user_name']); ?></p>
                        <p><strong>Đánh giá:</strong> <?php echo $review['danh_gia']; ?> sao</p>
                        <p><strong>Bình luận:</strong> <?php echo htmlspecialchars($review['binh_luan']); ?></p>
                        <p><small><em>Ngày bình luận: <?php echo $review['ngay_bl']; ?></em></small></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Sản phẩm không tồn tại.</p>
        <?php endif; ?>
        <div class="container mt-5">
            <h2 class="text-center">SẢN PHẨM TƯƠNG TỰ</h2>
            <div class="row text-center mt-5">
                <?php
                // Lấy sản phẩm tương tự dựa trên id_danh_muc và loại trừ sản phẩm hiện tại
                $similar_products = get_products_by_category($product['id_danh_muc'], $product['id'], 8, 'ASC');
                if (is_array($similar_products) && count($similar_products) > 0): ?>
                    <?php foreach ($similar_products as $similar_product): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <?php
                                $images = isset($product['images']) ? json_decode($product['images'], true) : [];
                                $first_image = $images[0] ?? '/img/default-product.jpg';
                                ?>
                                <a href="index.php?act=pd_detail&product_id=<?php echo $product['id']; ?>">
                                    <img src="<?php echo $first_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['ten_sp']); ?>">
                                </a>
                                <div class="card-body text-start"> <!-- Căn trái -->
                                    <h5 class="card-title"><?php echo htmlspecialchars($similar_product['ten_sp']); ?></h5>
                                    <p class="card-text"><?php echo number_format($similar_product['gia'], 0, ',', '.'); ?>₫</p>
                                    <a href="#" class="market-button add-to-cart"
                                        data-id="<?php echo $similar_product['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($similar_product['ten_sp']); ?>"
                                        data-price="<?php echo $similar_product['gia']; ?>"
                                        data-image="<?php echo $similar_first_image; ?>">Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sản phẩm tương tự.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Bao gồm tập lệnh giỏ hàng -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = this.getAttribute('data-price');
            const productImage = this.getAttribute('data-image');
            const quantity = document.getElementById('quantity').value;

            fetch('http://localhost/Project/front/view/cart_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'add_to_cart',
                        product_id: productId,
                        product_name: productName,
                        product_price: productPrice,
                        product_image: productImage,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
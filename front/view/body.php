<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quạt Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="http://localhost/project/public/css/body.css" rel="stylesheet"> 
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const productId = this.dataset.id;
                    const productName = this.dataset.name;
                    const productPrice = this.dataset.price;
                    const productImage = this.dataset.image;

                    fetch('/Project/front/view/cart_handler.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                action: 'add_to_cart',
                                product_id: productId,
                                product_name: productName,
                                product_price: productPrice,
                                product_image: productImage
                            })
                        })

                        .then(response => response.json()) // Phân tích phản hồi dưới dạng JSON
                        .then(data => {
                            if (data.status === 'success') {
                                alert(data.message); // Hiển thị thông báo tiếng Việt chính xác
                            } else {
                                alert('Có lỗi xảy ra khi thêm vào giỏ hàng!');
                            }
                        })
                        .catch(error => console.error('Lỗi:', error));
                });
            });
        });
    </script>
</head>

<body>

    <div class="container main-container">
        <div class="New-arrival">
            <h1 class="display-4">New Arrivals</h1>
            <p class="lead">Khám phá bộ sưu tập quạt điện và quạt trần hiện đại, sang trọng và tiết kiệm năng lượng ngay hôm nay!</p>
        </div>

        <div class="container my-5">
            <div class="row">
                <?php if (is_array($new_arrivals)): ?>
                    <?php foreach (array_slice($new_arrivals, 0, 20) as $product): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <?php
                                $images = isset($product['images']) ? json_decode($product['images'], true) : [];
                                $first_image = $images[0] ?? '/img/default-product.jpg';
                                ?>
                                <a href="index.php?act=pd_detail&product_id=<?php echo $product['id']; ?>">
                                    <img src="<?php echo $first_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['ten_sp']); ?>">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['ten_sp']); ?></h5>
                                    <p class="card-text"><?php echo number_format($product['gia'], 0, ',', '.'); ?>₫</p>
                                    <a href="#" class="market-button add-to-cart"
                                        data-id="<?php echo $product['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($product['ten_sp']); ?>"
                                        data-price="<?php echo $product['gia']; ?>"
                                        data-image="<?php echo $first_image; ?>">
                                        Thêm vào giỏ hàng
                                    </a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const productId = this.dataset.id;
                const productName = this.dataset.name;
                const productPrice = this.dataset.price;
                const productImage = this.dataset.image;

                fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            action: 'add_to_cart',
                            product_id: productId,
                            product_name: productName,
                            product_price: productPrice,
                            product_image: productImage
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                        } else {
                            alert('Có lỗi xảy ra khi thêm vào giỏ hàng!');
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
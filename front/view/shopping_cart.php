<?php
session_start();
include 'C:\xampp\htdocs\Project\front\view\header.php';

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tính tổng giá tiền
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng Của Bạn</title>
    <link rel="stylesheet" href="http://localhost/Project/public/css/shopping_cart.css">
</head>

<body>
<div class="container mt-5">
    <h1 class="fw-bold">GIỎ HÀNG CỦA BẠN</h1>
    <p>TỔNG CỘNG (<span id="cart-count"><?= count($_SESSION['cart']) ?></span> sản phẩm) 
    <span class="fw-bold" id="cart-total"><?= number_format($total, 0, ',', '.') ?>₫</span></p>
    <p>Các mặt hàng trong giỏ hàng của bạn không được bảo lưu — hãy kiểm tra ngay để đặt hàng.</p>

    <div class="row">
        <div class="col-lg-8" id="cart-items">
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="cart-item d-flex mb-3 p-3 border rounded">
                        <?php
                        $images = isset($item['images']) ? json_decode($item['images'], true) : [];
                        $first_image = !empty($images[0]) ? "/project/front/upload/" . htmlspecialchars($images[0]) : "/img/default-product.jpg";
                        
                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $first_image)) {
                            $first_image = "/img/default-product.jpg";
                        }
                        ?>
                        <a href="index.php?act=pd_detail&product_id=<?php echo $item['id']; ?>">
                            <img src="<?php echo $first_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100px; height: auto;">
                        </a>

                        <div class="ms-3">
                            <h5><?= htmlspecialchars($item['name']) ?></h5>
                            <p>Giá: <?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                            <div class="quantity-control">
                                <button id="btn-1" class="btn btn-secondary decrease-quantity" data-id="<?php echo $item['id']; ?>">-</button>
                                <!-- <span class="quantity"></span> -->
                                 <input class="quantity" type="number" name="" id="inp-nb" value="<?= $item['quantity'] ?>">
                                <button id="btn-2" class="btn btn-secondary increase-quantity" data-id="<?php echo $item['id']; ?>">+</button>


                            </div>
                            <button class="btn btn-danger btn-sm remove-item" data-id="<?php echo $item['id']; ?>">Xóa</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Giỏ hàng của bạn đang trống.</p>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body position-relative">
                    <button class="btn btn-danger w-100 mb-3" onclick="removeAllItems()">Xóa tất cả</button>
                    <h5 class="card-title fw-bold">TÓM TẮT ĐƠN HÀNG</h5>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span id="summary-count"><?= count($_SESSION['cart']) ?> sản phẩm</span>
                        <span id="summary-total" class="summary-total"><?= number_format($total, 0, ',', '.') ?>₫</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Giao hàng</span>
                        <span>Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span class="total-label">Tổng tiền đơn hàng</span>
                        <span id="final-total" class="summary-total total-value"><?= number_format($total, 0, ',', '.') ?>₫</span>
                    </div>
                    <button class="btn btn-dark w-100 mt-3" id="checkout-button">THANH TOÁN</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal cho thông tin thanh toán -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Thông Tin Thanh Toán</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tên Người Nhận:</label>
                        <input type="text" class="form-control" id="recipient-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-phone" class="col-form-label">Số Điện Thoại:</label>
                        <input type="tel" class="form-control" id="recipient-phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-address" class="col-form-label">Địa Chỉ Giao Hàng:</label>
                        <input type="text" class="form-control" id="recipient-address" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-custom" id="confirm-checkout">Xác Nhận Thanh Toán</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

    document.getElementById("cart-items").addEventListener("click", function (e) {
        if (e.target.classList.contains("increase-quantity")) {
            const productId = e.target.dataset.id;
            updateQuantity(productId, 'increase', e.target);
        } else if (e.target.classList.contains("decrease-quantity")) {
            const productId = e.target.dataset.id;
            updateQuantity(productId, 'decrease', e.target);
        }
    });

    document.querySelectorAll(".increase-quantity").forEach(button => {
        button.addEventListener("click", function () {
            const productId = this.dataset.id;
            updateQuantity(productId, 'increase');
        });
    });

    document.querySelectorAll(".decrease-quantity").forEach(button => {
        button.addEventListener("click", function () {
            const productId = this.dataset.id;
            updateQuantity(productId, 'decrease');
        });
    });

    function updateQuantity(productId, action, button) {
        fetch('http://localhost/Project/front/view/cart_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'update_quantity', product_id: productId, update_action: action })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const quantityInput = button.parentElement.querySelector(".quantity");
                quantityInput.value = data.new_quantity;

                document.getElementById("cart-total").textContent = data.new_total.toLocaleString() + "₫";
                document.getElementById("summary-total").textContent = data.new_total.toLocaleString() + "₫";
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }

    document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", function () {
            const productId = this.dataset.id;
            fetch('http://localhost/Project/front/view/cart_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'remove_item', product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => console.error("Error:", error));
        });
    });

    function removeAllItems() {
        fetch('http://localhost/Project/front/view/cart_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'remove_all' })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                location.reload();
            }
        })
        .catch(error => console.error("Error:", error));
    }


    document.getElementById("checkout-button").addEventListener("click", function () {
        var myModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        myModal.show();
    });

    document.getElementById("confirm-checkout").addEventListener("click", function () {
        const totalAmount = parseInt(document.getElementById("final-total").textContent.replace("₫", "").replace(",", "")) || 0;
        const name = document.getElementById("recipient-name").value;
        const phone = document.getElementById("recipient-phone").value;
        const address = document.getElementById("recipient-address").value;

        // Kiểm tra thông tin thanh toán
        if (!name || !phone || !address) {
            alert("Vui lòng điền đầy đủ thông tin để thanh toán.");
            return;
        }

        fetch("http://localhost/Project/front/view/cart_handler.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                action: "checkout",
                total: totalAmount,
                name: name,
                phoneNumber: phone,
                address: address
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                window.location.reload();
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>
</body>
</html>


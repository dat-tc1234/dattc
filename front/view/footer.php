<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quạt Store - Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .footer {
            background-color: #f4f5f7;
            color: #333;
        }
        .footer .social-section {
            background-color: #0077be; /* Ocean blue */
            color: #fff;
        }
        .footer h6 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0077be; /* Ocean blue */
        }
        .footer a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #0077be; /* Ocean blue */
        }
        .footer hr {
            width: 60px;
            border-width: 2px;
            border-color: #0077be; /* Ocean blue */
        }
        .footer .text-muted {
            font-size: 0.9rem;
        }
        .social-icons a {
            color: #fff;
            font-size: 1.2rem;
            margin-right: 10px;
            transition: transform 0.2s ease;
        }
        .social-icons a:hover {
            transform: scale(1.1);
        }
        .footer .contact-info i {
            color: #0077be; /* Ocean blue */
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="footer">
    <div class="container py-5">
        <!-- Social Media Section -->
        <section class="social-section d-flex justify-content-between align-items-center p-3">
            <div>
                <span>Kết nối với chúng tôi trên mạng xã hội:</span>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </section>

        <!-- Footer Links -->
        <section class="text-center text-md-start mt-5">
            <div class="container">
                <div class="row">
                    <!-- Company Info -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <h6 class="text-uppercase">Quạt Store</h6>
                        <hr class="my-2">
                        <p class="text-muted">Chuyên cung cấp các loại quạt điện cao cấp, hiện đại cho mọi nhu cầu. Đem lại làn gió mát và thoáng đãng cho không gian của bạn.</p>
                    </div>

                    <!-- Product Links -->
                    <div class="col-lg-2 col-md-3 mb-4">
                        <h6 class="text-uppercase">Sản phẩm</h6>
                        <hr class="my-2">
                        <ul class="list-unstyled">
                            <li><a href="#">Quạt trần</a></li>
                            <li><a href="#">Quạt đứng</a></li>
                            <li><a href="#">Quạt hộp</a></li>
                            <li><a href="#">Quạt treo tường</a></li>
                        </ul>
                    </div>

                    <!-- Useful Links -->
                    <div class="col-lg-2 col-md-3 mb-4">
                        <h6 class="text-uppercase">Liên kết hữu ích</h6>
                        <hr class="my-2">
                        <ul class="list-unstyled">
                            <li><a href="#">Tài khoản của bạn</a></li>
                            <li><a href="#">Trở thành đối tác</a></li>
                            <li><a href="#">Chính sách vận chuyển</a></li>
                            <li><a href="#">Hỗ trợ</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-4 col-md-6 mb-4 contact-info">
                        <h6 class="text-uppercase">Liên hệ</h6>
                        <hr class="my-2">
                        <p><i class="fas fa-home"></i> TP. Hà Nội, Việt Nam</p>
                        <p><i class="fas fa-envelope"></i> contact@quatstore.com</p>
                        <p><i class="fas fa-phone"></i> +84 123 456 789</p>
                        <p><i class="fas fa-print"></i> +84 987 654 321</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.1);">
            © 2024 Bản quyền thuộc về:
            <a class="text-dark" href="https://quatstore.com">Quạt Store</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

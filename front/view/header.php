<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quạt Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #ffecb3);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .navbar-container {
            width: 100%;
            padding: 0 20px;
        }

        .custom-logo {
            max-width: 100%;
            height: auto;
        }

        /* Fan Animation */
        .rotating-fan {
            font-size: 2rem;
            color: #007bff;
            animation: spin 3s linear infinite;
            margin-right: 10px;
        }

        /* Additional Fan Icons for Background */
        .fan-icon {
            font-size: 2rem;
            color: rgba(0, 123, 255, 0.2);
            position: absolute;
            opacity: 0.8;
            animation: spin 15s linear infinite;
        }

        .fan-icon-1 {
            top: 10%;
            left: 20%;
            animation-duration: 10s;
        }

        .fan-icon-2 {
            top: 30%;
            right: 25%;
            animation-duration: 8s;
        }

        .fan-icon-3 {
            bottom: 15%;
            left: 15%;
            animation-duration: 12s;
        }

        /* Spin Keyframe */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Navbar Links and Effects */
        .nav-items .nav-link {
            color: #333;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: color 0.3s, background-color 0.3s;
        }

        .nav-items .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            left: 50%;
            bottom: -5px;
            background-color: #007bff;
            transition: all 0.3s ease;
        }

        .nav-items .nav-link:hover::after {
            width: 100%;
            left: 0;
        }

        /* Other Styles, Including Search Form and Icons */
        .custom-icon-links .icon-link {
            font-size: 1.2rem;
            color: #333;
            margin-right: 15px;
            transition: color 0.3s, transform 0.3s ease;
        }

        .custom-icon-links .icon-link:hover {
            color: #007bff;
            transform: rotate(20deg);
        }

        .custom-search-form {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 25px;
            padding: 5px 10px;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .custom-search-input {
            border: none;
            outline: none;
            background: transparent;
            width: 200px;
            padding: 5px 10px;
            transition: width 0.4s;
        }

        .custom-search-input:focus {
            width: 250px;
            background-color: #fff;
        }

        .custom-search-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .custom-search-button:hover {
            background-color: #0056b3;
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.8);
        }

        @media (max-width: 768px) {
            .custom-icon-links {
                display: none;
            }

            .custom-search-form {
                width: 100%;
                padding-top: 10px;
            }

            .custom-search-input {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .navbar-nav {
                text-align: center;
            }

            .custom-search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .custom-search-input {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <nav class="navbar navbar-expand-lg custom-navbar">
            <div class="container-fluid navbar-container">
                <!-- Rotating Fan Icon in the Logo -->
                <a class="navbar-brand custom-brand" href="#">
                    <i class="fas fa-fan rotating-fan"></i> Quạt Store
                </a>

                <!-- Background Fan Icons for Effect -->
                <i class="fas fa-fan fan-icon fan-icon-1"></i>
                <i class="fas fa-fan fan-icon fan-icon-2"></i>
                <i class="fas fa-fan fan-icon fan-icon-3"></i>

                <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse custom-navbar-collapse" id="navbarSupportedContent">
                    <!-- Main Navigation Menu with Margin for Separation -->
                    <ul class="navbar-nav nav-items me-lg-4">
                        <?php if (!isset($categories) || !is_array($categories)) {
                            $categories = [];
                        } ?>
                        <?php foreach ($categories as $category): ?>
                            <li class="nav-item dropdown custom-dropdown">
                                <a class="nav-link dropdown-toggle custom-nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo htmlspecialchars($category['ten_danh_muc']); ?>
                                </a>
                                <ul class="dropdown-menu custom-dropdown-menu">
                                    <?php if (!empty($category['children'])): ?>
                                        <?php foreach ($category['children'] as $child): ?>
                                            <li>
                                                <a class="dropdown-item custom-dropdown-item" href="http://localhost/Project/front/view/category_products.php?category_id=<?php echo $child['id']; ?>">
                                                    <?php echo htmlspecialchars($child['ten_danh_muc']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Login, Register, and Cart Icon Links -->
                    <div class="custom-icon-links d-none d-lg-flex">
                        <?php if (!isset($_SESSION['user'])): ?>
                            <a href="#" class="icon-link" aria-label="Cart" onclick="showLoginAlert(event)">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </a>
                            <a href="#" class="icon-link" aria-label="Favorites" onclick="showLoginAlert(event)">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                            <a href="http://localhost/Project/front/view/login.php" class="icon-link" aria-label="Login">
                                <i class="fa-solid fa-user"></i> Đăng nhập
                            </a>
                            <a href="http://localhost/Project/front/view/register.php" class="icon-link" aria-label="Register">
                                <i class="fa-solid fa-user-plus"></i> Đăng ký
                            </a>
                        <?php else: ?>
                            <a href="http://localhost/Project/front/view/shopping_cart.php" class="icon-link" aria-label="Cart">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </a>
                            <a href="http://localhost/Project/front/view/favorites.php" class="icon-link" aria-label="Favorites">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                            <span class="icon-link" aria-label="User">
                                <strong><?php echo 'Xin chào ' . htmlspecialchars($_SESSION['user']['user_name']); ?></strong>
                            </span>
                            <a href="http://localhost/Project/front/view/logout.php" class="btn btn-link" aria-label="Logout">
                                Đăng xuất
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Search Form -->
                    <form class="custom-search-form" role="search" action="http://localhost/Project/front/view/search.php" method="GET">
                        <input class="form-control custom-search-input" type="search" name="query" placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                        <button class="custom-search-button" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <!-- JavaScript Alert Function -->
    <script>
        function showLoginAlert(event) {
            event.preventDefault();
            alert("Bạn cần đăng nhập để sử dụng tính năng này.");
        }
    </script>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>


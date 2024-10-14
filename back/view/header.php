<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quạt Mát - Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&family=Roboto:wght@300&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Font và nền chính */
        body, .navbar {
            font-family: 'Quicksand', sans-serif;
            background-color: #f0f9ff;
            color: #333;
        }

        /* Navbar gradient mát mẻ */
        .navbar {
            background: linear-gradient(135deg, #74b9ff, #a29bfe);
            padding: 1rem 2rem;
            box-shadow: 0 6px 15px rgba(102, 198, 255, 0.4);
            border-radius: 0 0 30px 30px;
            position: relative;
            overflow: hidden;
        }

        /* Cánh quạt - Icon xoay */
        .fan-icon {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.4);
            position: absolute;
            animation: spin 10s linear infinite;
            opacity: 0.9;
        }
        .fan-icon-1 { top: 15%; left: 10%; }
        .fan-icon-2 { top: 30%; right: 15%; animation-duration: 12s; }
        .fan-icon-3 { bottom: 20%; left: 20%; animation-duration: 8s; }
        .fan-icon-4 { bottom: 25%; right: 20%; animation-duration: 6s; }

        /* Hiệu ứng xoay */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Navbar brand với hiệu ứng mộng mơ */
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: transform 0.3s, text-shadow 0.4s;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        /* Hiệu ứng hover cho navbar brand */
        .navbar-brand:hover {
            transform: scale(1.1);
            text-shadow: 0 6px 14px rgba(0, 0, 0, 0.35);
        }

        /* Nav-link với màu sắc dịu nhẹ */
        .navbar-nav .nav-link {
            color: #fefefe !important;
            font-size: 1.1rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: background 0.4s, color 0.4s;
            position: relative;
        }

        /* Thêm hiệu ứng hover với màu gradient */
        .navbar-nav .nav-link:hover {
            background: linear-gradient(135deg, #f8e1ff, #d4e4ff);
            color: #ffffff !important;
            box-shadow: 0 5px 10px rgba(102, 198, 255, 0.3);
        }

        /* Dropdown menu */
        .dropdown-menu {
            background: #a29bfe;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border: none;
        }

        /* Dropdown item */
        .dropdown-item {
            color: #ffffff;
            font-weight: 500;
            transition: background 0.3s, color 0.3s;
        }

        /* Hover cho dropdown */
        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #f0f9ff;
        }
    </style>
</head>
<body>
    <!-- Navbar với icon động và gradient -->
    <nav class="navbar navbar-expand-lg">
        <!-- Icon quạt xoay với tốc độ khác nhau -->
        <i class="fas fa-fan fan-icon fan-icon-1"></i>
        <i class="fas fa-fan fan-icon fan-icon-2"></i>
        <i class="fas fa-fan fan-icon fan-icon-3"></i>
        <i class="fas fa-fan fan-icon fan-icon-4"></i>

        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-fan fa-spin"></i> Quạt Mát Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=danh_muc">Danh Mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=san_pham">Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=them_nguoi_dung">Người Dùng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=don_hang">Đơn Hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=hidden_items">Mục Ẩn</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> Tài Khoản
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Hồ Sơ</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Cài Đặt</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

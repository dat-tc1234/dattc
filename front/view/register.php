<?php
session_start();
require_once 'C:\xampp\htdocs\Project\database\connect_db.php'; // Điều chỉnh đường dẫn cho đúng

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['pwd']);
    $confirmPassword = trim($_POST['cpwd']);
    
    // Kiểm tra mật khẩu có khớp không
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Mật khẩu và xác nhận mật khẩu không khớp.';
        header("Location: register.php");
        exit();
    }

    // Kiểm tra email đã tồn tại chưa
    try {
        $conn = connect_db();
        if ($conn) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $_SESSION['error'] = 'Email đã tồn tại. Vui lòng sử dụng email khác.';
                header("Location: register.php");
                exit();
            }

            // Mã hóa mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Thêm người dùng mới vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO user (user_name, email, password, role, hien_thi_user) VALUES (:user_name, :email, :password, :role, :hien_thi_user)");
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindValue(':role', 'user'); // Thiết lập role là 'user'
            $stmt->bindValue(':hien_thi_user', 1); // Thiết lập hien_thi_user là 1 (hiển thị)

            if ($stmt->execute()) {
                $_SESSION['success'] = 'Đăng ký thành công! Bạn có thể đăng nhập ngay.';
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = 'Đã có lỗi xảy ra trong quá trình đăng ký.';
            }
            close_db_connection($conn);
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
    }
}
?>




<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #a8e063, #56ab2f);
            color: #333;
            overflow: hidden;
        }
        .container-fluid {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 1200px;
            margin-top: 40px;
        }
        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #56ab2f;
            font-size: 1.8rem;
            font-weight: bold;
        }
        .icon i {
            font-size: 2.5rem;
            margin-right: 10px;
        }
        .form-control {
            border-radius: 50px;
            padding: 15px;
            font-size: 1.1rem;
        }
        .btn-primary {
            background-color: #56ab2f;
            border: none;
            border-radius: 50px;
            padding: 12px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #3a8131;
            transform: scale(1.05);
        }
        .left {
            padding: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px 0 0 15px;
        }
        .right {
            background: url("http://localhost/Project/img/logo_fanimation.png") no-repeat center center;
            background-size: cover;
            border-radius: 0 15px 15px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
        }
        .right .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            width: 100%;
            height: 100%;
            border-radius: 0 15px 15px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            text-align: center;
        }
        .right .overlay h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .right .overlay p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .link-info {
            color: #56ab2f;
            text-decoration: none;
        }
        .link-info:hover {
            color: #3a8131;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="left col-md-6">
            <div class="icon mb-4">
                <i class="bi bi-fan"></i> QuạtStore
            </div>
            <h3 class="mb-4">Đăng ký tài khoản của bạn</h3>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tên người dùng" required>
                    <label for="name">Tên người dùng</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mật khẩu" required>
                    <label for="pwd">Mật khẩu</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="cpwd" name="cpwd" placeholder="Xác nhận mật khẩu" required>
                    <label for="cpwd">Xác nhận mật khẩu</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Đăng ký</button>
                <div class="text-center">
                    <p>Đã có tài khoản? <a href="login.php" class="link-info">Đăng nhập ngay!</a></p>
                </div>
            </form>
        </div>
        <div class="right col-md-6">
            <div class="overlay">
                <h1>Chào mừng đến QuạtStore!</h1>
                <p>Cửa hàng quạt điện hàng đầu cho mọi nhu cầu làm mát của bạn.</p>
                <p>Trải nghiệm sự thoáng mát, công nghệ hiện đại, và dịch vụ tận tâm tại QuạtStore.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>

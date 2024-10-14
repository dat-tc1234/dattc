<?php

function add_user($name, $email, $password) {
    $conn = connect_db();
    $stmt = $conn->prepare("INSERT INTO user (user_name, email, password) VALUES (:name, :email, :password)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    
    return $stmt->execute();
}

function authenticate_user($username, $password) {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_name = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['hien_thi_user'] == 1) {
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user'] = [
                'user_name' => $user['user_name'],
                'email' => $user['email'],
                // Thêm các thông tin khác nếu cần
            ];
            return $user; 
        }
    }
    return false;
}
function is_username_exists($username) {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE user_name = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    return $count > 0; 
}

?>
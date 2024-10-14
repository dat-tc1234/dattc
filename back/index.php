<?php
session_start();
ob_start();
include "../database/connect_db.php";
include "model/danh_muc.php";
include "model/san_pham.php";
include "model/user.php";
include_once "model/review.php";


connect_db();
include "view/header.php";

if (isset($_GET['act'])) {
    switch ($_GET['act']) {

        case 'danh_muc':
            $kq = getall_dm();
            include "view/danh_muc.php";
            break;

        case 'adding_category':
            if (isset($_POST['add_new'])) {
                $ten_danh_muc = $_POST['ten_danh_muc'];
                $parent_id = $_POST['parent_id'];
                add_category($ten_danh_muc, $parent_id);
                $_SESSION['success'] = "Thêm danh mục thành công!";
            }
            header("Location: index.php?act=danh_muc");
            exit();
            break;

        case 'update_category':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $dm = get_category($id);
                $kq = getall_dm();
                include "view/update_category.php";
            }
            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $ten_danh_muc = $_POST['ten_danh_muc'];
                $parent_id = $_POST['parent_id'];
                update_category($id, $ten_danh_muc, $parent_id);
                $_SESSION['success'] = "Cập nhật danh mục thành công!";
                header("Location: index.php?act=danh_muc");
                exit();
            }
            break;

        case 'delete_category':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                delete_category($id); // Gọi hàm delete_category để ẩn danh mục
                $_SESSION['success'] = "Ẩn danh mục thành công!";
            }
            // Cập nhật lại danh sách sau khi ẩn mà không chuyển hướng
            $kq = getall_dm();
            include "view/danh_muc.php";
            break;

        case 'restore_category':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                restore_category($id); // Gọi hàm khôi phục danh mục
                $_SESSION['success'] = "Khôi phục danh mục thành công!";
            }
            // Tải lại danh sách các mục đã ẩn
            $hidden_categories = get_hidden_categories();
            $hidden_products = get_hidden_products();
            $hidden_users = get_hidden_users();
            $hidden_reviews = get_hidden_reviews();
            include "view/muc_an.php"; // Hiển thị lại trang mục ẩn
            break;


        case 'muc_an':
            $hidden_categories = get_hidden_categories(); // Lấy danh mục ẩn
            include "view/muc_an.php";
            break;

        case 'san_pham':
            $dsdm = getall_dm();
            $items_per_page = 10;
            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $total_items = count_san_pham();
            $total_pages = ceil($total_items / $items_per_page);
            $start = ($current_page - 1) * $items_per_page;

            $kq = get_products_paginated($start, $items_per_page);
            include "view/san_pham.php";
            break;

        case 'add_san_pham':
            if (isset($_POST['add_new'])) {
                $ten_sp = $_POST['ten_sp'];
                $gia = $_POST['gia'];
                $id_danh_muc = $_POST['id_dm'];
                $mo_ta_sp = $_POST['mo_ta_sp'];
                $so_luong_hang = $_POST['so_luong_hang'];
                $cong_suat = $_POST['cong_suat'];
                $cong_nghe = $_POST['cong_nghe'];
                $chat_lieu = $_POST['chat_lieu'];
                $chuc_nang = $_POST['chuc_nang'];
                $so_canh = $_POST['so_canh'];
                $toc_do = $_POST['toc_do'];

                $images = array();
                if (isset($_FILES['imgs'])) {
                    $file_count = count($_FILES['imgs']['name']);
                    for ($i = 0; $i < $file_count; $i++) {
                        if ($_FILES['imgs']['error'][$i] == 0) {
                            $target_dir = "../upload/";
                            $target_file = $target_dir . basename($_FILES["imgs"]["name"][$i]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $newFileName = uniqid() . '.' . $imageFileType;
                            $target_file = $target_dir . $newFileName;
                            if (move_uploaded_file($_FILES["imgs"]["tmp_name"][$i], $target_file)) {
                                $images[] = $target_file;
                            }
                        }
                    }
                }

                $new_arrival = isset($_POST['new_arrival']) ? 1 : 0;
                $featured = isset($_POST['featured']) ? 1 : 0;
                $best_seller = isset($_POST['best_seller']) ? 1 : 0;

                insert_product($id_danh_muc, $ten_sp, $gia, $so_luong_hang, $mo_ta_sp, $images, $cong_suat, $cong_nghe, $chat_lieu, $chuc_nang, $so_canh, $toc_do, $new_arrival, $featured, $best_seller);
                $_SESSION['success'] = "Thêm sản phẩm thành công!";
                header("Location: index.php?act=san_pham");
                exit();
            }
            break;

        case 'update_san_pham':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sp = get_product($id);
                $dsdm = getall_dm();
                include "view/update_san_pham.php";
            }
            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $ten_sp = $_POST['ten_sp'];
                $gia = $_POST['gia'];
                $so_luong_hang = $_POST['so_luong_hang'];
                $mo_ta_sp = $_POST['mo_ta_sp'];
                $id_danh_muc = $_POST['id_dm'];
                $cong_suat = $_POST['cong_suat'];
                $cong_nghe = $_POST['cong_nghe'];
                $chat_lieu = $_POST['chat_lieu'];
                $chuc_nang = $_POST['chuc_nang'];
                $so_canh = $_POST['so_canh'];
                $toc_do = $_POST['toc_do'];

                $new_arrival = isset($_POST['new_arrival']) ? 1 : 0;
                $featured = isset($_POST['featured']) ? 1 : 0;
                $best_seller = isset($_POST['best_seller']) ? 1 : 0;

                $images = array();
                if (isset($_FILES['imgs'])) {
                    $file_count = count($_FILES['imgs']['name']);
                    for ($i = 0; $i < $file_count; $i++) {
                        if ($_FILES['imgs']['error'][$i] == 0) {
                            $target_dir = "../upload/";
                            $target_file = $target_dir . basename($_FILES["imgs"]["name"][$i]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $newFileName = uniqid() . '.' . $imageFileType;
                            $target_file = $target_dir . $newFileName;
                            if (move_uploaded_file($_FILES["imgs"]["tmp_name"][$i], $target_file)) {
                                $images[] = $target_file;
                            }
                        }
                    }
                }

                $images_json = !empty($images) ? json_encode($images) : "";

                update_product($id, $ten_sp, $gia, $so_luong_hang, $mo_ta_sp, $id_danh_muc, $cong_suat, $cong_nghe, $chat_lieu, $chuc_nang, $so_canh, $toc_do, $images_json, $new_arrival, $featured, $best_seller);
                $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
                header("Location: index.php?act=san_pham");
                exit();
            }
            break;

        case 'restore_product':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                restore_product($id);
                $_SESSION['success'] = "Khôi phục sản phẩm thành công!";
            }
            $hidden_categories = get_hidden_categories();
            $hidden_products = get_hidden_products();
            $hidden_users = get_hidden_users();
            $hidden_reviews = get_hidden_reviews();
            include "view/muc_an.php";
            break;

        case 'them_nguoi_dung':
            if (isset($_POST['add_user'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $email = $_POST['email'];

                if ($password !== $confirm_password) {
                    $_SESSION['error'] = "Mật khẩu và xác nhận mật khẩu không khớp!";
                } else {
                    $result = add_user($username, $password, $email);

                    if ($result) {
                        $_SESSION['success'] = "Thêm người dùng thành công!";
                    } else {
                        $_SESSION['error'] = "Có lỗi xảy ra khi thêm người dùng!";
                    }
                }
            }

            $users = get_all_users();
            include "view/user.php";
            break;
        case 'hide_user':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                hide_user($id);
                $_SESSION['success'] = "Ẩn người dùng thành công!";
            }

            $users = get_all_users();
            include "view/user.php";
            break;



        case 'restore_user':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                restore_user($id);
                $_SESSION['success'] = "Khôi phục người dùng thành công!";
            }
            $hidden_categories = get_hidden_categories();
            $hidden_products = get_hidden_products();
            $hidden_users = get_hidden_users();
            $hidden_reviews = get_hidden_reviews();
            include "view/muc_an.php";
            break;

        case 'hidden_items':
            $hidden_categories = get_hidden_categories(); // Lấy danh mục ẩn
            $hidden_products = get_hidden_products(); // Lấy sản phẩm ẩn
            $hidden_users = get_hidden_users(); // Lấy người dùng ẩn
            include "model/review.php";
            $hidden_reviews = get_hidden_reviews(); // Lấy đánh giá ẩn
            include "view/muc_an.php";
            break;




        case 'danh_gia_va_phan_hoi_khach_hang':
            include "model/review.php";
            if (isset($_GET['action']) && $_GET['action'] == 'hide' && isset($_GET['id'])) {
                $review_id = $_GET['id'];
                if (hide_review($review_id)) {
                    $_SESSION['success'] = "Ẩn bình luận thành công!";
                } else {
                    $_SESSION['error'] = "Không thể ẩn bình luận. Vui lòng thử lại.";
                }
                header("Location: index.php?act=danh_gia_va_phan_hoi_khach_hang");
                exit();
            }
            $reviews = get_all_reviews();
            include "view/review.php";
            break;


        case 'restore_review':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                restore_review($id);
                $_SESSION['success'] = "Khôi phục đánh giá thành công!";
            }
            $hidden_categories = get_hidden_categories();
            $hidden_products = get_hidden_products();
            $hidden_users = get_hidden_users();
            $hidden_reviews = get_hidden_reviews();
            include "view/muc_an.php";
            break;

        case 'don_hang':
            include "view/don_hang.php";
            break;

        default:
            include "view/home.php";
            break;
    }
} else {
    include "view/home.php";
}

include "view/footer.php";

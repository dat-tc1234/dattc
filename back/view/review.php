<div class="container-fluid flex-grow-1 pt-4">
    <h1 class="mb-4 text-center">Quản lý đánh giá và phản hồi khách hàng</h1>
    <div class="container"> <!-- Thêm container này -->
        <div class="w-100 mx-auto" >
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-striped">
                        <tr>
                            <th class="text-center align-middle" style="width: 5%;">STT</th> <!-- Thay đổi tiêu đề cột -->
                            <th class="text-center align-middle" style="width: 15%;">Sản phẩm</th>
                            <th class="text-center align-middle" style="width: 15%;">Khách hàng</th>
                            <th class="text-center align-middle" style="width: 10%;">Đánh giá</th>
                            <th class="text-center align-middle" style="width: 25%;">Bình luận</th>
                            <th class="text-center align-middle" style="width: 15%;">Ngày đăng</th>
                            <th class="text-center align-middle" style="width: 15%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td class="text-center align-middle"><?php echo htmlspecialchars($review['id']); ?></td>
                    <td class="text-center align-middle"><?php echo isset($review['ten_sp']) ? htmlspecialchars($review['ten_sp']) : 'Không có tên sản phẩm'; ?></td>
                    <td class="text-center align-middle"><?php echo isset($review['user_name']) ? htmlspecialchars($review['user_name']) : 'Không có tên người dùng'; ?></td>
                    <td class="text-center align-middle"><?php echo htmlspecialchars($review['danh_gia']) . ' sao'; ?></td>
                    <td class="text-center align-middle"><?php echo htmlspecialchars($review['binh_luan']); ?></td>
                    <td class="text-center align-middle"><?php echo htmlspecialchars($review['ngay_bl']); ?></td>
                    <td class="text-center align-middle">
                        <a href="index.php?act=hide_review&id=<?php echo $review['id']; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Bạn có chắc muốn ẩn bình luận này?')">Ẩn</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
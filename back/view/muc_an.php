<h1 class="mb-5 text-center pt-4">Các mục đã ẩn</h1>

<div class="container">
    <?php if (isset($_SESSION['success'])): ?>
        <script>
            showSuccessAlert("Thành công!", "<?php echo $_SESSION['success']; ?>");
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Danh mục đã ẩn -->
    <div class="w-75 mx-auto">
        <h3 class="mt-5 mb-4 pt-4">Danh mục đã ẩn</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-striped">
                    <tr>
                        <th class="text-center align-middle" style="width: 10%;">STT</th>
                        <th class="text-center align-middle" style="width: 60%;">Tên danh mục</th>
                        <th class="text-center align-middle" style="width: 30%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt_category = 1; ?>
                    <?php foreach ($hidden_categories as $dm): ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo $stt_category++; ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($dm['ten_danh_muc']); ?></td>
                        <td class="text-center align-middle">
                            <a href="#" class="btn btn-sm btn-success" onclick="confirmRestore('index.php?act=restore_category&id=<?php echo $dm['id']; ?>')">Khôi phục</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sản phẩm đã ẩn -->
    <div class="w-75 mx-auto">
        <h3 class="mt-5 mb-4 pt-4">Sản phẩm đã ẩn</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-striped">
                    <tr>
                        <th class="text-center align-middle" style="width: 10%;">STT</th>
                        <th class="text-center align-middle" style="width: 40%;">Tên sản phẩm</th>
                        <th class="text-center align-middle" style="width: 20%;">Giá</th>
                        <th class="text-center align-middle" style="width: 30%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt_product = 1; ?>
                    <?php foreach ($hidden_products as $sp): ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo $stt_product++; ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($sp['ten_sp']); ?></td>
                        <td class="text-center align-middle"><?php echo number_format($sp['gia'], 0, ',', '.'); ?> đ</td>
                        <td class="text-center align-middle">
                            <a href="#" class="btn btn-sm btn-success" onclick="confirmRestore('index.php?act=restore_product&id=<?php echo $sp['id']; ?>')">Khôi phục</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Người dùng đã ẩn -->
    <div class="w-75 mx-auto">
        <h3 class="mt-5 mb-4 pt-4">Người dùng đã ẩn</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-striped">
                    <tr>
                        <th class="text-center align-middle" style="width: 10%;">STT</th>
                        <th class="text-center align-middle" style="width: 30%;">Tên đăng nhập</th>
                        <th class="text-center align-middle" style="width: 30%;">Email</th>
                        <th class="text-center align-middle" style="width: 30%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt_user = 1; ?>
                    <?php foreach ($hidden_users as $user): ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo $stt_user++; ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($user['user_name']); ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="text-center align-middle">
                            <a href="#" class="btn btn-sm btn-success" onclick="confirmRestore('index.php?act=restore_user&id=<?php echo $user['id']; ?>')">Khôi phục</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Đánh giá đã ẩn -->
    <div class="w-100 mx-auto">
        <h3 class="mt-5 mb-4 pt-4">Đánh giá đã ẩn</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-striped">
                    <tr>
                        <th class="text-center align-middle" style="width: 5%;">STT</th>
                        <th class="text-center align-middle" style="width: 20%;">Sản phẩm</th>
                        <th class="text-center align-middle" style="width: 15%;">Người dùng</th>
                        <th class="text-center align-middle" style="width: 10%;">Đánh giá</th>
                        <th class="text-center align-middle" style="width: 30%;">Bình luận</th>
                        <th class="text-center align-middle" style="width: 20%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt_review = 1; ?>
                    <?php foreach ($hidden_reviews as $review): ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo $stt_review++; ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($review['ten_sp']); ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($review['user_name']); ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($review['danh_gia']); ?> sao</td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($review['binh_luan']); ?></td>
                        <td class="text-center align-middle">
                            <a href="#" class="btn btn-sm btn-success" onclick="confirmRestore('index.php?act=restore_review&id=<?php echo $review['id']; ?>')">Khôi phục</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmRestore(url) {
        if (confirm('Bạn có chắc muốn khôi phục mục này?')) {
            window.location.href = url;
        }
    }
</script>

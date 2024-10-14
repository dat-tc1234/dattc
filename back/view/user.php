<h1 class="mb-4 text-center pt-4">Thêm Người Dùng Mới</h1>
<div class="row justify-content-center">
    <div class="col-md-3">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <script>
                showSuccessAlert("Thành công!", "<?php echo $_SESSION['success']; ?>");
            </script>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="index.php?act=them_nguoi_dung" method="POST" class="mb-5">
            <div class="form-group mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
            </div>
            <div class="form-group mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="add_user">Thêm người dùng</button>
            </div>
        </form>
    </div>
</div>

<h1 class="mt-5 mb-4 text-center">Danh sách người dùng</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered border-dark w-50 mx-auto">
        <thead class="table-striped">
            <tr>
                <th class="text-center align-middle" style="width: 10%">STT</th>
                <th class="text-center align-middle" style="width: 30%">Tên đăng nhập</th>
                <th class="text-center align-middle" style="width: 40%">Email</th>
                <th class="text-center align-middle" style="width: 20%">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $index => $user): ?>
            <tr>
                <td class="text-center align-middle"><?php echo $index + 1; ?></td>
                <td class="text-center align-middle"><?php echo htmlspecialchars($user['user_name']); ?></td>
                <td class="text-center align-middle"><?php echo htmlspecialchars($user['email']); ?></td>
                <td class="text-center align-middle">
                    <a href="#" class="btn btn-warning btn-sm" onclick="confirmHideUser('<?php echo $user['id']; ?>')">Ẩn</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- JavaScript để xác nhận ẩn người dùng -->
<script>
    function confirmHideUser(userId) {
        if (confirm("Bạn có chắc chắn muốn ẩn người dùng này không?")) {
            window.location.href = `index.php?act=hide_user&id=${userId}`;
        }
    }
</script>

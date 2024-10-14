<div class="container-fluid flex-grow-1 pt-4">
    <h1 class="mb-4 text-center">Category Management</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>


    <!-- Form Thêm Danh Mục Mới -->
    <form action="index.php?act=adding_category" method="post" class="category-form mb-4">
        <div class="row justify-content-center">
            <div class="col-md-2 mb-3">
                <input type="text" class="form-control" name="ten_danh_muc" placeholder="Category name" required>
            </div>
            <div class="col-md-2 mb-3">
                <select class="form-control" name="parent_id">
                    <option value="0">Original catalog</option>
                    <?php
                    // Hàm đệ quy tạo danh sách tùy chọn danh mục
                    function buildCategoryOptions($categories, $parent_id = 0, $level = 0)
                    {
                        $result = '';
                        foreach ($categories as $dm) {
                            if ($dm['parent_id'] == $parent_id) {
                                $result .= '<option value="' . $dm['id'] . '">' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . $dm['ten_danh_muc'] . '</option>';
                                $result .= buildCategoryOptions($categories, $dm['id'], $level + 1);
                            }
                        }
                        return $result;
                    }
                    echo buildCategoryOptions($kq); // Hiển thị danh mục chọn
                    ?>
                </select>
            </div>
        </div>
        <div class="text-center mb-3">
            <button type="submit" name="add_new" class="btn btn-primary">Add new</button>
        </div>
    </form>

    <!-- Bảng Danh Mục -->
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered w-50 mx-auto">
            <thead class="thead-striped">
                <tr>
                    <th class="text-center" style="width: 15%">SN</th>
                    <th class="text-center" style="width: 55%">Category name</th>
                    <th class="text-center" style="width: 30%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Hàm hiển thị danh mục với cấp độ lồng nhau
                function displayCategories($categories, $parent_id = 0, $level = 0, &$stt = 1)
                {
                    foreach ($categories as $dm) {
                        if ($dm['parent_id'] == $parent_id) {
                            $bg_class = $level == 0 ? 'table-primary' : '';
                            $padding_left = 40 * $level; // Thêm độ thụt lề cho cấp con
                            echo '<tr class="' . $bg_class . '">
                                    <td class="text-center align-middle">' . $stt++ . '</td>
                                    <td class="align-middle" style="padding-left: ' . $padding_left . 'px;">' . $dm['ten_danh_muc'] . '</td>
                                    <td class="text-center align-middle">
                                        <a href="index.php?act=update_category&id=' . $dm['id'] . '" class="btn btn-sm btn-warning w-25">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete(event, ' . $dm['id'] . ')">Hide</a>
                                    </td>
                                  </tr>';
                            displayCategories($categories, $dm['id'], $level + 1, $stt); // Đệ quy hiển thị danh mục con
                        }
                    }
                }
                $stt = 1;
                displayCategories($kq, 0, 0, $stt); // Hiển thị danh mục từ cấp 0
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Hàm xác nhận xóa
    function confirmDelete(event, id) {
        event.preventDefault();
        if (confirm("Bạn có muốn ẩn danh mục này không ?")) {
            window.location.href = `index.php?act=delete_category&id=${id}`;
        }
    }
</script>
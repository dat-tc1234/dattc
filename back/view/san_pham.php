<div class="container-fluid flex-grow-1 pt-4">
    <h1 class="mb-4 text-center">Quản lý sản phẩm</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <script>
            showSuccessAlert("Thành công!", "<?php echo $_SESSION['success']; ?>");
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form action="index.php?act=add_san_pham" method="post" enctype="multipart/form-data" class="mb-4" id="productForm">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" id="ten_sp" name="ten_sp" placeholder="Nhập tên sản phẩm" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="number" class="form-control" id="gia" name="gia" placeholder="Nhập giá sản phẩm" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="number" class="form-control" id="so_luong_hang" name="so_luong_hang" placeholder="Nhập số lượng" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="form-control" id="id_dm" name="id_dm" required>
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($dsdm as $dm): ?>
                                <option value="<?php echo $dm['id']; ?>"><?php echo $dm['ten_danh_muc']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" id="cong_suat" name="cong_suat" placeholder="Nhập công suất" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" id="cong_nghe" name="cong_nghe" placeholder="Nhập công nghệ" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" id="chat_lieu" name="chat_lieu" placeholder="Nhập chất liệu" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" id="chuc_nang" name="chuc_nang" placeholder="Nhập chức năng" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" id="so_canh" name="so_canh" placeholder="Nhập số cánh" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" id="toc_do" name="toc_do" placeholder="Nhập tốc độ" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="file" class="form-control" id="imgs" name="imgs[]" multiple required accept="image/*">
                        <small class="form-text text-muted">Chọn tối đa 6 ảnh (jpg, jpeg, png, gif)</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <textarea class="form-control" id="mo_ta_sp" name="mo_ta_sp" rows="5" placeholder="Nhập mô tả sản phẩm" required></textarea>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <label class="me-5"><input type="checkbox" name="new_arrival" value="1"> New Arrivals</label>
                    <label class="me-5"><input type="checkbox" name="featured" value="1"> Featured Products</label>
                    <label class="me-5"><input type="checkbox" name="best_seller" value="1"> Best Sellers</label>
                </div>
                <div class="text-center mb-3">
                    <button type="submit" name="add_new" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr class="text-center">
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Mô tả</th>
                <th>Thông số kỹ thuật</th>
                <th>Ngày đăng</th>
                <th>Trạng thái</th> <!-- Thêm cột trạng thái -->
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Lấy sản phẩm từ cơ sở dữ liệu dựa trên checkbox
        $kq = get_products_based_on_filters(); // Hàm này sẽ được định nghĩa bên dưới
        if(isset($kq) && (count($kq) > 0)){
            $start_index = ($current_page - 1) * $items_per_page;
            foreach ($kq as $index => $item){
                $stt = $start_index + $index + 1;
                $ten_danh_muc = '';
                foreach ($dsdm as $dm) {
                    if ($dm['id'] == $item['id_danh_muc']) {
                        $ten_danh_muc = $dm['ten_danh_muc'];
                        break;
                    }
                }

                $status = [];
                if ($item['new_arrival']) {
                    $status[] = 'New Arrivals';
                }
                if ($item['featured']) {
                    $status[] = 'Featured Products';
                }
                if ($item['best_seller']) {
                    $status[] = 'Best Sellers';
                }
                $status_display = !empty($status) ? implode(', ', $status) : 'Không có danh mục';

                echo '<tr class="text-center">
                        <td class="align-middle">'.$stt.'</td>
                        <td class="align-middle">'.$item['ten_sp'].'</td>
                        <td class="align-middle">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#imageModal'.$item['id'].'">
                                Xem ảnh
                            </button>
                        </td>
                        <td class="align-middle">'.$ten_danh_muc.'</td>
                        <td class="align-middle">'.number_format($item['gia'], 0, ',', '.').' đ</td>
                        <td class="align-middle">'.$item['so_luong_hang'].'</td>
                        <td class="align-middle">'.substr($item['mo_ta_sp'], 0, 50).'...</td>
                        <td class="align-middle">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#specModal'.$item['id'].'">
                                Xem chi tiết
                            </button>
                        </td>
                        <td class="align-middle">'.$item['ngay_dang'].'</td>
                        <td class="align-middle">'.$status_display.'</td> <!-- Hiển thị trạng thái -->
                        <td class="align-middle">
                            <div class="d-flex flex-column align-items-center">
                                <a href="index.php?act=update_san_pham&id='.$item['id'].'" class="btn btn-sm btn-warning mb-2 w-50" onclick="return confirmEdit()">Sửa</a>
                                <a href="#" class="btn btn-sm btn-danger w-50" onclick="confirmDelete(function() { window.location.href=\'index.php?act=delete_product&id='.$item['id'].'\'; })">Ẩn</a>
                            </div>
                        </td>
                      </tr>';
            }
        }
        ?>
        </tbody>
    </table>

    <?php
    // Tạo modals cho tất cả sản phẩm
    if(isset($kq) && (count($kq) > 0)){
        foreach ($kq as $item){
            // Modal cho thông số kỹ thuật
            echo '<div class="modal fade" id="specModal'.$item['id'].'" tabindex="-1" role="dialog" aria-labelledby="specModalLabel'.$item['id'].'" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="specModalLabel'.$item['id'].'">Thông số kỹ thuật: '.$item['ten_sp'].'</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <tr><th>Công suất</th><td>'.$item['cong_suat'].'</td></tr>
                                    <tr><th>Công nghệ</th><td>'.$item['cong_nghe'].'</td></tr>
                                    <tr><th>Chất liệu</th><td>'.$item['chat_lieu'].'</td></tr>
                                    <tr><th>Chức năng</th><td>'.$item['chuc_nang'].'</td></tr>
                                    <tr><th>Số cánh</th><td>'.$item['so_canh'].'</td></tr>
                                    <tr><th>Tốc độ</th><td>'.$item['toc_do'].'</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>';

            // Modal cho hình ảnh
            $images = json_decode($item['images'], true);
            echo '<div class="modal fade" id="imageModal'.$item['id'].'" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel'.$item['id'].'" aria-hidden="true">
                    <div class="modal-dialog modal-sl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel'.$item['id'].'">Hình ảnh: '.$item['ten_sp'].'</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="imageCarousel'.$item['id'].'" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">';
                                    if (is_array($images)) {
                                        foreach($images as $index => $image) {
                                            echo '<div class="carousel-item '.($index == 0 ? 'active' : '').'">
                                                    <img src="'.$image.'" class="d-block w-100" alt="'.$item['ten_sp'].'">
                                                  </div>';
                                        }
                                    } else {
                                        echo '<div class="carousel-item active">
                                                <img src="'.$images.'" class="d-block w-100" alt="'.$item['ten_sp'].'">
                                              </div>';
                                    }
                                    echo '</div>
                                    <a class="carousel-control-prev" href="#imageCarousel'.$item['id'].'" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#imageCarousel'.$item['id'].'" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>';
        }
    }
    ?>
</div>
<!-- Pagination -->

<?php
    require_once 'pagination.php';
    echo renderPagination($current_page, $total_pages, '?act=san_pham&page=%d');
?>
<script src="http://localhost/project/public/JS/back_product.js"></script>



<div class="container-fluid flex-grow-1 pt-4">
    <h1 class="mb-4 text-center">Cập nhật sản phẩm</h1>

    <form action="index.php?act=update_san_pham" method="post" enctype="multipart/form-data" class="mb-4" id="updateProductForm">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($sp['id']); ?>">
        
        <div class="row justify-content-center">
            <div class="col-md-2 mb-3">
                <label for="ten_sp" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="ten_sp" name="ten_sp" value="<?php echo htmlspecialchars($sp['ten_sp']); ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="gia" class="form-label">Giá</label>
                <input type="number" class="form-control" id="gia" name="gia" value="<?php echo htmlspecialchars($sp['gia']); ?>" required>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-2 mb-3">
                <label for="so_luong_hang" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="so_luong_hang" name="so_luong_hang" value="<?php echo htmlspecialchars($sp['so_luong_hang']); ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="id_dm" class="form-label">Danh mục</label>
                <select class="form-control" id="id_dm" name="id_dm" required>
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($dsdm as $dm): ?>
                        <option value="<?php echo htmlspecialchars($dm['id']); ?>" <?php if ($dm['id'] == $sp['id_danh_muc']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($dm['ten_danh_muc']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-2 mb-3">
                <label for="cong_suat" class="form-label">Công suất</label>
                <input type="text" class="form-control" id="cong_suat" name="cong_suat" value="<?php echo htmlspecialchars($sp['cong_suat']); ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="cong_nghe" class="form-label">Công nghệ</label>
                <input type="text" class="form-control" id="cong_nghe" name="cong_nghe" value="<?php echo htmlspecialchars($sp['cong_nghe']); ?>" required>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-2 mb-3">
                <label for="chat_lieu" class="form-label">Chất liệu</label>
                <input type="text" class="form-control" id="chat_lieu" name="chat_lieu" value="<?php echo htmlspecialchars($sp['chat_lieu']); ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="chuc_nang" class="form-label">Chức năng</label>
                <input type="text" class="form-control" id="chuc_nang" name="chuc_nang" value="<?php echo htmlspecialchars($sp['chuc_nang']); ?>" required>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-2 mb-3">
                <label for="so_canh" class="form-label">Số cánh</label>
                <input type="text" class="form-control" id="so_canh" name="so_canh" value="<?php echo htmlspecialchars($sp['so_canh']); ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="toc_do" class="form-label">Tốc độ</label>
                <input type="text" class="form-control" id="toc_do" name="toc_do" value="<?php echo htmlspecialchars($sp['toc_do']); ?>" required>
            </div>
        </div>

        <div class="text-center mb-3">
            <label class="me-5"><input type="checkbox" name="new_arrival" value="1" <?php echo $sp['new_arrival'] ? 'checked' : ''; ?>> New Arrivals</label>
            <label class="me-5"><input type="checkbox" name="featured" value="1" <?php echo $sp['featured'] ? 'checked' : ''; ?>> Featured Products</label>
            <label class="me-5"><input type="checkbox" name="best_seller" value="1" <?php echo $sp['best_seller'] ? 'checked' : ''; ?>> Best Sellers</label>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-3 mb-3">
                <label for="imgs" class="form-label">Hình ảnh mới</label>
                <input type="file" class="form-control" id="imgs" name="imgs[]" multiple accept="image/*">
                <small class="form-text text-muted">Chọn tối đa 6 ảnh (jpg, jpeg, png, gif)</small>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <div class="text-center mb-3 mt-4"> 
                    <label class="form-label" style="font-size: 20px; font-weight: bold;">Ảnh cũ</label> 
                </div>
                <div class="d-flex flex-wrap justify-content-center">
                    <?php 
                    $images = json_decode($sp['images'], true);
                    if (is_array($images)): 
                        foreach ($images as $image):
                    ?>
                        <img src="<?php echo htmlspecialchars($image); ?>" alt="Current Image" class="img-thumbnail m-1" style="max-width: 300px; max-height: 200px;">
                    <?php 
                        endforeach;
                    elseif (!empty($sp['images'])): 
                    ?>
                        <img src="<?php echo htmlspecialchars($sp['images']); ?>" alt="Current Image" class="img-thumbnail m-1" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <label for="mo_ta_sp" class="form-label">Mô tả sản phẩm</label>
                <textarea class="form-control" id="mo_ta_sp" name="mo_ta_sp" rows="5" required><?php echo htmlspecialchars($sp['mo_ta_sp']); ?></textarea>
            </div>
        </div>

        <div class="text-center mb-3">
            <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
        </div>
    </form>
</div>
<script src="http://localhost/Project/public/JS/back_product.js"></script>
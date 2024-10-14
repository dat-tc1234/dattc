document.addEventListener('DOMContentLoaded', function() {
    // Xử lý logic tải lên ảnh cho form thêm sản phẩm
    var addProductForm = document.getElementById('productForm');
    if (addProductForm) {
        var addFileInput = addProductForm.querySelector('input[type="file"]');
        
        addProductForm.addEventListener('submit', function(e) {
            if (addFileInput.files.length > 6) {
                e.preventDefault();
                alert('Bạn chỉ được chọn tối đa 6 ảnh.');
            }
        });

        addFileInput.addEventListener('change', function() {
            if (this.files.length > 6) {
                alert('Bạn chỉ được chọn tối đa 6 ảnh.');
                this.value = ''; // Reset input
                return;
            }

            var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            for (var i = 0; i < this.files.length; i++) {
                if (!validTypes.includes(this.files[i].type)) {
                    alert('Chỉ chấp nhận file ảnh có định dạng jpg, jpeg, png hoặc gif.');
                    this.value = ''; // Reset input
                    break;
                }
            }
        });
    }

    // Xử lý logic tải lên ảnh cho form cập nhật sản phẩm
    var updateProductForm = document.getElementById('updateProductForm');
    if (updateProductForm) {
        var updateFileInput = updateProductForm.querySelector('input[type="file"]');
        
        updateProductForm.addEventListener('submit', function(e) {
            if (updateFileInput.files.length > 6) {
                e.preventDefault();
                alert('Bạn chỉ được chọn tối đa 6 ảnh.');
            }
        });

        updateFileInput.addEventListener('change', function() {
            if (this.files.length > 6) {
                alert('Bạn chỉ được chọn tối đa 6 ảnh.');
                this.value = ''; // Reset input
                return;
            }

            var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            for (var i = 0; i < this.files.length; i++) {
                if (!validTypes.includes(this.files[i].type)) {
                    alert('Chỉ chấp nhận file ảnh có định dạng jpg, jpeg, png hoặc gif.');
                    this.value = ''; // Reset input
                    break;
                }
            }
        });
    }

    // Hàm confirmDelete để xác nhận trước khi thực hiện hành động xóa
    window.confirmDelete = function(callback) {
        if (confirm("Bạn có chắc chắn muốn ẩn sản phẩm này không?")) {
            callback();
        }
    };
});

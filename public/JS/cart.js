// cart.js

// Hàm để thêm sản phẩm vào giỏ hàng
function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    console.log(cart)
    const existingProductIndex = cart.findIndex(item => item.id === product.id);
    if (existingProductIndex > -1) {
        // Nếu sản phẩm đã có, tăng số lượng
        cart[existingProductIndex].quantity += 1; // Cộng thêm số lượng
    } else {
        // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
        product.quantity = 1; // Khởi tạo số lượng
        cart.push(product);
    }

    // Lưu giỏ hàng vào localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Sản phẩm đã được thêm vào giỏ hàng!');
}

// Thêm sự kiện cho tất cả các nút "Add to cart"
document.querySelectorAll('.add-to-cart').forEach(button => {
    
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
        const product = {
            id: this.getAttribute('data-id'),
            name: this.getAttribute('data-name'),
            price: parseFloat(this.getAttribute('data-price')),
            image: this.getAttribute('data-image')
        };

        // Gọi hàm để thêm sản phẩm vào giỏ hàng với số lượng mặc định là 1
        addToCart(product);
    });
});
// // Cập nhật tổng giá và số lượng sản phẩm
// function updateCartSummary() {
//     let totalQuantity = 0;
//     let totalPrice = 0;

//     document.querySelectorAll(".cart-item").forEach(item => {
//         const quantity = parseInt(item.querySelector(".item-quantity").value);
//         const price = parseFloat(item.querySelector(".item-price").dataset.price);

//         totalQuantity += quantity;
//         totalPrice += quantity * price;
//     });

//     document.getElementById("cart-count").textContent = totalQuantity;
//     document.getElementById("cart-total").textContent = new Intl.NumberFormat().format(totalPrice) + "₫";
//     document.getElementById("summary-total").textContent = new Intl.NumberFormat().format(totalPrice) + "₫";
//     document.getElementById("final-total").textContent = new Intl.NumberFormat().format(totalPrice) + "₫";
// }

// // Xóa tất cả sản phẩm trong giỏ hàng
// function removeAllItems() {
//     fetch('http://localhost/Project/front/view/cart_handler.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         body: new URLSearchParams({ action: 'remove_all' })
//     })
//     .then(response => response.json())
//     .then(data => {
//         alert(data.message);
//         location.reload();
//     })
//     .catch(error => console.error("Error:", error));
// }

// // Xác nhận thanh toán
// document.getElementById("confirm-checkout").addEventListener("click", function () {
//     const totalAmount = parseInt(document.getElementById("final-total").textContent.replace("₫", "").replace(",", "")) || 0;
//     const name = document.getElementById("recipient-name").value;
//     const phone = document.getElementById("recipient-phone").value;
//     const address = document.getElementById("recipient-address").value;

//     if (!name || !phone || !address) {
//         alert("Vui lòng điền đầy đủ thông tin để thanh toán.");
//         return;
//     }

//     fetch("http://localhost/Project/front/view/cart_handler.php", {
//         method: "POST",
//         headers: { "Content-Type": "application/x-www-form-urlencoded" },
//         body: new URLSearchParams({
//             action: "checkout",
//             total: totalAmount,
//             name: name,
//             phoneNumber: phone,
//             address: address
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         alert(data.message);
//         if (data.status === "success") {
//             window.location.reload();
//         }
//     })
//     .catch(error => console.error("Error:", error));
// });

// // Hiển thị modal khi nhấn "THANH TOÁN"
// document.getElementById("checkout-button").addEventListener("click", function () {
//     var myModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
//     myModal.show();
// });

// // Xóa sản phẩm đơn
// // Xóa sản phẩm đơn lẻ
// document.querySelectorAll(".remove-item").forEach(button => {
//     button.addEventListener("click", function () {
//         const productId = this.dataset.id;

//         fetch('http://localhost/Project/front/view/cart_handler.php', {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//             body: new URLSearchParams({ action: 'remove_item', product_id: productId })
//         })
//         .then(response => response.json())
//         .then(data => {
//             alert(data.message);
//             location.reload();
//         })
//         .catch(error => console.error("Error:", error));
//     });
// });

// //Tăng hoặc giảm số lượng sản phẩm
// document.querySelectorAll(".item-quantity").forEach(input => {
//     input.addEventListener("change", function () {
//         const productId = this.dataset.id;
//         const newQuantity = parseInt(this.value);

//         if (newQuantity < 1) {
//             alert("Số lượng phải lớn hơn 0");
//             this.value = 1;
//             return;
//         }

//         fetch('http://localhost/Project/front/view/cart_handler.php', {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//             body: new URLSearchParams({
//                 action: 'update_quantity',
//                 product_id: productId,
//                 quantity: newQuantity
//             })
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.status === "success") {
//                 updateCartSummary();
//             } else {
//                 alert(data.message);
//             }
//         })
//         .catch(error => console.error("Error:", error));
//     });
// });

// // Cập nhật số lượng và giá khi trang tải lại
// document.addEventListener("DOMContentLoaded", function () {
//     updateCartSummary();
// });




// //Hàm để cập nhật tổng số lượng và giá
// function updateCartSummary() {
//     let totalQuantity = 0;
//     let totalPrice = 0;

//     document.querySelectorAll(".cart-item").forEach(item => {
//         const quantity = parseInt(item.querySelector(".item-quantity").value);
//         const price = parseFloat(item.querySelector(".item-price").dataset.price);

//         totalQuantity += quantity;
//         totalPrice += quantity * price;
//     });

//     document.getElementById("cart-count").textContent = totalQuantity;
//     document.getElementById("cart-total").textContent = new Intl.NumberFormat().format(totalPrice) + "₫";
//     document.getElementById("summary-total").textContent = new Intl.NumberFormat().format(totalPrice) + "₫";
//     document.getElementById("final-total").textContent = new Intl.NumberFormat().format(totalPrice) + "₫";
// }

// // Hàm cập nhật số lượng sản phẩm
// function updateQuantity(productId, quantity) {
//     fetch('http://localhost/Project/front/view/cart_handler.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         body: new URLSearchParams({
//             action: 'update_quantity',
//             product_id: productId,
//             quantity: quantity
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status === "success") {
//             updateCartSummary();
//         } else {
//             alert(data.message);
//         }
//     })
//     .catch(error => console.error("Error:", error));
// }

// // Xử lý nút giảm số lượng
// document.querySelectorAll(".decrease-quantity").forEach(button => {
//     button.addEventListener("click", function () {
//         const productId = this.getAttribute("data-id");
//         const quantityInput = this.nextElementSibling;
//         let quantity = parseInt(quantityInput.value);

//         if (quantity > 1) {
//             quantity -= 1;
//             quantityInput.value = quantity;
//             updateQuantity(productId, quantity);
//         }
//     });
// });

// // Xử lý nút tăng số lượng
// document.querySelectorAll(".increase-quantity").forEach(button => {
//     button.addEventListener("click", function () {
//         const productId = this.getAttribute("data-id");
//         const quantityInput = this.previousElementSibling;
//         let quantity = parseInt(quantityInput.value);

//         quantity += 1;
//         quantityInput.value = quantity;
//         updateQuantity(productId, quantity);
//     });
// });

// // Xử lý thay đổi trực tiếp số lượng trong ô input
// document.querySelectorAll(".quantity").forEach(input => {
//     input.addEventListener("change", function () {
//         const productId = this.closest('.cart-item').querySelector('.decrease-quantity').getAttribute("data-id");
//         let quantity = parseInt(this.value);

//         if (quantity < 1) {
//             alert("Số lượng phải lớn hơn 0");
//             this.value = 1;
//             quantity = 1;
//         }

//         updateQuantity(productId, quantity);
//     });
// });

// // Cập nhật tổng số lượng và giá khi trang tải lại
// document.addEventListener("DOMContentLoaded", function () {
//     updateCartSummary();
// });

// // Xóa tất cả sản phẩm trong giỏ hàng
// function removeAllItems() {
//     fetch('http://localhost/Project/front/view/cart_handler.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         body: new URLSearchParams({ action: 'remove_all' })
//     })
//     .then(response => response.json())
//     .then(data => {
//         alert(data.message);
//         location.reload();
//     })
//     .catch(error => console.error("Error:", error));
// }

// // Xác nhận thanh toán
// document.getElementById("confirm-checkout").addEventListener("click", function () {
//     const totalAmount = parseInt(document.getElementById("final-total").textContent.replace("₫", "").replace(",", "")) || 0;
//     const name = document.getElementById("recipient-name").value;
//     const phone = document.getElementById("recipient-phone").value;
//     const address = document.getElementById("recipient-address").value;

//     if (!name || !phone || !address) {
//         alert("Vui lòng điền đầy đủ thông tin để thanh toán.");
//         return;
//     }

//     fetch("http://localhost/Project/front/view/cart_handler.php", {
//         method: "POST",
//         headers: { "Content-Type": "application/x-www-form-urlencoded" },
//         body: new URLSearchParams({
//             action: "checkout",
//             total: totalAmount,
//             name: name,
//             phoneNumber: phone,
//             address: address
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         alert(data.message);
//         if (data.status === "success") {
//             window.location.reload();
//         }
//     })
//     .catch(error => console.error("Error:", error));
// });

// // Hiển thị modal khi nhấn "THANH TOÁN"
// document.getElementById("checkout-button").addEventListener("click", function () {
//     var myModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
//     myModal.show();
// });

// // Xóa sản phẩm đơn lẻ
// document.querySelectorAll(".remove-item").forEach(button => {
//     button.addEventListener("click", function () {
//         const productId = this.dataset.id;

//         fetch('http://localhost/Project/front/view/cart_handler.php', {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//             body: new URLSearchParams({ action: 'remove_item', product_id: productId })
//         })
//         .then(response => response.json())
//         .then(data => {
//             alert(data.message);
//             location.reload();
//         })
//         .catch(error => console.error("Error:", error));
//     });
// });


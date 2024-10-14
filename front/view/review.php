<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Reviews.css">
</head>
<body>
    <div class="container mt-4">
        <div class="review-container bg-light p-4 rounded">
            <h2 class="mb-4">Đánh giá (7)</h2>
                <h3>FIX YOUR GLOVE ADIDAS</h3>
                <p class="review-meta text-muted">
                    <span class="name">Tên khách hàng:</span>
                    <span class="date">Ngày đánh giá:</span>
                </p>
                <p class="review-text">If you're looking for a durable, cheap pair of gloves to use for training, DO NOT BUY THESE unless you are willing to buy a new pair every 2-3 training sessions, the gloves already showed rips on the latex in between the fingers, and the next training session after, I made a low catch tearing a MASSIVE gash widthwise across the glove. This has adidas pricing for a glove I could mistake as one found on shopee, this is the only pair of adidas gloves that I have had problems with, but boy is it bad.</p>
            </div>

            <form class="review-form bg-white p-4 rounded">
                <h3 class="mb-3">Write your review</h3>
                <div class="rating-input mb-3">
                    <span class="d-block mb-2">Your rating:</span>
                    <div class="stars">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                    </div>
                </div>
                <textarea class="form-control mb-3" placeholder="Enter your review here..."></textarea>
                <button type="submit" class="btn btn-success">Submit review</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
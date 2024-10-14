<?php
function renderPagination($currentPage, $totalPages, $categoryId) {
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination justify-content-center">'; // Sử dụng Bootstrap để căn giữa

    // Trang trước
    echo '<li class="page-item ' . ($currentPage <= 1 ? 'disabled' : '') . '">';
    echo '<a class="page-link" href="' . ($currentPage > 1 ? '?category_id=' . htmlspecialchars($categoryId) . '&page=' . ($currentPage - 1) : '#') . '">« Trang sau</a>';
    echo '</li>';

    // Các trang
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">
                <a class="page-link" href="?category_id=' . htmlspecialchars($categoryId) . '&page=' . $i . '">' . $i . '</a>
              </li>';
    }

    // Trang sau
    echo '<li class="page-item ' . ($currentPage >= $totalPages ? 'disabled' : '') . '">';
    echo '<a class="page-link" href="' . ($currentPage < $totalPages ? '?category_id=' . htmlspecialchars($categoryId) . '&page=' . ($currentPage + 1) : '#') . '">Trang tiếp »</a>';
    echo '</li>';

    echo '</ul>';
    echo '</nav>';
}
?>
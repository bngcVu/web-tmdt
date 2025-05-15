<?php
include './connect.php';
header('Content-Type: text/html; charset=utf-8');

// Lấy các tham số lọc
$min_price = isset($_POST['min_price']) && is_numeric($_POST['min_price']) ? (int)$_POST['min_price'] : 0;
$max_price = isset($_POST['max_price']) && is_numeric($_POST['max_price']) ? (int)$_POST['max_price'] : 0;
$sort_order = (isset($_POST['sort_order']) && in_array($_POST['sort_order'], ['asc','desc'])) ? $_POST['sort_order'] : '';
$page = isset($_POST['page']) && is_numeric($_POST['page']) && $_POST['page'] > 0 ? (int)$_POST['page'] : 1;
$item_per_page = 6;
$offset = ($page - 1) * $item_per_page;

$where = 'WHERE status = 0';
if (isset($_POST['category_ids']) && is_array($_POST['category_ids']) && count($_POST['category_ids']) > 0) {
    $ids = array_map('intval', $_POST['category_ids']);
    $id_list = implode(',', $ids);
    $where .= " AND id_danhmuc IN ($id_list)";
}
if ($min_price > 0) {
    $where .= " AND gia+0 >= $min_price";
}
if ($max_price > 0) {
    $where .= " AND gia+0 <= $max_price";
}
$order = '';
if ($sort_order) {
    // Ép kiểu số cho cột gia để tránh lỗi sắp xếp nếu là varchar
    $order = " ORDER BY gia+0 $sort_order";
}

// Đếm tổng số sản phẩm phù hợp
$count_stmt = selectAll("SELECT COUNT(*) as total FROM sanpham $where");
$total_row = is_object($count_stmt) ? $count_stmt->fetch()['total'] : 0;
$total_page = ceil($total_row / $item_per_page);

// Lấy sản phẩm trang hiện tại
$stmt = selectAll("SELECT * FROM sanpham $where $order LIMIT $item_per_page OFFSET $offset");
$products = is_object($stmt) ? $stmt->fetchAll() : $stmt;

if (!$products || count($products) == 0) {
    echo '<div class="col-12"><p>Không có sản phẩm nào phù hợp.</p></div>';
    exit;
}

foreach ($products as $row) {
    echo '<div class="col-lg-4 col-sm-6" style="height: 500px;">';
    echo '  <div class="single_product_item">';
    echo '    <a href="detail.php?id=' . $row['id'] . '">';
    echo '      <img src="img/product/' . $row['anh1'] . '" style="width: 230px;height: 230px;" alt="">';
    echo '    </a>';
    echo '    <div class="single_product_text">';
    echo '      <h4 style="font-size: 16px">' . $row['ten'] . '</h4>';
    echo '      <h3>' . number_format($row['gia']) . 'đ</h3>';
    echo '      <p><a href="detail.php?id=' . $row['id'] . '" style="font-size: 14px">Xem chi tiết</a></p>';
    echo '      <a href="detail.php?id=' . $row['id'] . '">+ Thêm vào giỏ</a>';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';
}

// Hiển thị phân trang
if ($total_page > 1) {
    echo '<div class="col-12"><nav class="pagination-wrap"><ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $total_page; $i++) {
        echo '<li class="page-item' . ($i == $page ? ' active' : '') . '"><a class="page-link ajax-page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul></nav></div>';
} 
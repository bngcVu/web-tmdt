<?php 
    session_start(); // Thêm session_start để đồng bộ
    include './connect.php';  

    $idtaikhoan = null;
    $diachitaikhoan = '';
    $loggedIn = false;

    if (isset($_COOKIE["user"])) {
        $taikhoan_cookie = $_COOKIE["user"];
        // Sử dụng prepared statement để lấy thông tin người dùng
        $userData = selectAll("SELECT id, diachi FROM taikhoan WHERE taikhoan = ?", [$taikhoan_cookie]);
        if (!empty($userData)) {
            $user = $userData[0];
            $idtaikhoan = $user['id'];
            $diachitaikhoan = $user['diachi']; // Địa chỉ mặc định
            $loggedIn = true;
        }
    }
?>
<!doctype html>
<html lang="zxx">

<head>
  <!-- Thẻ meta cần thiết -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Lịch sử đơn hàng</title>
  <link rel="icon" href="img/logos.png">
  <!-- CSS của Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- CSS animation -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- CSS owl carousel -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <!-- CSS nice select -->
  <link rel="stylesheet" href="css/nice-select.css">
  <!-- CSS font awesome -->
  <link rel="stylesheet" href="css/all.css">
  <!-- CSS flaticon -->
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/themify-icons.css">
  <!-- CSS font awesome -->
  <link rel="stylesheet" href="css/magnific-popup.css">
  <!-- CSS swiper -->
  <link rel="stylesheet" href="css/swiper.min.css">
  <link rel="stylesheet" href="css/price_rangs.css">
  <!-- CSS style -->
  <link rel="stylesheet" href="css/style.css">
  <style>
    .header_bg {
        background-color: #ecfdff;
        height: 230px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .padding_top1{
        padding-top:20px;
    }
    .a1{
        padding-top:130px;
    }
    .a2{
        height: 230px;
    }
    .order-card {
        margin-bottom: 30px;
        border: 1px solid #eee;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .order-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
    .order-header h5 {
        margin-bottom: 0;
        font-size: 1.1rem;
    }
    .order-header .status-text {
        font-weight: bold;
    }
    .bank-transfer-details-history {
        background-color: #f9f9f9;
        padding: 15px;
        margin-top: 10px;
        border-radius: 4px;
        border: 1px solid #e0e0e0;
    }
  </style>
</head>

<body>

    <?php include 'header.php';?>

  <!--================Khu vực banner trang chủ =================-->
  <!-- Bắt đầu breadcrumb-->
  <section class="breadcrumb header_bg">
        <div class="container">
            <div class="row justify-content-center a2">
                <div class="col-lg-8 a2">

                </div>
            </div>
        </div>
    </section>
  <!-- Kết thúc breadcrumb-->

  <!--================Khu vực giỏ hàng =================-->
  <section class="cart_area padding_top1">
    <div class="container">
        <?php if ($loggedIn && $idtaikhoan !== null) : ?>
            <?php
                // Lấy đơn hàng cho người dùng đã đăng nhập, status != 0 nghĩa là không phải giỏ hàng đang hoạt động
                $orders = selectAll(
                    "SELECT id, thoigian, status, tongtien, diachi FROM donhang WHERE id_taikhoan = ? AND status != 0 ORDER BY thoigian DESC",
                    [$idtaikhoan]
                );

                if (!empty($orders)) :
                    foreach ($orders as $order) :
                        $orderId = $order['id'];
                        $orderTime = date("d/m/Y H:i:s", strtotime($order['thoigian']));
                        $orderStatus = $order['status'];
                        $orderTotal = $order['tongtien'];
                        $orderAddress = !empty($order['diachi']) ? htmlspecialchars($order['diachi']) : htmlspecialchars($diachitaikhoan); // Sử dụng địa chỉ cụ thể của đơn hàng nếu có

                        $statusText = '';
                        $statusClass = '';
                        switch ($orderStatus) {
                            case 1: // Chờ Xác Nhận (COD hoặc Chuyển khoản đã được Admin xác nhận)
                                $statusText = 'Chờ Xác Nhận';
                                $statusClass = 'text-info';
                                break;
                            case 3: // Đang Giao
                                $statusText = 'Đang Giao';
                                $statusClass = 'text-primary';
                                break;
                            case 4: // Đã Giao
                                $statusText = 'Đã Giao';
                                $statusClass = 'text-success';
                                break;
                            case 5: // Đã Hủy
                                $statusText = 'Đã Hủy';
                                $statusClass = 'text-danger';
                                break;
                            default:
                                $statusText = 'Không xác định';
                                $statusClass = 'text-muted';
                        }
            ?>
            <div class="order-card">
                <div class="order-header d-flex justify-content-between align-items-center">
                    <h5>Mã đơn hàng: #<?= $orderId ?> <small>(Đặt lúc: <?= $orderTime ?>)</small></h5>
                    <p class="status-text <?= $statusClass ?>" style="margin-bottom:0;"><?= $statusText ?></p>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col" class="text-right">Giá</th>
                            <th scope="col" class="text-center">Số lượng</th>
                            <th scope="col" class="text-right">Tổng</th>
                            <th scope="col" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $orderDetails = selectAll(
                                "SELECT ctd.soluong, ctd.gia, s.ten as ten_sanpham, s.anh1 as anh_sanpham, s.id as id_sanpham 
                                 FROM ctdonhang ctd 
                                 JOIN sanpham s ON ctd.id_sanpham = s.id 
                                 WHERE ctd.id_donhang = ?", 
                                [$orderId]
                            );
                            foreach ($orderDetails as $item) :
                                $productTotal = $item['soluong'] * $item['gia'];
                        ?>
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="d-flex mr-3">
                                        <img src="img/product/<?= htmlspecialchars($item['anh_sanpham']) ?>" alt="<?= htmlspecialchars($item['ten_sanpham']) ?>" style="width:50px; height:50px; object-fit: cover;"/>
                                    </div>
                                    <div class="media-body">
                                        <p class="mb-0"><?= htmlspecialchars($item['ten_sanpham']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right"><h5><?= number_format($item['gia']) ?>đ</h5></td>
                            <td class="text-center">
                                <div class="product_count">
                                    <input class="input-number" type="text" value="<?= $item['soluong'] ?>" readonly style="width: 50px; text-align: center; border: 1px solid #ced4da; border-radius: .25rem; padding: .375rem .75rem;"/>
                                </div>
                            </td>
                            <td class="text-right"><h5><?= number_format($productTotal) ?>đ</h5></td>
                            <td class="text-center">
                                <a class="btn btn-sm btn_1" href="detail.php?id=<?= $item['id_sanpham'] ?>">Xem SP</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="bottom_button">
                            <td colspan="2">
                                <strong>Địa chỉ nhận hàng:</strong> <?= $orderAddress ?>
                            </td>
                            <td class="text-right"><h5>Tổng cộng đơn:</h5></td>
                            <td class="text-right"><h5><?= number_format($orderTotal) ?>đ</h5></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>

                </div> <!-- Kết thúc table-responsive -->
            </div> <!-- Kết thúc order-card -->
            <?php
                    endforeach;
                else :
            ?>
                <div class="text-center">
                    <h2>Bạn chưa có đơn hàng nào!</h2>
                    <a href="product.php" class="btn_1" style="margin-top:20px;">Mua Ngay</a>
                </div>
            <?php endif; ?>
            <div class="checkout_btn_inner float-right mt-3">
                <a class="btn_1" href="cart.php">Quay Về Giỏ Hàng</a>
                <a class="btn_1" href="product.php" style="margin-left:10px;">Tiếp Tục Mua Sắm</a>
            </div>
        <?php else : ?>
            <div class="text-center">
                <h2>Vui lòng <a href="login.php">đăng nhập</a> để xem lịch sử đặt hàng.</h2>
            </div>
        <?php endif; ?>
    </div> <!-- Kết thúc container -->
  </section>

  <!--================Kết thúc khu vực đăng nhập =================-->


  <!-- các plugin jquery ở đây-->
  <!-- jquery -->
  <script src="js/jquery-1.12.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- easing js -->
  <script src="js/jquery.magnific-popup.js"></script>
  <!-- swiper js -->
  <script src="js/swiper.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/stellar.js"></script>
  <script src="js/price_rangs.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  
  <div style="clear: both;"></div>
  <?php include 'footer.php';?>

</body>

</html>

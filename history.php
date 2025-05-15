<?php 
    session_start(); // Add session_start for consistency
    include './connect.php';  

    $idtaikhoan = null;
    $diachitaikhoan = '';
    $loggedIn = false;

    if (isset($_COOKIE["user"])) {
        $taikhoan_cookie = $_COOKIE["user"];
        // Use prepared statement to get user details
        $userData = selectAll("SELECT id, diachi FROM taikhoan WHERE taikhoan = ?", [$taikhoan_cookie]);
        if (!empty($userData)) {
            $user = $userData[0];
            $idtaikhoan = $user['id'];
            $diachitaikhoan = $user['diachi']; // Default address
            $loggedIn = true;
        }
    }
?>
<!doctype html>
<html lang="zxx">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Lịch sử đơn hàng</title>
  <link rel="icon" href="img/logos.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- animate CSS -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- owl carousel CSS -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <!-- nice select CSS -->
  <link rel="stylesheet" href="css/nice-select.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/all.css">
  <!-- flaticon CSS -->
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/themify-icons.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/magnific-popup.css">
  <!-- swiper CSS -->
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/price_rangs.css">
  <!-- style CSS -->
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

  <!--================Home Banner Area =================-->
  <!-- breadcrumb start-->
  <section class="breadcrumb header_bg">
        <div class="container">
            <div class="row justify-content-center a2">
                <div class="col-lg-8 a2">

                </div>
            </div>
        </div>
    </section>
  <!-- breadcrumb end-->

  <!--================Cart Area =================-->
  <section class="cart_area padding_top1">
    <div class="container">
        <?php if ($loggedIn && $idtaikhoan !== null) : ?>
            <?php
                // Fetch orders for the logged-in user, status != 0 means it's not an active cart
                $orders = selectAll(
                    "SELECT id, thoigian, status, tongtien, diachi, phuongthuc_thanhtoan FROM donhang WHERE id_taikhoan = ? AND status != 0 ORDER BY thoigian DESC", 
                    [$idtaikhoan]
                );

                if (!empty($orders)) :
                    foreach ($orders as $order) :
                        $orderId = $order['id'];
                        $orderTime = date("d/m/Y H:i:s", strtotime($order['thoigian']));
                        $orderStatus = $order['status'];
                        $orderTotal = $order['tongtien'];
                        $orderAddress = !empty($order['diachi']) ? htmlspecialchars($order['diachi']) : htmlspecialchars($diachitaikhoan); // Use order specific address if available
                        $orderPaymentMethod = $order['phuongthuc_thanhtoan'];

                        $statusText = '';
                        $statusClass = '';
                        switch ($orderStatus) {
                            case 1: // Chờ Xác Nhận (COD or Bank Transfer confirmed by Admin)
                                $statusText = 'Chờ Xác Nhận';
                                $statusClass = 'text-info';
                                break;
                            case 2: // Chờ Thanh Toán CK
                                $statusText = 'Chờ Thanh Toán Chuyển Khoản';
                                $statusClass = 'text-warning';
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
                                <strong>Địa chỉ nhận hàng:</strong> <?= $orderAddress ?> <br/>
                                <strong>Hình thức thanh toán:</strong> <?= htmlspecialchars($orderPaymentMethod) ?>
                            </td>
                            <td class="text-right"><h5>Tổng cộng đơn:</h5></td>
                            <td class="text-right"><h5><?= number_format($orderTotal) ?>đ</h5></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>

                    <?php if ($orderStatus == 2 && $orderPaymentMethod == "Bank Transfer") : ?>
                    <div class="text-left mb-2 mt-2"> <!-- Button container -->
                        <button type="button" class="btn_1" onclick="togglePaymentDetails('<?= $orderId ?>', this)" style="padding: 8px 15px; font-size: 0.9rem;">
                            Hiện thông tin thanh toán
                        </button>
                    </div>
                    <div id="paymentDetails_<?= $orderId ?>" class="bank-transfer-details-history" style="display:none;">
                        <h6 class="mb-3" style="color: #dc3545;"><i class="fa fa-hourglass-half"></i> Vui lòng hoàn tất thanh toán cho đơn hàng này:</h6>
                        <div class="card shadow rounded-lg p-3" style="background: #fff; border: none;">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <h5 class="mb-2" style="color: #5e2ced;">
                                        <i class="fa fa-university"></i> Thông tin chuyển khoản
                                    </h5>
                                    <ul class="list-unstyled" style="font-size: 1.0rem;">
                                        <li class="mb-2"><strong>Ngân hàng:</strong> <span style="color:#2d9cdb;">Vietcombank</span></li>
                                        <li class="mb-2"><strong>Chủ tài khoản:</strong> <span>Bùi Ngọc Vũ</span></li>
                                        <li class="mb-2">
                                            <strong>Số tài khoản:</strong> 
                                            <span id="stk_<?= $orderId ?>" style="font-weight: bold; color: #e74c3c;">9399564786</span>
                                            <button class="btn btn-sm btn-outline-primary ml-2" type="button" onclick="copyToClipboard('stk_<?= $orderId ?>')" title="Sao chép số tài khoản"><i class="fa fa-copy"></i></button>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Số tiền:</strong> 
                                            <span style="font-weight: bold; color: #27ae60;"><?= number_format($orderTotal) ?> đ</span>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Nội dung CK:</strong> 
                                            <span id="noidungck_<?= $orderId ?>" style="font-weight: bold; color: #5e2ced;">Thanh toan don hang #<?= $orderId ?></span>
                                            <button class="btn btn-sm btn-outline-primary ml-2" type="button" onclick="copyToClipboard('noidungck_<?= $orderId ?>')" title="Sao chép nội dung"><i class="fa fa-copy"></i></button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-5 text-center">
                                    <div class="mb-2">
                                        <strong>Quét mã QR để thanh toán (VietQR):</strong>
                                    </div>
                                    <img src="img/qr_code_bank.png" alt="QR Code Thanh Toán Ngân Hàng" class="img-fluid rounded border" style="max-width: 180px;">
                                    <div class="small text-muted mt-2">Dùng app ngân hàng để quét mã QR.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                </div> <!-- table-responsive end -->
            </div> <!-- order-card end -->
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
    </div> <!-- container end -->
  </section>

  <!--================login_part end =================-->


  <!-- jquery plugins here-->
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
  <script>
  function copyToClipboard(elementId) {
    var textEl = document.getElementById(elementId);
    if (textEl) {
        var text = textEl.innerText;
        navigator.clipboard.writeText(text)
        .then(() => {
            alert('Đã sao chép: ' + text);
        })
        .catch(err => {
            console.error('Lỗi khi sao chép: ', err);
            alert('Lỗi khi sao chép. Vui lòng thử lại hoặc sao chép thủ công.');
        });
    } else {
        console.error('Không tìm thấy element với ID: ' + elementId);
        alert('Có lỗi xảy ra, không thể sao chép.');
    }
  }

  function togglePaymentDetails(orderId, buttonElement) {
    var detailsDiv = document.getElementById('paymentDetails_' + orderId);
    if (detailsDiv) {
        if (detailsDiv.style.display === 'none') {
            detailsDiv.style.display = 'block';
            buttonElement.textContent = 'Ẩn thông tin thanh toán';
        } else {
            detailsDiv.style.display = 'none';
            buttonElement.textContent = 'Hiện thông tin thanh toán';
        }
    }
  }
  </script>

  <?php include 'footer.php';?>
  
</body>

</html>
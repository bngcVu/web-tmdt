<?php 
    // Bắt đầu session để lưu trữ thông tin tạm thời
    session_start();
    // Kết nối đến database
    include './connect.php';  
?>
<!doctype html>
<html lang="zxx">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Smobile</title>
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
</head>
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
</style>

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
        <?php
        // Khởi tạo các biến cần thiết
        $idtaikhoan = null;
        $diachitaikhoan = '';
        $idDh = null; // ID đơn hàng hiện tại
        $showBankTransferInfo = false;
        $order_total_bank = 0;
        $order_diachi_bank = '';

        // Kiểm tra đăng nhập và lấy thông tin người dùng
        if (isset($_COOKIE["user"])) {
            $taikhoan = $_COOKIE["user"];
            // Lấy thông tin người dùng từ database
            $userData = selectAll("SELECT id, diachi FROM taikhoan WHERE taikhoan = ?", [$taikhoan]);
            if (!empty($userData)) {
                $user = $userData[0];
                $idtaikhoan = $user['id'];
                $diachitaikhoan = $user['diachi'];

                // Lấy đơn hàng đang hoạt động của người dùng
                $activeOrderData = selectAll("SELECT id FROM donhang WHERE id_taikhoan = ? AND status = 0", [$idtaikhoan]);
                if (!empty($activeOrderData)) {
                    $idDh = $activeOrderData[0]['id'];
                }
            } else {
                // Cookie exists but user not in DB, potentially an old cookie or an issue
                // For now, treat as not logged in for cart purposes
                $idtaikhoan = null; 
            }
        }

        // Xử lý xóa sản phẩm khỏi giỏ hàng
        if (isset($_GET['removeproduct']) && $idDh !== null && $idtaikhoan !== null) {
            $removeProductId = filter_var($_GET['removeproduct'], FILTER_VALIDATE_INT);
            if ($removeProductId) {
                exSQL("DELETE FROM ctdonhang WHERE id_donhang = ? AND id_sanpham = ?", [$idDh, $removeProductId]);
                header('location:cart.php');
                exit;
            }
        }

        // Hiển thị giỏ hàng nếu người dùng đã đăng nhập
        if ($idtaikhoan !== null && empty($showBankTransferInfo)) : 
        ?>
            <form class="cart_inner" method="post" action="cart.php">
                <div class="table-responsive">
                    <a href="history.php" class="btn_1" style="float:right; margin-bottom:20px;">Lịch sử đặt hàng</a>
                    <?php
                        // Lấy danh sách sản phẩm trong giỏ hàng
                        $cartItems = [];
                        if ($idDh !== null) {
                            $cartItems = selectAll("SELECT * FROM ctdonhang WHERE id_donhang = ?", [$idDh]);
                        }

                        // Hiển thị giỏ hàng nếu có sản phẩm
                        if (!empty($cartItems)) :
                    ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng</th>
                                <th scope="col"></th> <!-- For delete button -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $tongcong = 0;
                                foreach ($cartItems as $item) :
                                    $idSp = $item['id_sanpham'];
                                    $soluongSp = $item['soluong'];
                                    $giaSp = $item['gia'];
                                    $tong = $soluongSp * $giaSp;
                                    $tongcong += $tong;

                                    $productDetails = selectAll("SELECT ten, anh1 FROM sanpham WHERE id = ?", [$idSp]);
                                    $tenSp = "Sản phẩm không xác định";
                                    $anhSp = "default.png"; // Fallback image
                                    if (!empty($productDetails)) {
                                        $tenSp = $productDetails[0]['ten'];
                                        $anhSp = $productDetails[0]['anh1'];
                                    }
                            ?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                        <img src="img/product/<?= htmlspecialchars($anhSp) ?>" alt="<?= htmlspecialchars($tenSp) ?>" style="width:50px; height:50px;"/>
                                        </div>
                                        <div class="media-body">
                                            <p><?= htmlspecialchars($tenSp) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="product-price" data-price="<?= $giaSp ?>">
                                    <h5><?= number_format($giaSp, 0, '.', '.') ?>đ</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input class="input-number" type="number" name="soluong[<?= $idSp ?>]" value="<?= $soluongSp ?>" min="1" max="100"/>
                                    </div>
                                </td>
                                <td class="product-total">
                                    <h5><?= number_format($tong, 0, '.', '.') ?>đ</h5>
                                </td>
                                <td>
                                    <a class="genric-btn primary circle" href="cart.php?removeproduct=<?= $idSp ?>">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="bottom_button">
                                <td></td>
                                <td></td>
                                <td><h5>Tổng cộng:</h5></td>
                                <td><h5 id="cart-grand-total"><?= number_format($tongcong, 0, '.', '.') ?>đ</h5></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="checkout_btn_inner form-group">
                                        <label for="diachi" style="font-weight: bold; margin-bottom: 5px; display: block;">Địa chỉ nhận hàng:</label>
                                        <textarea id="diachi" name="diachi" class="form-control" cols="70" rows="3" placeholder="Nhập địa chỉ chi tiết (số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố)" required style="resize: none;"><?= htmlspecialchars($diachitaikhoan) ?></textarea>
                                    </div>
                                </td>
                                <td colspan="2"></td>
                            </tr>
                             <tr>
                                <td colspan="5">
                                    <div class="checkout_btn_inner billing_details">
                                        <div class="payment-method">
                                            <h5><i class="fa fa-money-bill-wave"></i> Hình thức thanh toán</h5>
                                            <div class="payment-info">
                                                <p class="mb-0"><i class="fa fa-check-circle text-success"></i> Thanh toán khi nhận hàng (COD)</p>
                                                <small class="text-muted">Bạn sẽ thanh toán tiền mặt khi nhận được hàng</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                
                        <div class="checkout_btn_inner float-right" style="margin-top: 20px;">
                            <a class="btn_1" href="product.php">Tiếp Tục Mua Sắm</a>
                            <input class="btn_1" type='submit' name="dathang" value="Đặt Hàng" style="border: none"/>
                        </div>
                    </div> <!-- table-responsive end -->
                <?php else : // Cart is empty ?>
                    <div class="text-center">
                        <h2>Giỏ hàng của bạn đang trống</h2>
                        <a href="product.php" class="btn_1" style="margin-top:20px;">Mua Ngay</a>
                    </div>
                <?php endif; ?>
            </form>
        <?php else : // User is not logged in ?>
            <div class="text-center">
                <h2>Vui lòng <a href="login.php">đăng nhập</a> để xem giỏ hàng và đặt hàng.</h2>
            </div>
        <?php
        endif; 
        
        if (isset($_POST["dathang"])) {
            $diachi = $_POST["diachi"];
            $today = date("Y-m-d H:i:s");
            selectall("UPDATE donhang SET diachi='$diachi',thoigian='$today', tongtien= $tongcong, status=1 WHERE id_taikhoan=$idtaikhoan && status=0");
            echo "<script>alert('Đặt hàng thành công')
                location.href='product.php'
            </script>";
        }
    ?>
    </div> <!-- container end -->
  </section>

  <!--================login_part end =================-->


  <!-- jquery plugins here-->
  <script src="js/jquery-1.12.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.js"></script>
  <script src="js/swiper.min.js"></script>
  <script src="js/masonry.pkgd.js"></script>
  <script src="js/owl.carousel.min.js"></script>S
  <script src="js/jquery.nice-select.min.js"></script>
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
  <script src="js/custom.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Tính lại tổng tiền khi thay đổi số lượng
    const quantityInputs = document.querySelectorAll('.input-number');
    quantityInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const row = input.closest('tr');
            const price = parseInt(row.querySelector('.product-price').getAttribute('data-price'));
            const quantity = parseInt(input.value) || 1;
            const totalCell = row.querySelector('.product-total');
            const newTotal = price * quantity;
            totalCell.innerHTML = newTotal.toLocaleString('de-DE') + 'đ';

            // Cập nhật tổng cộng
            let tongCong = 0;
            document.querySelectorAll('.product-total').forEach(function(cell) {
                tongCong += parseInt(cell.innerText.replace(/\D/g, '')) || 0;
            });
            document.getElementById('cart-grand-total').innerText = tongCong.toLocaleString('de-DE') + 'đ';
        });
    });
  });
  </script>

  <?php include 'footer.php';?>
  
</body>

</html>
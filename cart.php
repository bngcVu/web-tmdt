<?php 
session_start(); // Add session_start for potential future use and consistency
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
        $idtaikhoan = null;
        $diachitaikhoan = '';
        $idDh = null; // Initialize $idDh
        $showBankTransferInfo = false;
        $order_total_bank = 0;
        $order_diachi_bank = '';

        if (isset($_COOKIE["user"])) {
            $taikhoan = $_COOKIE["user"];
            $userData = selectAll("SELECT id, diachi FROM taikhoan WHERE taikhoan = ?", [$taikhoan]);
            if (!empty($userData)) {
                $user = $userData[0];
                $idtaikhoan = $user['id'];
                $diachitaikhoan = $user['diachi'];

                // Fetch active order ID for the logged-in user
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

        // Handle product removal - ensure $idDh is available
        if (isset($_GET['removeproduct']) && $idDh !== null && $idtaikhoan !== null) {
            $removeProductId = filter_var($_GET['removeproduct'], FILTER_VALIDATE_INT);
            if ($removeProductId) {
                exSQL("DELETE FROM ctdonhang WHERE id_donhang = ? AND id_sanpham = ?", [$idDh, $removeProductId]);
                header('location:cart.php');
                exit;
            }
        }

        if ($idtaikhoan !== null && empty($showBankTransferInfo)) : // User is considered logged in and user data is fetched
        ?>
            <form class="cart_inner" method="post" action="cart.php">
                <div class="table-responsive">
                    <a href="history.php" class="btn_1" style="float:right; margin-bottom:20px;">Lịch sử đặt hàng</a>
                    <?php
                        $cartItems = [];
                        if ($idDh !== null) { // If an active order exists
                            $cartItems = selectAll("SELECT * FROM ctdonhang WHERE id_donhang = ?", [$idDh]);
                        }

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
                                        <h5>Chọn hình thức thanh toán:</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="phuongthuc_thanhtoan" id="payment_cod" value="COD" checked required>
                                            <label class="form-check-label" for="payment_cod">
                                                Thanh toán khi nhận hàng (COD)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="phuongthuc_thanhtoan" id="payment_bank" value="Bank Transfer" required>
                                            <label class="form-check-label" for="payment_bank">
                                                Chuyển khoản ngân hàng
                                            </label>
                                        </div>
                                        <div id="bankTransferInfo" style="display:none; margin-top: 20px;">
                                            <div class="card shadow rounded-lg p-3" style="background: #fff; border: none;">
                                                <div class="row align-items-center">
                                                    <div class="col-md-7">
                                                        <h5 class="mb-2" style="color: #5e2ced;">
                                                            <i class="fa fa-university"></i> Thông tin chuyển khoản
                                                        </h5>
                                                        <ul class="list-unstyled" style="font-size: 1.08rem;">
                                                            <li class="mb-2"><strong>Ngân hàng:</strong> <span style="color:#2d9cdb;">Vietcombank</span></li>
                                                            <li class="mb-2"><strong>Chủ tài khoản:</strong> <span>Bùi Ngọc Vũ</span></li>
                                                            <li class="mb-2">
                                                                <strong>Số tài khoản:</strong> 
                                                                <span id="stk" style="font-weight: bold; color: #e74c3c;">9399564786</span>
                                                                <button class="btn btn-sm btn-outline-primary ml-2" type="button" onclick="copyToClipboard('stk')" title="Sao chép số tài khoản"><i class="fa fa-copy"></i></button>
                                                            </li>
                                                            <li class="mb-2">
                                                                <strong>Số tiền:</strong> 
                                                                <span style="font-weight: bold; color: #27ae60;"><?= isset($tongcong) ? number_format($tongcong) : '0' ?> đ</span>
                                                            </li>
                                                            <li class="mb-2">
                                                                <strong>Nội dung CK:</strong> 
                                                                <span id="noidungck" style="font-weight: bold; color: #5e2ced;">Thanh toan don hang #<?= $idDh ?? '' ?></span>
                                                                <button class="btn btn-sm btn-outline-primary ml-2" type="button" onclick="copyToClipboard('noidungck')" title="Sao chép nội dung"><i class="fa fa-copy"></i></button>
                                                            </li>
                                                        </ul>
                                                        <div class="alert alert-info mt-3" style="font-size: 0.97rem;">
                                                            <i class="fa fa-info-circle"></i>
                                                            Vui lòng chuyển khoản đúng thông tin trên trước khi nhấn Đặt Hàng!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 text-center">
                                                        <div class="mb-2">
                                                            <strong>Quét mã QR để thanh toán (VietQR):</strong>
                                                        </div>
                                                        <img src="img/qr_code_bank.png" alt="QR Code Thanh Toán Ngân Hàng" class="img-fluid rounded border" style="max-width: 200px;">
                                                        <div class="small text-muted mt-2">Dùng app ngân hàng để quét mã QR.<br>Nhớ kiểm tra lại số tiền và nội dung chuyển khoản.</div>
                                                    </div>
                                                </div>
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
        
        if (isset($_POST["dathang"]) && $idtaikhoan !== null && $idDh !== null) {
            $diachi = trim($_POST["diachi"]);
            $phuongthuc_thanhtoan = $_POST["phuongthuc_thanhtoan"];
            $today = date("Y-m-d H:i:s");
            
            $cartItemsForTotal = selectAll("SELECT soluong, gia FROM ctdonhang WHERE id_donhang = ?", [$idDh]);
            $tongcong_final = 0;
            if (!empty($cartItemsForTotal)) {
                foreach($cartItemsForTotal as $itemForTotal){
                    $tongcong_final += $itemForTotal['soluong'] * $itemForTotal['gia'];
                }

                if (empty($diachi)) {
                     echo "<script>alert('Vui lòng nhập địa chỉ nhận hàng.'); location.href='cart.php';</script>";
                     exit;
                }

                $new_status = 0; 
                $alert_message = "";

                if ($phuongthuc_thanhtoan == "Bank Transfer") {
                    $new_status = 2; // 2 for "Awaiting Payment Confirmation"
                    $alert_message = "Đơn hàng của bạn đã được ghi nhận và đang chờ xác nhận thanh toán. Vui lòng hoàn tất chuyển khoản theo thông tin đã hiển thị. Chúng tôi sẽ xử lý đơn hàng sau khi nhận được thanh toán.";
                } else { // Assuming COD or other direct methods
                    $new_status = 1; // 1 for "Order Confirmed/Processing"
                    $alert_message = "Đặt hàng thành công!";
                }
                
                $success = exSQL(
                    "UPDATE donhang SET diachi = ?, thoigian = ?, tongtien = ?, phuongthuc_thanhtoan = ?, status = ? WHERE id = ? AND id_taikhoan = ? AND status = 0",
                    [$diachi, $today, $tongcong_final, $phuongthuc_thanhtoan, $new_status, $idDh, $idtaikhoan]
                );

                if ($success) {
                    // Create a new empty cart for the user
                    exSQL("INSERT INTO donhang (id_taikhoan, status, tongtien) VALUES (?, 0, 0)", [$idtaikhoan]);
                    echo "<script>alert('{$alert_message}'); location.href='history.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Đặt hàng thất bại. Vui lòng thử lại.'); location.href='cart.php';</script>";
                    exit;
                }
            } else {
                // Cart became empty somehow before placing order
                echo "<script>alert('Giỏ hàng của bạn trống không thể đặt hàng.'); location.href='cart.php';</script>";
                exit;
            }
        }

        if (isset($_POST['capnhat']) && isset($_POST['soluong']) && $idDh !== null) {
            foreach ($_POST['soluong'] as $idSp => $soLuongMoi) {
                $soLuongMoi = max(1, min(100, (int)$soLuongMoi));
                exSQL("UPDATE ctdonhang SET soluong = ? WHERE id_donhang = ? AND id_sanpham = ?", [$soLuongMoi, $idDh, $idSp]);
            }
            header('Location: cart.php');
            exit;
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

  document.addEventListener('DOMContentLoaded', function() {
    var codRadio = document.getElementById('payment_cod');
    var bankRadio = document.getElementById('payment_bank');
    var bankInfo = document.getElementById('bankTransferInfo');
    function toggleBankInfo() {
        if (bankRadio.checked) {
            bankInfo.style.display = 'block';
        } else {
            bankInfo.style.display = 'none';
        }
    }
    codRadio.addEventListener('change', toggleBankInfo);
    bankRadio.addEventListener('change', toggleBankInfo);
    toggleBankInfo(); // Initialize on page load

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
            // Cập nhật số tiền trong chuyển khoản nếu có
            var bankAmount = document.querySelector('#bankTransferInfo [style*="color: #27ae60;"]');
            if (bankAmount) bankAmount.innerText = tongCong.toLocaleString('de-DE') + ' đ';
        });
    });
  });
  </script>

  <?php include 'footer.php';?>
  
</body>

</html>
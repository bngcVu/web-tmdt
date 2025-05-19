<?php
    include_once './connect.php'; // Đảm bảo include connect.php chỉ 1 lần

    if (isset($_GET["checkout"])) {
        setcookie("user", "", time() - 3600, '/'); 
        header('Location: index.php');
        exit();
    }
?>

    <!--::Bắt đầu phần header::-->
    <section class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php"> <img src="img/logo.png" alt="logo" style="height: 50px;"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Trang chủ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="product.php">sản phẩm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact.php">Liên hệ</a>
                                </li>

                                <?php 
                                    if (isset($_COOKIE["user"])) {
                                        $taikhoan = $_COOKIE["user"];
                                        $ten = 'Khách'; // Tên mặc định
                                        $anh = null;    // Ảnh đại diện mặc định
                                        $phanquyen = 0; // Mặc định không có quyền admin
                                        $id_nguoidung = null; // Khởi tạo ID người dùng

                                        // Dùng prepared statement để lấy thông tin người dùng (bảo mật)
                                        $userData = selectAll("SELECT id, hoten, anh, phanquyen FROM taikhoan WHERE taikhoan = ?", [$taikhoan]);
                                        if (!empty($userData)) {
                                            $userItem = $userData[0];
                                            $id_nguoidung = $userItem['id']; // Lưu ID người dùng cho logic giỏ hàng
                                            $ten = $userItem['hoten'];
                                            $anh = $userItem['anh'];
                                            $phanquyen = $userItem['phanquyen'];
                                        }
                                ?>
                                
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown_3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Chào <?= htmlspecialchars($ten) ?>
                                            <!-- <img id="blah" src="<?= empty($anh)?'./img/account/user.png':'./img/account/'.htmlspecialchars($anh).'' ?>" alt="your image" width="50px" height="50px" /> -->

                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                            <?php 
                                                if ($phanquyen==1) {
                                            ?>
                                                <a class="dropdown-item" href="admin">Trang quản trị</a>
                                            <?php
                                            }
                                            ?>

                                            <a class="dropdown-item" href="infor.php"> thông tin tài khoản</a>
                                            <a class="dropdown-item" href="?checkout">đăng xuất</a>
                                            
                                        </div>
                                    </li>
                                <?php
                                    }
                                    else{
                                ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown_3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            tài khoản
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                            <a class="dropdown-item" href="register.php"> đăng ký</a>
                                            <a class="dropdown-item" href="login.php">đăng nhập</a>
                                        </div>
                                    </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="hearer_icon d-flex">
                            <a id="search_1" href="javascript:void(0)" style="cursor: pointer; margin-right: -20px;"><i class="ti-search" style="font-size:20px"></i></a>
                            <!-- <a href=""><i class="ti-heart"></i></a> -->
                            <div >
                                <a class="" href="cart.php" id="navbarDropdown3" role="button" > <!-- data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" -->
                                    <i class="fa fa-cart-plus"style="font-size:20px"></i>
                                    <?php 
                                        // Đảm bảo $id_nguoidung đã được lấy từ block trên nếu user đã đăng nhập
                                        if (isset($_COOKIE["user"]) && $id_nguoidung !== null) {
                                            // Lấy giỏ hàng (đơn hàng status = 0) của người dùng
                                            $activeCart = selectAll("SELECT id FROM donhang WHERE id_taikhoan = ? AND status = 0 LIMIT 1", [$id_nguoidung]);
                                            if (!empty($activeCart)) {
                                                $id_donhang = $activeCart[0]['id'];
                                                // Đếm số lượng sản phẩm trong giỏ hàng
                                                // Giả định hàm rowCount trả về số dòng cho query SELECT
                                                $itemCountInCart = rowCount("SELECT id FROM ctdonhang WHERE id_donhang = ?", [$id_donhang]);
                                                if ($itemCountInCart > 0) {
                                                ?>
                                                <span class='badge badge-danger' style='vertical-align: top; margin:-10px 0px 0px -10px; font-size:10px'><?= $itemCountInCart ?></span>
                                                <?php 
                                                } else {
                                                ?>
                                                    <span></span> <!-- Hoặc có thể xóa dòng này nếu không cần output -->
                                                <?php
                                                }
                                            } else {
                                            ?>
                                                <span></span> <!-- Hoặc có thể xóa dòng này nếu không cần output -->
                                            <?php
                                            }
                                        }
                                        // Nếu chưa đăng nhập hoặc không có ID người dùng, không hiển thị badge.
                                    ?>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container ">
                <form class="d-flex justify-content-between search-inner" action="product.php" method="GET" autocomplete="off">
                    <input type="text" class="form-control" id="search_input" name="tim" placeholder="Nhập tên sản phẩm cần tìm">
                    <button type="submit" class="btn"></button>
                    <span class="ti-close" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </section>
    <!-- Kết thúc phần Header-->

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
<!-- owl carousel js -->
<script src="js/jquery.nice-select.min.js"></script>
<!-- nice select js -->
<script src="js/slick.min.js"></script>
<!-- slick js -->
<script src="js/jquery.counterup.min.js"></script>
<!-- counterup js -->
<script src="js/waypoints.min.js"></script>
<!-- waypoints js -->
<script src="js/contact.js"></script>
<!-- contact js -->
<script src="js/jquery.ajaxchimp.min.js"></script>
<!-- ajaxchimp js -->
<script src="js/jquery.form.js"></script>
<!-- form js -->
<script src="js/jquery.validate.min.js"></script>
<!-- validate js -->
<script src="js/mail-script.js"></script>
<!-- mail script js -->
<script src="js/stellar.js"></script>
<!-- stellar js -->
<script src="js/price_rangs.js"></script>
<!-- price rangs js -->
<!-- custom js -->
<script src="js/custom.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  var searchInputBox = $('#search_input_box');
  var searchIcon = $('#search_1');
  var closeSearchIcon = $('#close_search');

  function openSearch() {
    searchInputBox.slideDown('fast');
  }

  function closeSearch() {
    searchInputBox.slideUp('fast');
  }

  searchIcon.on('click', function(event) {
    event.preventDefault();
    if (searchInputBox.is(':visible')) {
      closeSearch();
    } else {
      openSearch();
    }
  });

  closeSearchIcon.on('click', function() {
    closeSearch();
  });

  $(document).on('click', function(event) {
    if (!searchInputBox.is(event.target) && 
        searchInputBox.has(event.target).length === 0 && 
        !searchIcon.is(event.target) && 
        searchIcon.has(event.target).length === 0) {
      if (searchInputBox.is(':visible')) {
        closeSearch();
      }
    }
  });
});
</script>

<style>
body {
    -webkit-user-select: none;  /* Safari */
    -ms-user-select: none;      /* Internet Explorer/Edge */
    user-select: none;          /* Non-prefixed version, currently supported by Chrome, Edge, Opera and Firefox */
}
.header_bg {
    background-color: #ecfdff;
}
</style>

</body>

</html>
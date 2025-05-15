<?php 
    include './connect.php';
?>
<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Smobile - Đăng Ký</title>
    <link rel="icon" href="img/logos.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .header_bg {
            background-color: #ecfdff;
            height: 230px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .login_part_form_iner {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }
        .input-group-text {
            background-color: #f1f1f1;
            border: none;
        }
    </style>
</head>

<body>

<!--================Header Banner=================-->
<section class="breadcrumb header_bg" style="padding: 60px 0; text-align: center; background-color: #f5fafe;">
    <div class="container">
        <h1 style="font-size: 40px; font-weight: bold; color: #333;">Đăng ký tài khoản mới</h1>
        <p style="font-size: 18px; color: #666;">Vui lòng điền đầy đủ thông tin bên dưới để đăng ký.</p>
    </div>
</section>

<!--================Register Form=================-->
<section class="login_part">
    <div class="container">
        <div class="col-lg-6 col-md-8" style="margin: auto;">
            <div class="login_part_form">
                <div class="login_part_form_iner">
                    <h3 class="mb-4">Tạo Tài Khoản</h3>

                    <?php 
                        if (isset($_POST["dangky"])) {
                            $ten = $_POST["ten"];
                            $email = $_POST["email"];
                            $sdt = $_POST["sdt"];
                            $matkhau = $_POST["matkhau"];
                            $nlmatkhau = $_POST["nlmatkhau"];
                            
                            if($ten != ""){
                                if($email != ""){
                                    if($sdt != ""){
                                        if($matkhau != ""){
                                            if ($matkhau !== $nlmatkhau) {
                                                $error ='Nhập lại mật khẩu không chính xác';
                                            } else {
                                                if (rowCount("SELECT * FROM taikhoan WHERE taikhoan='$email'") > 0) {
                                                    $error ='Tài khoản đã có người sử dụng';
                                                } else {
                                                    selectAll("INSERT INTO taikhoan VALUES (NULL,'$email','$matkhau','$ten','','$sdt','','0','0')");
                                                    $success = 'Đăng ký thành công, vui lòng đăng nhập';
                                                    header('Location: login.php');
                                                    exit;
                                                }
                                            }
                                        } else {
                                            $error = 'Mật khẩu không được để trống';
                                        }
                                    } else {
                                        $error = 'SĐT không được để trống';
                                    }
                                } else {
                                    $error = 'Email không được để trống';
                                }
                            } else {
                                $error = 'Họ tên không được để trống';
                            }
                        }
                    ?>

                    <form class="row contact_form" action="" method="post" novalidate="novalidate">
                        <?php 
                            if (isset($error)) {
                                echo '<p class="text-danger ml-3 mb-3 text-center">' . $error . '</p>';
                            }
                            if (isset($success)) {
                                echo '<p class="text-success ml-3 mb-3 text-center">' . $success . '</p>';
                            }
                        ?>

                        <!-- Họ Tên -->
                        <div class="col-md-12 form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="ten" class="form-control" placeholder="Họ Tên" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>

                        <!-- SĐT -->
                        <div class="col-md-12 form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" name="sdt" class="form-control" placeholder="Số Điện Thoại" required>
                            </div>
                        </div>

                        <!-- Mật Khẩu -->
                        <div class="col-md-12 form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="matkhau" class="form-control" placeholder="Mật Khẩu" required>
                            </div>
                        </div>

                        <!-- Nhập lại Mật Khẩu -->
                        <div class="col-md-12 form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="nlmatkhau" class="form-control" placeholder="Nhập Lại Mật Khẩu" required>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-md-12 form-group text-center">
                            <button type="submit" name="dangky" value="submit" class="btn_3 mb-3">
                                Đăng ký
                            </button>
                            <br>
                            <a href="login.php" class="btn_3">Quay về Đăng Nhập</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!--================ Scripts =================-->
<script src="js/jquery-1.12.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.magnific-popup.js"></script>
<script src="js/swiper.min.js"></script>
<script src="js/masonry.pkgd.js"></script>
<script src="js/owl.carousel.min.js"></script>
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

</body>
</html>

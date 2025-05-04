<?php
    include './connect.php';
?>
<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Smobile - Đăng Nhập</title>
    <link rel="icon" href="img/logos.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        .login_part_form .form-group {
            margin-bottom: 15px;
        }

        .login_part_form .input-with-icon {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .login_part_form .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 1.2em;
            z-index: 1;
        }

    
        .login_part_form .input-with-icon .form-control {
            padding-left: 40px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            width: 100%;
            height: 45px;
        }

        .login_part_form .input-with-icon .form-control:focus {
            outline: none;
            box-shadow: none;
            border-color: #ee4d2d; 
        }


        .login_part_form .input-with-icon .form-control::placeholder {
            color: #aaa;
            font-style: italic;
        }

        .login_part_form .input-with-icon .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            font-size: 1.2em;
            z-index: 1;
        }


        .login_part_form .btn_3 {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-radius: 4px;
            background-color: #ee4d2d;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .login_part_form .btn_3:hover {
            background-color: #d43c1e;
        }

        /* Стилі cho container form */
        .login_part_form_iner {
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login_part_form_iner h3 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .text-danger {
            color: #dc3545 !important;
        }
        .ml-3 {
            margin-left: 1rem !important;
        }
        .mb-3 {
            margin-bottom: 1rem !important;
        }
    </style>
</head>

<body>

    <?php include 'header.php';?>

    <section class="breadcrumb header_bg">
        <div class="container">
            <div class="row justify-content-center a2">
                <div class="col-lg-8 a2">
                    <div class="a1">
                        </div>
                </div>
            </div>
        </div>
    </section>
    <section class="login_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>Mới đến cửa hàng của chúng tôi?</h2>
                            <p>Vui lòng đăng ký tài khoản để có trải nghiệm tốt nhất</p>
                            <a href="register.php" class="btn_3">Đăng ký</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>Vui Lòng Đăng Nhập</h3>
                            <?php
                                if (isset($_POST["dangnhap"])) {
                                    $email = ($_POST["email"]);
                                    $matkhau = ($_POST["matkhau"]);
                                    if (rowCount("SELECT * FROM taikhoan WHERE taikhoan='$email' && matkhau='$matkhau' && status =0") == 1) {
                                        setcookie('user', $email, time() + (86400 * 30), "/");
                                        header('location:index.php');
                                    }
                                    else if (rowCount("SELECT * FROM taikhoan WHERE status =1") == 1){
                                        $error = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ admin';
                                    }
                                    else{
                                        $error = 'Tài khoản hoặc mật khẩu không chính xác. Vui lòng kiểm tra lại';
                                    }
                                }
                            ?>
                            <form class="row contact_form" action="" method="post" novalidate="novalidate">
                                <?php
                                    if (isset($error)) {
                                    ?>
                                        <p class="text-danger ml-3 mb-3"><?= $error ?></p>
                                    <?php
                                    }
                                ?>
                                <div class="col-md-12 form-group">
                                    <div class="input-with-icon">
                                        <i class="fa fa-user"></i>
                                        <input type="text" class="form-control" id="email" name="email" value="" required placeholder="Tài khoản (Email)">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="input-with-icon">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" class="form-control" id="matkhau" name="matkhau" value="" required placeholder="Mật khẩu">
                                        <span id="togglePassword" class="toggle-password" style="cursor: pointer;">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" name="dangnhap" class="btn_3">
                                        đăng nhập
                                    </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('input[name="matkhau"]');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>

</html>
<?php 
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
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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


.form-control {
    border-radius: 10px;
    padding: 15px;
    border: 1px solid #e8e8e8;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.form-control:focus {
    border-color: #ff3368;
    box-shadow: 0 0 0 0.2rem rgba(255, 51, 104, 0.25);
    background-color: #fff;
}

.form-group p {
    font-weight: 500;
    margin-bottom: 8px;
    color: #333;
}

.btn_3 {
    font-size: 15px;
    padding: 13px 25px;
    text-transform: uppercase;
    font-weight: 500;
    transition: all 0.4s ease;
    border: none;
}

.btn_3:hover {
    background-color: #ff3368;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 51, 104, 0.3);
}

.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 15px;
    top: 15px;
    color: #6c757d;
}

.input-with-icon input {
    padding-left: 40px;
}

.form-section {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.form-header {
    text-align: center;
    margin-bottom: 25px;
}

.form-header h4 {
    color: #333;
    font-weight: 600;
}

.alert {
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: #ffe5e8;
    border-color: #ffb3c0;
    color: #d63384;
}

.alert-success {
    background-color: #e8f6e8;
    border-color: #b3e6b3;
    color: #198754;
}

.password-strength {
    height: 5px;
    margin-top: 5px;
    background: #e9ecef;
    border-radius: 3px;
}

.password-strength-meter {
    height: 100%;
    border-radius: 3px;
    transition: width 0.3s;
}

.weak {
    width: 33%;
    background-color: #dc3545;
}

.medium {
    width: 66%;
    background-color: #ffc107;
}

.strong {
    width: 100%;
    background-color: #28a745;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 15px;
    cursor: pointer;
}

.password-tips {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
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
                        <div class="a1">
                            <!-- <h2>Thông Tin Tài Khoản</h2> -->
                        </div>
                </div>
            </div>
        </div>
    </section>
  <!-- breadcrumb end-->

    <!--================login_part Area =================-->
    <section class="login_part" style="font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; padding: 50px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="form-section">
                        <div class="form-header">
                            <h4>Đổi Mật Khẩu</h4>
                            <p class="text-muted">Cập nhật mật khẩu tài khoản của bạn</p>
                        </div>
                        
                        <?php 
                            foreach (selectAll("SELECT * FROM taikhoan WHERE id=$id_nguoidung") as $item) {
                                $taikhoancu = $item['taikhoan'];
                            }
                            if (isset($_POST["doimatkhau"])) {
                                $matkhau = ($_POST["matkhau"]);
                                $nlmatkhau = ($_POST["nlmatkhau"]);
                                $matkhaucu = ($_POST["matkhaucu"]);
                                if ($matkhau!==$nlmatkhau) {
                                    $error ='Nhập lại mật khẩu không chính xác!';
                                }else{
                                    if (rowCount("SELECT * FROM taikhoan WHERE id=$id_nguoidung AND matkhau='$matkhaucu'")==1) {
                                        if ($matkhau !== $matkhaucu) {
                                            selectAll("UPDATE taikhoan SET matkhau='$nlmatkhau' WHERE id=$id_nguoidung");
                                            $success='Đổi mật khẩu thành công.';
                                        }
                                        else{
                                            $error ='Mật khẩu mới phải khác mật khẩu cũ!';
                                        }
                                    }else{
                                        $error ='Mật khẩu cũ không chính xác!';
                                    }
                                }
                            }
                        ?>
                        
                        <form class="row" action="" method="post">
                            <?php 
                                if (isset($error)) {
                                    echo '<div class="col-md-12"><div class="alert alert-danger"><i class="fas fa-exclamation-circle mr-2"></i>' . $error . '</div></div>';
                                }
                                if (isset($success)) {
                                    echo '<div class="col-md-12"><div class="alert alert-success"><i class="fas fa-check-circle mr-2"></i>' . $success . '</div></div>';
                                }           
                            ?>
                            
                            <!-- Tài khoản email -->
                            <div class="col-md-12 form-group">
                                <p>Tài Khoản (Email)</p>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="text" class="form-control" name="email" value="<?= $taikhoancu ?>" placeholder="Tài Khoản (Email)" readonly required >
                                </div>
                            </div>
                            
                            <!-- Mật khẩu cũ -->
                            <div class="col-md-12 form-group">
                                <p>Mật Khẩu Cũ<span class="text-danger">*</span></p>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="matkhaucu" class="form-control" name="matkhaucu" placeholder="Nhập mật khẩu cũ" required>
                                    <span class="password-toggle" onclick="togglePassword('matkhaucu')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Mật khẩu mới -->
                            <div class="col-md-12 form-group">
                                <p>Mật Khẩu Mới<span class="text-danger">*</span></p>
                                <div class="input-with-icon">
                                    <i class="fas fa-key"></i>
                                    <input type="password" id="matkhau" class="form-control" name="matkhau" placeholder="Mật khẩu mới" required onkeyup="checkPasswordStrength()">
                                    <span class="password-toggle" onclick="togglePassword('matkhau')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                <div class="password-strength">
                                    <div id="password-strength-meter" class="password-strength-meter"></div>
                                </div>
                                <div class="password-tips">
                                    <small>Mật khẩu nên có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt</small>
                                </div>
                            </div>
                            
                            <!-- Nhập lại mật khẩu mới -->
                            <div class="col-md-12 form-group">
                                <p>Nhập Lại Mật Khẩu Mới<span class="text-danger">*</span></p>
                                <div class="input-with-icon">
                                    <i class="fas fa-key"></i>
                                    <input type="password" id="nlmatkhau" class="form-control" name="nlmatkhau" placeholder="Nhập lại mật khẩu mới" required onkeyup="checkPasswordMatch()">
                                    <span class="password-toggle" onclick="togglePassword('nlmatkhau')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                <div id="password-match" class="password-tips"></div>
                            </div>
                            
                            <!-- Nút đổi mật khẩu và hủy -->
                            <div class="col-md-12 form-group">
                                <div class="button-group">
                                    <button type="submit" name="doimatkhau" class="btn_3">
                                        <i class="fas fa-save"></i> Đổi Mật Khẩu
                                    </button>
                                    <a href="infor.php" class="btn_3" style="background-color: #6c757d;">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    
    <!-- Custom JavaScript -->
    <script>
        // Hiển thị/ẩn mật khẩu
        function togglePassword(inputId) {
            var x = document.getElementById(inputId);
            var icon = event.currentTarget.querySelector('i');
            if (x.type === "password") {
                x.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                x.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        
        // Kiểm tra độ mạnh của mật khẩu
        function checkPasswordStrength() {
            var password = document.getElementById("matkhau").value;
            var meter = document.getElementById("password-strength-meter");
            
            // Xóa các class cũ
            meter.classList.remove("weak", "medium", "strong");
            
            if (password.length === 0) {
                meter.style.width = "0";
                return;
            }
            
            // Kiểm tra độ mạnh
            var strength = 0;
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
            if (password.match(/\d/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            
            // Hiển thị độ mạnh
            switch (strength) {
                case 0:
                case 1:
                    meter.classList.add("weak");
                    break;
                case 2:
                case 3:
                    meter.classList.add("medium");
                    break;
                case 4:
                    meter.classList.add("strong");
                    break;
            }
        }
        
        // Kiểm tra mật khẩu nhập lại
        function checkPasswordMatch() {
            var password = document.getElementById("matkhau").value;
            var confirmPassword = document.getElementById("nlmatkhau").value;
            var matchDiv = document.getElementById("password-match");
            
            if (confirmPassword.length === 0) {
                matchDiv.innerHTML = "";
                return;
            }
            
            if (password === confirmPassword) {
                matchDiv.innerHTML = "<span style='color: #28a745;'><i class='fas fa-check-circle'></i> Mật khẩu khớp</span>";
            } else {
                matchDiv.innerHTML = "<span style='color: #dc3545;'><i class='fas fa-times-circle'></i> Mật khẩu không khớp</span>";
            }
        }
    </script>
</body>

</html>
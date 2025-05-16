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

.profile-image-container {
    text-align: center;
    margin: 20px auto;
}

.profile-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ff3368;
    cursor: pointer;
    transition: all 0.3s ease;
}

.profile-image:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

.btn_3 {
    font-size: 15px;
    padding: 13px 25px;
    text-transform: uppercase;
    font-weight: 500;
    transition: all 0.4s ease;
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

.custom-file-upload {
    display: inline-block;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
    background: #ff3368;
    color: white;
    font-size: 14px;
    text-align: center;
    margin-top: 10px;
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

.input-with-icon input, 
.input-with-icon textarea {
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

.uploaded {
    animation: pulse 0.5s;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.focused {
    border-color: #ff3368;
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
                        <!-- <div class="a1">
                            <h2>Thông Tin Tài Khoản</h2>
                        </div> -->
                </div>
            </div>
        </div>
    </section>
  <!-- breadcrumb end-->

    <!--================login_part Area =================-->
    <section class="login_part" style="font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; padding: 50px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="form-section">
                        <div class="form-header">
                            <h4>Thông Tin Cá Nhân</h4>
                            <p class="text-muted">Cập nhật thông tin tài khoản của bạn</p>
                        </div>
                        
                        <?php 
                            foreach (selectAll("SELECT * FROM taikhoan WHERE id=$id_nguoidung") as $item) {
                                $tencu = $item['hoten'];
                                $taikhoancu = $item['taikhoan'];
                                $sdtcu = $item['sdt'];
                                $anh = $item['anh'];
                                $loaitk = $item['phanquyen'];
                                $diachicu = $item['diachi'];
                            }
                            if (isset($_POST["doithongtin"])) {
                                $hoten = $_POST["hoten"];
                                $sdt = $_POST["sdt"];
                                $diachi = $_POST["diachi"];
                                $anh1 = $_FILES['anh1']['name'];
                                $tmp1 = $_FILES['anh1']['tmp_name'];
                                $type1 = $_FILES['anh1']['type'];
                                $dir = './img/account/';
                                move_uploaded_file($tmp1, $dir . $anh1);
                                if (empty($anh1)) {
                                    selectAll("UPDATE taikhoan SET hoten='$hoten',sdt='$sdt', diachi='$diachi' WHERE id=$id_nguoidung");
                                }
                                else{   
                                    selectAll("UPDATE taikhoan SET hoten='$hoten', anh='$anh1', sdt='$sdt', diachi='$diachi' WHERE id=$id_nguoidung");
                                }
                                echo "<meta http-equiv='refresh' content='0'>";
                            }
                        ?>
                        
                        <form class="row contact_form" action="" method="post" novalidate="novalidate" enctype="multipart/form-data">
                            <!-- Ảnh đại diện -->
                            <div class="col-md-12">
                                <div class="profile-image-container">
                                    <label for="imgInp" style="cursor:pointer; display: block;">
                                        <img id="blah" class="profile-image" src="<?= empty($anh)?'./img/account/user.png':'./img/account/'.$anh.'' ?>" alt="Ảnh đại diện" />
                                        <div class="custom-file-upload">
                                            <i class="fas fa-camera"></i> Cập nhật ảnh
                                        </div>
                                    </label>
                                    <input hidden type="file" name="anh1" accept="image/*" id="imgInp" class="form-control">
                                </div>
                            </div>
                            
                            <!-- Tài khoản email -->
                            <div class="col-md-12 form-group">
                                <p>Tài Khoản (Email)</p>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="text" class="form-control" name="email" value="<?= $taikhoancu ?>" placeholder="Tài Khoản (Email)" readonly required>
                                </div>
                            </div>
                            
                            <!-- Họ tên -->
                            <div class="col-md-12 form-group">
                                <p>Họ Tên<span class="text-danger">*</span></p>
                                <div class="input-with-icon">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="hoten" class="form-control" name="hoten" required value="<?= $tencu ?>" placeholder="Nhập họ tên của bạn">
                                </div>
                            </div>
                            
                            <!-- SĐT -->
                            <div class="col-md-12 form-group">
                                <p>Số Điện Thoại<span class="text-danger">*</span></p>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone"></i>
                                    <input type="text" id="sdt" class="form-control" name="sdt" value="<?= $sdtcu ?>" placeholder="Nhập số điện thoại" required>
                                </div>
                            </div>
                            
                            <!-- Địa chỉ -->
                            <div class="col-md-12 form-group">
                                <p>Địa Chỉ<span class="text-danger">*</span></p>
                                <div class="input-with-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <textarea id="diachi" class="form-control" rows="3" name="diachi" placeholder="Nhập địa chỉ chi tiết" required><?= $diachicu ?></textarea>
                                </div>
                            </div>
                            
                            <!-- Nút đổi mật khẩu -->
                            <div class="col-md-12 form-group text-right">
                                <a href="password.php" class="text-primary">Đổi mật khẩu <i class="fas fa-key"></i></a>
                            </div>
                            
                            <!-- Nút cập nhật và hủy -->
                            <div class="col-md-12 form-group">
                                <div class="button-group">
                                    <button type="submit" name="doithongtin" class="btn_3">
                                        <i class="fas fa-save"></i> Cập nhật
                                    </button>
                                    <a href="index.php" class="btn_3" style="background-color: #6c757d;">
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
        // Hiệu ứng khi focus vào input
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
        
        // Hiệu ứng khi tải ảnh
        imgInp.onchange = evt => {
            const [file] = imgInp.files;
            if (file) {
                blah.src = URL.createObjectURL(file);
                // Thêm hiệu ứng
                blah.classList.add('uploaded');
                setTimeout(() => {
                    blah.classList.remove('uploaded');
                }, 1500);
            }
        }
        
        // Kiểm tra số điện thoại
        document.getElementById('sdt').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>

    <?php include 'footer.php';?>
</body>

</html>

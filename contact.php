<?php 
    include './connect.php';  
?>
<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liên hệ</title>
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
    
    .padding_top1 {
        padding-top: 20px;
    }
    
    .a1 {
        padding-top: 130px;
    }
    
    .a2 {
        height: 230px;
    }

    .contact-info {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        transition: transform 0.3s ease;
    }

    .contact-info:hover {
        transform: translateY(-5px);
    }

    .contact-info__icon {
        background: #ecfdff;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        text-align: center;
        line-height: 50px;
        margin-right: 20px;
    }

    .contact-info__icon i {
        font-size: 20px;
        color: #222;
    }

    .media-body h3 {
        font-family: 'Roboto', Arial, sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #222;
        margin-bottom: 8px;
    }

    .media-body p {
        font-size: 15px;
        line-height: 1.6;
        color: #666;
        margin: 0;
    }

    #map {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    #map iframe {
        display: block;
    }

    .contact-section {
        background: #fff;
        padding: 80px 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-family: 'Roboto', Arial, sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #222;
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }

    .section-title h2:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 2px;
        background-color: #222;
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
                        <h2>Thông Tin Liên Hệ</h2>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end-->

    <!-- ================ contact section start ================= -->
    <section class="contact-section">
        <div class="container">
            <div class="section-title">
                <h2>THÔNG TIN LIÊN HỆ</h2>
            </div>
            <div class="row">
                
                <div class="col-lg-8">
                        <div class="row">
                            <div class="col-12">
                                <div id="map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.779913365154!2d105.82433209999999!3d21.
                                        0014576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac85c14f1557%3A0xcd7d66f85770532!2sSmobile!
                                        5e0!3m2!1svi!2s!4v1651914742953!5m2!1svi!2s" 
                                        width="100%" height="300" style="border:0;" allowfullscreen="" 
                                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>Địa Chỉ</h3>
                            <p>1A6 P. Cù Chính Lan, Khương Thượng, Thanh Xuân, Hà Nội</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>Hotline</h3>
                            <p>0839.363.363 (8h00 - 22h00)</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>Email</h3>
                            <p>smobleshop@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ contact section end ================= -->

    <?php include 'footer.php';?>

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
    <!-- custom js -->
    <script src="js/custom.js"></script>
    
</body>


</html>


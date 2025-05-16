<?php 
    include './connect.php';
    if (isset($_GET["id"])) {
        foreach (selectAll("SELECT * FROM danhmuc WHERE id={$_GET['id']}") as $item) {
           $tendanhmuc = $item['danhmuc'];
            $iddanhmuc = $item['id'];
        }
    }
   
?>
<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sản phẩm </title>
    <link rel="icon" href="img/logos.png">
    <!-- FontAwesome for menu icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
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
    <!-- noUiSlider CSS for price range -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" />
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


.category-toggle {
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    background-color: #ecfdff;
    border-radius: 5px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.category-toggle:hover {
    background-color: #d4f7fa;
}

.category-toggle i {
    transition: transform 0.3s ease;
}

.category-toggle.active i {
    transform: rotate(180deg);
}

.category-content {
    display: none;
    padding: 10px 15px;
}

.category-content.show {
    display: block;
}

.category-content ul {
    list-style: none;
    padding-left: 15px;
}

.category-content ul li {
    margin: 8px 0;
}

.category-content ul li a {
    color: #666666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.category-content ul li a:hover {
    color: #ff3368;
}

.category-main-toggle {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    padding-left: 0;
    margin-bottom: 10px;
    background: none;
    border: none;
    box-shadow: none;
    border-radius: 0;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    transition: background 0.2s, box-shadow 0.2s;
}
.category-main-toggle:hover,
.category-main-toggle.active {
    background: #f8f9fa;
    box-shadow: 0 2px 8px #0001;
}
.category-main-toggle .menu-icon {
    margin-left: 10px;
    flex-shrink: 0;
    transition: transform 0.3s cubic-bezier(.4,2,.6,1);
    font-size: 22px;
}
.category-main-toggle.active .menu-icon {
    transform: rotate(90deg);
}

.category-list {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transition: max-height 0.4s cubic-bezier(.4,2,.6,1), opacity 0.3s;
    padding: 10px 0;
}

.category-list.show {
    max-height: 500px;
    opacity: 1;
}

.category-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list ul li {
    padding: 8px 15px;
    transition: all 0.3s ease;
    font-family: 'Roboto', Arial, sans-serif;
    font-size: 17px;
    color: #444;
}

.category-list ul li:hover {
    background-color: #f8f9fa;
}

.category-list ul li a {
    color: #666666;
    text-decoration: none;
    display: block;
}

.category-list ul li a:hover {
    color: #ff3368;
}


.category-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-family: 'Roboto', Arial, sans-serif;
    font-size: 17px;
    color: #444;
}

.category-filter-checkbox {
    accent-color: #ff3368;
    width: 18px;
    height: 18px;
}

#sort_price, #sort_price option,
#min_price, #max_price {
    font-family: 'Roboto', Arial, sans-serif !important;
    font-size: 16px;
}
#sort_price {
    height: 40px;
    border-radius: 5px;
}

/* bộ lọc */
.filter_price_sort label,
.sort-price-group label {
    color: #222;
    font-weight: 500;
    margin-bottom: 4px;
    display: block;
    letter-spacing: 0.5px;
}

/* Input số */
.filter_price_sort input[type="number"] {
    border: 1.5px solid #222;
    border-radius: 5px;
    color: #222;
    font-weight: 500;
    transition: border-color 0.2s;
}
.filter_price_sort input[type="number"]:focus {
    border-color: #ff3368;
    box-shadow: 0 0 0 2px #ff33684d;
}

/* Radio group style */
.radio-group {
    display: flex;
    gap: 18px;
    margin-top: 4px;
}
.radio-inline {
    font-size: 16px;
    color: #222;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
}
.radio-inline input[type="radio"] {
    accent-color: #222;
    width: 18px;
    height: 18px;
}
.radio-inline input[type="radio"]:focus {
    outline: 2px solid #222;
}

.category-main-toggle h3 {
    white-space: nowrap;
    margin: 0;
    padding-top: 6px;
    font-weight: 700;
    color: #222;
    display: inline-block;
    font-size: 18px;
}


.section_tittle h3 {
    font-family: 'Roboto', Arial, sans-serif;
    font-weight: 700;
    color: #222;
    font-size: 18px;
    letter-spacing: 0.5px;
    margin-bottom: 30px;
    display: inline-block;
    position: relative;
    padding: 0 15px;
}

.section_tittle h3:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #222;
    transform: scaleX(0.8);
    transition: transform 0.3s ease;
}

.section_tittle:hover h3:after {
    transform: scaleX(1);
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

    <!--================Category Product Area =================-->
    <section class="cat_product_area ">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="left_sidebar_area">
                        <aside class="left_widgets p_filter_widgets">
                            <div class="category-main-toggle">
                                <h3>DANH MỤC SẢN PHẨM</h3>
                                <i class="fa-solid fa-bars menu-icon"></i>
                            </div>
                            <div class="category-list">
                                <ul>
                                <?php 
                                    foreach (selectAll("SELECT * FROM danhmuc") as $item) {
                                        ?>
                                            <li>
                                              <label class="category-checkbox">
                                                <input type="checkbox" value="<?= $item['id_dm'] ?>" class="category-filter-checkbox">
                                                <span><?= $item['danhmuc'] ?></span>
                                              </label>
                                            </li>
                                        <?php
                                    }
                                ?>
                                </ul>
                            </div>
                            <!-- Thêm bộ lọc giá và sắp xếp -->
                            <div class="filter_price_sort" style="margin-top: 20px;">
                                <div style="margin-bottom: 10px;">
                                    <label for="min_price">Giá từ:</label>
                                    <input type="number" id="min_price" class="form-control" style="width: 100%;" placeholder="Tối thiểu" min="0">
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label for="max_price">Đến:</label>
                                    <input type="number" id="max_price" class="form-control" style="width: 100%;" placeholder="Tối đa" min="0">
                                </div>
                                <div class="sort-price-group radio-sort" style="margin-bottom: 10px;">
                                    <label>Sắp xếp theo giá:</label>
                                    <div class="radio-group">
                                        <label class="radio-inline">
                                            <input type="radio" name="sort_price" value="" checked> Không sắp xếp
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sort_price" value="asc"> Tăng dần
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sort_price" value="desc"> Giảm dần
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product_top_bar d-flex justify-content-between align-items-center">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center latest_product_inner">
                    <?php 
                        if (isset($_GET["tim"])) {
                            $keyword = $_GET["tim"];
                            $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:6;
                            $current_page = !empty($_GET['page'])?$_GET['page']:1;
                            $offset = ($current_page - 1) * $item_per_page;
                            $numrow = rowCount("SELECT * FROM `sanpham` WHERE `ten` LIKE '%$keyword%' AND status = 0");
                            $totalpage = ceil($numrow / $item_per_page);
                            if (rowCount("SELECT * FROM `sanpham` WHERE `ten` LIKE '%$keyword%' AND status = 0")>0) {
                                foreach (selectAll("SELECT * FROM `sanpham` WHERE `ten` LIKE '%$keyword%' AND status = 0 LIMIT $item_per_page OFFSET $offset") as $row) {
                                ?>              
                                <div class="col-lg-4 col-sm-6" style="height: 500px;">
                                    <div class="single_product_item" <?= $row['id'] ?> >
                                        <a href="detail.php?id=<?= $row['id'] ?>" >
                                            <img src="img/product/<?= $row['anh1'] ?>" style="width: 230px;height: 230px;" alt="">
                                        </a>
                                        <div class="single_product_text">
                                            <h4 style="font-size: 16px"><?= $row['ten'] ?></h4>
                                            <h3><?= number_format($row['gia']) . 'đ' ?></h3>
                                            <p><a href="detail.php?id=<?= $row['id'] ?>" style="font-size: 14px">Xem chi tiết</a></p>
                                            <a href="detail.php?id=<?= $row['id'] ?>">+ Thêm vào giỏ</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                            }else{
                            ?>
                                <p>Không tìm thấy sản phẩm</p>
                            <?php
                            }?>
                            <div class="col-lg-12">
                            <div class="pageination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                    <?php 
                                        if ($current_page>1){
                                            $prev_page = $current_page - 1;
                                    ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?tim=<?=$keyword?>&per_page=<?=$item_per_page?>&page=<?=$prev_page?>" aria-label="Previous">
                                                <i class="ti-angle-double-left"></i>
                                            </a>
                                        </li>
                                    <?php 
                                    } ?>
                                        
                                        <?php for($num = 1; $num <=$totalpage;$num++) { ?>
                                            <?php 
                                                if ($num != $current_page){ 
                                            ?>
                                                <?php if ($num > $current_page-3 && $num < $current_page+3){ ?>
                                                <li class="page-item"><a class="page-link" href="?tim=<?=$keyword?>&per_page=<?=$item_per_page?>&page=<?=$num?>"><?=$num?></a></li>
                                                <?php } ?>
                                            <?php 
                                            } 
                                            else{ 
                                            ?>
                                                <strong class="page-item"><a class="page-link"><?=$num?></a></strong>
                                            <?php 
                                            }
                                        } 
                                        ?>

                                    <?php 
                                        if ($current_page < $totalpage - 1){
                                            $next_page = $current_page + 1;
                                    ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?tim=<?=$keyword?>&per_page=<?=$item_per_page?>&page=<?=$next_page?>" aria-label="Next">
                                                <i class="ti-angle-double-right"></i>
                                            </a>
                                        </li>
                                    <?php 
                                        } ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <?php    
                        }
                        else{
                        ?>
                            <div class="row align-items-center latest_product_inner">
                                
                                <?php 
                                $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:6;
                                $current_page = !empty($_GET['page'])?$_GET['page']:1;
                                $offset = ($current_page - 1) * $item_per_page;
                                $numrow = rowCount("SELECT * FROM sanpham WHERE status = 0");
                                $totalpage = ceil($numrow / $item_per_page);
                                foreach (selectAll("SELECT * FROM sanpham WHERE status = 0 LIMIT $item_per_page OFFSET $offset") as $row) {    
                                ?>
                                    <div class="col-lg-4 col-sm-6" style="height: 500px;">
                                        <div class="single_product_item" <?= $row['id'] ?> >
                                        <a href="detail.php?id=<?= $row['id'] ?>" >
                                            <img src="img/product/<?= $row['anh1'] ?>" style="width: 230px;height: 230px;" alt="">
                                        </a>
                                            <div class="single_product_text">
                                                <h4 style="font-size: 16px"><?= $row['ten'] ?></h4>
                                                <h3><?= number_format($row['gia']) . 'đ' ?></h3>
                                                <p><a href="detail.php?id=<?= $row['id'] ?>" style="font-size: 14px">Xem chi tiết</a></p>
                                                <a href="detail.php?id=<?= $row['id'] ?>">+ Thêm vào giỏ</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="col-lg-12">
                            <div class="pageination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                    <?php 
                                        if ($current_page>1){
                                            $prev_page = $current_page - 1;
                                    ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?per_page=<?=$item_per_page?>&page=<?=$prev_page?>" aria-label="Previous">
                                                <i class="ti-angle-double-left"></i>
                                            </a>
                                        </li>
                                    <?php 
                                    } ?>
                                        
                                        <?php for($num = 1; $num <=$totalpage;$num++) { ?>
                                            <?php 
                                                if ($num != $current_page){ 
                                            ?>
                                                <?php if ($num > $current_page-3 && $num < $current_page+3){ ?>
                                                <li class="page-item"><a class="page-link" href="?per_page=<?=$item_per_page?>&page=<?=$num?>"><?=$num?></a></li>
                                                <?php } ?>
                                            <?php 
                                            } 
                                            else{ 
                                            ?>
                                                <strong class="page-item"><a class="page-link"><?=$num?></a></strong>
                                            <?php 
                                            }
                                        } 
                                        ?>

                                    <?php 
                                        if ($current_page < $totalpage - 1){
                                            $next_page = $current_page + 1;
                                    ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?per_page=<?=$item_per_page?>&page=<?=$next_page?>" aria-label="Next">
                                                <i class="ti-angle-double-right"></i>
                                            </a>
                                        </li>
                                    <?php 
                                        } ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <?php
                        }?>

                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Category Product Area =================-->

       <!-- product_list part start-->
       <section class="product_list best_seller">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section_tittle text-center">
                        <h3>SẢN PHẨM HOT</h3>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-12">
                    <div class="best_product_slider owl-carousel">
                    <?php 
                        foreach (selectAll("SELECT * FROM sanpham ORDER BY luotxem DESC LIMIT 5 ") as $item) {
                    ?>
                        <div class="single_product_item">
                            <a href="detail.php?id=<?= $item['id'] ?>" >
                                <img src="img/product/<?= $item['anh1'] ?>" alt="">
                            </a>
                            <div class="single_product_text">
                                <a href="detail.php?id=<?= $item['id'] ?>" >
                                <h4><?= $item['ten'] ?></h4>
                                <h3><?= number_format($item['gia']) . 'đ' ?></h3>
                                </a>
                            </div>

                        </div>

            
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product_list part end-->

    <!-- jquery plugins here-->
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
    <!-- noUiSlider JS for price range -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle danh mục
        const mainToggle = document.querySelector('.category-main-toggle');
        const categoryList = document.querySelector('.category-list');
        if(mainToggle && categoryList) {
            mainToggle.addEventListener('click', function(e) {
                this.classList.toggle('active');
                categoryList.classList.toggle('show');
                const icon = this.querySelector('.menu-icon');
                if (this.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-chevron-up');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-bars');
                }
            });
        }

        // Lọc sản phẩm theo danh mục, giá, sắp xếp
        const checkboxes = document.querySelectorAll('.category-filter-checkbox');
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        let currentSort = '';
        const sortRadios = document.querySelectorAll('input[name="sort_price"]');

        function sendFilterAjax(page = 1) {
            const formData = new FormData();
            
            // Lấy tất cả danh mục được chọn
            const selectedCategories = Array.from(document.querySelectorAll('.category-filter-checkbox:checked')).map(cb => cb.value);
            
            // Thêm danh mục vào formData
            selectedCategories.forEach(catId => {
                formData.append('category_ids[]', catId);
            });

            // Thêm các tham số khác
            formData.append('min_price', minPriceInput.value || '0');
            formData.append('max_price', maxPriceInput.value || '0');
            formData.append('sort_order', currentSort);
            formData.append('page', page);

            // Gửi AJAX request
            fetch('filter_products.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                const productContainer = document.querySelector('.latest_product_inner');
                productContainer.innerHTML = html;

                // Cập nhật lại các event listener cho phân trang
                document.querySelectorAll('.ajax-page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = this.getAttribute('data-page');
                        sendFilterAjax(page);
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Event listeners cho các bộ lọc
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => sendFilterAjax(1));
        });

        minPriceInput.addEventListener('input', () => sendFilterAjax(1));
        maxPriceInput.addEventListener('input', () => sendFilterAjax(1));

        sortRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                currentSort = this.value;
                sendFilterAjax(1);
            });
        });
    });
    </script>

    <?php include 'footer.php';?>
</body>

</html>

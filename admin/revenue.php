<?php 
  $tongtienhientai = 0;
  $tongtiendutinh = 0;
  $tongtiengiam = 0;
  if (isset($_COOKIE["user"])) {
      $user = $_COOKIE["user"];
      foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
          $permission = $row['phanquyen'];
      }
      if ($permission==1) {
        foreach (selectAll("SELECT * FROM donhang WHERE status =4") as $item) {
          $tongtiengiam += $item['tongtien'];
        }
        foreach (selectAll("SELECT * FROM donhang WHERE status =3") as $item) {
          $tongtienhientai += $item['tongtien'];
        }
        foreach (selectAll("SELECT * FROM donhang WHERE status =3 or status =2 or status =1") as $item2) {
            $tongtiendutinh += $item2['tongtien'];
        }
        
?>
<!-- partial -->
<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">

              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5 class="addfont">Tổng Doanh Thu Thực Tế</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= number_format($tongtienhientai)?>đ</h2>
                          <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
                        </div>
                        <!-- <h6 class="text-muted font-weight-normal">11.38% Since last month</h6> -->
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-cash-multiple text-success ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5 class="addfont">Tổng Doanh Thu Dự Tính</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= number_format($tongtiendutinh)?>đ</h2>
                          <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p> -->
                        </div>
                        <!-- <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6> -->
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                      <i class="icon-lg mdi mdi-chart-line text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title addfont">Thống Kê</h4>
                    <div class="table-responsive">
                    <table class="table">
                      <thead>
                          <tr>
                              <th class="addfont" style="width: 100px">STT</th>
                              <th class="addfont" style="width: 500px" >Họ Tên</th>
                              <th class="addfont" style="width: 400px" >Tài Khoản (Email)</th>
                              <th class="addfont" style="width: 300px">Loại Tài Khoản</th>
                              <th class="addfont" style="width: 300px">Số Đơn Đã Mua</th>
                              <th class="addfont" style="width: 300px">Tổng Tiền</th>
                          </tr>
                      </thead>
                      <tbody>

                      <?php 
                      // Khởi tạo biến STT (Số thứ tự)
                      $stt=1;
                      // Đặt số lượng mục trên mỗi trang từ tham số GET 'per_page', mặc định là 8
                      $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:8;
                      // Lấy trang hiện tại từ tham số GET 'page', mặc định là 1
                      $current_page = !empty($_GET['page'])?$_GET['page']:1;
                      // Tính offset để lấy dữ liệu cho trang hiện tại
                      $offset = ($current_page - 1) * $item_per_page;
                      // Đếm tổng số hàng trong bảng taikhoan
                      $numrow = rowCount("SELECT * FROM taikhoan");
                      // Tính tổng số trang
                      $totalpage = ceil($numrow / $item_per_page);
                      // Lấy danh sách tài khoản có phân trang
                      foreach (selectAll("SELECT * FROM taikhoan LIMIT $item_per_page OFFSET $offset") as $rows) {
                        $idtaikhoan1 = $rows['id'];
                        // Đếm số đơn hàng đã hoàn thành cho tài khoản này
                        $completed_orders_count = rowCount("SELECT * FROM donhang WHERE status=3 && id_taikhoan = $idtaikhoan1");
                        // Tính tổng tiền các đơn hàng đã hoàn thành
                        $totalAmount = 0;
                        foreach (selectAll("SELECT * FROM donhang WHERE status=3 && id_taikhoan = $idtaikhoan1") as $item) {
                          $totalAmount += $item['tongtien'];
                        }
                      ?>
                          <tr class="addfont">
                              <td><?= $stt++ ?></td>
                              <td>   
                                <img src="<?= empty($rows['anh'])?'../img/account/user.png':'../img/account/'.$rows['anh'].'' ?>" alt="image">
                                <span><?= $rows['hoten'] ?></span>
                              </td>
                              <td>
                                <?= $rows['taikhoan'] ?>
                              </td>
                              <td>
                                <?= $rows['phanquyen'] == 1 ? 'Admin' : 'Khách hàng'?>
                              </td>
                              <td>
                                <?= $completed_orders_count ?>
                              </td>
                              <td>
                                <?= number_format($totalAmount) ?>đ
                              </td>
                          </tr>
                      <?php
                        }
                      ?>
                      </tbody>
                  </table>
                  <div class="col-lg-12">
                    <div class="pageination">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php for($num = 1; $num <=$totalpage;$num++) { ?>
                                    <?php 
                                        if ($num != $current_page){ 
                                    ?>
                                        <?php if ($num > $current_page-3 && $num < $current_page+3){ ?>
                                        <li class="page-item"><a class="btn btn-outline-secondary" href="?per_page=<?=$item_per_page?>&page=<?=$num?>"><?=$num?></a></li>
                                        <?php } ?>
                                    <?php 
                                    } 
                                    else{ 
                                    ?>
                                        <strong class="page-item"><a class="btn btn-outline-secondary"><?=$num?></a></strong>
                                    <?php 
                                    }
                                } 
                                ?>
                        </nav>
                    </div>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <script src="./js/search.js?v=<?php echo time()?>"></script>
            <?php
        }
    }
 include 'footer.php';
 ?>
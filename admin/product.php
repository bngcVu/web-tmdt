<?php 
    include 'header.php';
    if (isset($_COOKIE["user"])) {
        $user = $_COOKIE["user"];
        foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
            $permission = $row['phanquyen'];
        }
        
        if ($permission==1) {
            if (isset($_GET["id"])) {
              if(rowCount("SELECT * FROM sanpham WHERE id={$_GET['id']} && status=1 ")>0){
                selectall("UPDATE sanpham SET status=0 WHERE id={$_GET["id"]} && status=1");
                header('location:product.php');
              }
              else {
                selectall("UPDATE sanpham SET status=1 WHERE id={$_GET["id"]} && status=0");
                header('location:product.php');
              }
              
            }

            // biến phân trang trước khi sử dụng
            $item_per_page = $_GET['per_page'] ?? 5; //  toán tử null coalescing
            $current_page = $_GET['page'] ?? 1; 
            $offset = ($current_page - 1) * $item_per_page;
            
            ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row ">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                <h4 class="card-title addfont">Sản Phẩm </h4>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="perPageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Hiển thị: <?= $item_per_page ?> sản phẩm
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="perPageDropdown">
                                            <a class="dropdown-item" href="?per_page=5<?= isset($_GET['page']) ? '&page='.$_GET['page'] : '' ?>">5 sản phẩm</a>
                                            <a class="dropdown-item" href="?per_page=10<?= isset($_GET['page']) ? '&page='.$_GET['page'] : '' ?>">10 sản phẩm</a>
                                            <a class="dropdown-item" href="?per_page=15<?= isset($_GET['page']) ? '&page='.$_GET['page'] : '' ?>">15 sản phẩm</a>
                                            <a class="dropdown-item" href="?per_page=20<?= isset($_GET['page']) ? '&page='.$_GET['page'] : '' ?>">20 sản phẩm</a>
                                        </div>
                                    </div>
                                    <a type="button" class="btn btn-success btn-fw" style="width: 204px" href="addproduct.php">Thêm Sản Phẩm</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="addfont" style="width: 20px">STT</th>
                                                <th class="addfont" style="width: 400px" >Tên Sản Phẩm</th>
                                                <th class="addfont"  >Danh Mục</th>
                                                <th class="addfont" > Giá </th>
                                                <th class="addfont" >Ảnh Sản Phẩm</th>
                                                <th class="addfont" >Trạng Thái</th>
                                                <th></th>
                                                <th><a type="button" class="btn btn-success btn-fw" style="width: 204px" href="addproduct.php">Thêm Sản Phẩm</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php 
                                        $stt=1;
                                        $numrow = rowCount("SELECT * FROM sanpham WHERE status = 0");
                                        $totalpage = ceil($numrow / $item_per_page);
                                        foreach (selectAll("SELECT * FROM sanpham INNER JOIN danhmuc ON sanpham.id_danhmuc = danhmuc.id_dm LIMIT $item_per_page OFFSET $offset") as $row) {
                                        ?>
                                            <tr class="addfont">
                                                <td><?= $stt++ ?></td>
                                                <td>
                                                <span><?= $row['ten'] ?></span>
                                                </td>
                                                <td>
                                                  <?= ($row['danhmuc']) ?>
                                                </td>
                                                <td><?= number_format($row['gia']) ?>đ</td>
                                                <td>
                                                  <img src="../img/product/<?= $row['anh1'] ?>" width="100" alt="">
                                                  <img src="../img/product/<?= $row['anh2'] ?>" width="100" alt="">
                                                  <img src="../img/product/<?= $row['anh3'] ?>" width="100" alt="">
                                                </td>
                                                <td>
                                                  <?php 
                                                    $status = $row['status'];
                                                    if ($status==0) {
                                                      ?>
                                                      <span>Đang Bán</span>
                                                  <?php 
                                                    }else{
                                                      ?>
                                                      <span>Không Kinh Doanh</span>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                                                <td></td>
                                                <td>
                                                <a type="button" class="btn btn-primary btn-icon-text" href="editproduct.php?id=<?= $row['id'] ?>">
                                                <i class="mdi mdi-file-check btn-icon-prepend"></i> Sửa </a>
                                                <?php 
                                                    $status = $row['status'];
                                                    if ($status==0) {
                                                      ?>
                                                      <a type="button" class="btn btn-danger btn-icon-text" style="width: 120px" href="?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có muốn dừng kinh doanh sản phẩm này không?')">
                                                      <i class="mdi mdi-cart-off btn-icon-prepend"></i> Dừng Bán </a>
                                                  <?php 
                                                    }else{
                                                      ?>
                                                      <a type="button" class="btn btn-danger btn-icon-text" style="width: 120px" href="?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có muốn tiếp tục kinh doanh sản phẩm này không?')">
                                                      <i class="mdi mdi-cart-outline btn-icon-prepend"></i> Bán </a>
                                                  <?php
                                                    }
                                                  ?>
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


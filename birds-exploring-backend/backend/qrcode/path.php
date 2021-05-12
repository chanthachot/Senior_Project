<?php

$page = 'path';
include('../header.php');

?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <!-- หัวเรื่องใหญ่ -->
        <div class="col-sm-6">
          <h4 class="m-0">จัดการคิวอาร์โค้ด</h4>
        </div>

        <!-- breadcrumb -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="path.php"><i class="fa fa-map-marked-alt"></i> จัดการเส้นทาง</a></li>
          </ol>
        </div>

      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="col-12">
        <div class="box">
          <div class="box-header">

            <!-- หัวเรื่องย่อย -->
            <h5 class="box-title"><i class="fa fa-map-marked-alt"></i> จัดการเส้นทาง<br><br>

              <!-- ปุ่มเพิ่ม -->
              <button type="summit" class="btn btn-success btn-sm" data-target="#addPathModal" data-toggle="modal">
                <span style="color: white;">
                  <i class='fa fa-plus-circle'></i>
                  เพิ่มเส้นทาง
                </span>
                </a>
              </button>

            </h5>
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <?php include('path_list.php'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

<?php include('../footer.php'); ?>
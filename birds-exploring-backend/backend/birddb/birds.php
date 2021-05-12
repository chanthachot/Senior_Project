<?php

$page = 'birddb';
include('../header.php');

if (!$_REQUEST['bird_family_id']) {
  echo "<script type='text/javascript'>";
  echo "window.location = '../index.php';";
  echo "</script>";
}

?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <!-- หัวเรื่องใหญ่ -->
        <div class="col-sm-6">
          <h4 class="m-0">จัดการฐานข้อมูลนก</h4>
        </div>


        <!-- breadcrumb -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="bird_family.php"><i class="fas fa-dove"></i> จัดการวงศ์นก</a></li>
            <li class="breadcrumb-item"><a><i class="fa fa-crow"></i> จัดการนกในวงศ์ <?= $_REQUEST['bird_family_name'] ?></a></li>
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
            <h5 class="box-title"><i class="fas fa-crow"></i> จัดการนกในวงศ์ <?= $_REQUEST['bird_family_name'] ?><br><br>

              <!-- ปุ่มเพิ่ม -->
              <button type="summit" class="addBirdsModal btn btn-success btn-sm" data-target="#addBirdsModal" data-toggle="modal">
                <span style="color: white;">
                  <i class='fa fa-plus-circle'></i>
                  เพิ่มนกในวงศ์
                </span>
                </a>
              </button>

            </h5>
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <?php include('birds_list.php'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include('../footer.php'); ?>
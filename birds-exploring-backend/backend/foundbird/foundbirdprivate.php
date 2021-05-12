<?php

$page = 'foundbirdprivate';
include('../header.php');

?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <!-- หัวเรื่องใหญ่ -->
        <div class="col-sm-6">
          <h4 class="m-0">จัดการพบนก</h4>
        </div>


        <!-- breadcrumb -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="foundbirdprivate.php"><i class="fas fa-user-lock"></i> จัดการพบนกส่วนตัว</a></li>
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
            <h5 class="box-title"><i class="fas fa-user-lock"></i> จัดการพบนกส่วนตัว<br><br>
            </h5>
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <?php include('foundbirdprivate_list.php'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include('../footer.php'); ?>
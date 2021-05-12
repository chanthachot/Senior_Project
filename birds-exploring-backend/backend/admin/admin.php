<?php

$page = 'admin';
include('../header.php');


?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        
      <?php
      if ($page == "admin" && $_SESSION["typeID"] !== "1") {
        include('admin_permission_denied.php'); 
      }else{
  
        ?>

        <!-- หัวเรื่องใหญ่ -->
        <div class="col-sm-6">
          <h4 class="m-0">จัดการผู้ดูแลระบบ</h4>
        </div>

        <!-- breadcrumb -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="admin.php"><i class="fa fa fa-user-shield"></i> จัดการผู้ดูแลระบบ</a></li>
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
            <h5 class="box-title"><i class="fa fa fa-user-shield"></i> จัดการผู้ดูแลระบบ<br><br>

              <!-- ปุ่มเพิ่ม -->
              <button type="summit" class="btn btn-success btn-sm" data-target="#addAdminModal" data-toggle="modal">
                <span style="color: white;">
                  <i class='fa fa-plus-circle'></i>
                  เพิ่มผู้ดูแลระบบ
              </button>
            </h5>
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <?php 
                include('admin_list.php'); 
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include('../footer.php'); ?>
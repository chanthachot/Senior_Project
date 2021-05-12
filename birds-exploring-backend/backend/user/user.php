<?php

$page = 'user';
include('../header.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <!-- หัวเรื่องใหญ่ -->
                <div class="col-sm-6">
                    <h4 class="m-0">จัดการผู้ใช้งาน</h4>
                </div>


                <!-- breadcrumb -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="user.php"><i class="fa fa fa-users"></i> จัดการผู้ใช้งาน</a></li>
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
                        <h5 class="box-title"><i class="fa fa fa-users"></i> จัดการผู้ใช้งาน<br><br></h5>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <?php include('user_list.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('../footer.php'); ?>
<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/qrcode.php');

$path_id = $_REQUEST['path_id'];
$sql = mysqli_query($con,"SELECT * FROM point WHERE point.path_id = $path_id");


?>

<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr class='info'>
        <th width='5%'>ID</th>
        <th>ชื่อจุด</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th class="text-center" width="15%">รูปคิวอาร์โค้ดล่าสุด</th>
        <!-- <th>ที่อยู่</th> -->
        <th class="text-center">สร้างคิวอาร์โค้ด</th>
        <th width=14% class="text-center">รายละเอียดนกในจุด</th>
        <th width=13% class="text-center">จัดการ</th>

      </tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($sql)) { ?>
      <tr>

        <td><?= $row['point_id'] ?></td>
        <td><?= $row['point_name'] ?></td>
        <td><?= $row['point_lat'] ?></td>
        <td><?= $row['point_lng'] ?></td>
        <!-- <td><?= $row['point_address'] ?></td> -->
        <?php

        $point_id = $row['point_id']; 
        $sql2 = mysqli_query($con,"SELECT * FROM qrcode,point WHERE qrcode.point_id = point.point_id AND point.point_id = $point_id ORDER BY qrcode_id DESC LIMIT 1");
        if (mysqli_num_rows($sql2) > 0){
            while ($row2 = mysqli_fetch_array($sql2)) { 
        ?>

        <td><img src="<?php $workDir ?>/birds-exploring/backend/qrcode/qrcodelib/userQr/<?= $row2['qrcode_image'] ?>" style="width:100%;height:auto;"></td>
        
        <?php }}else{ ?>

          <td class="text-center">ยังไม่มีคิวอาร์โค้ด</td>

        <?php } ?>

        <?php 
          $sql3 = mysqli_query($con,"SELECT * FROM bird,point WHERE bird.point_id = point.point_id AND point.point_id = $point_id");
          if(mysqli_num_rows($sql3) == 0){
        ?>
        
        <td class="text-center">
          <a href="#" class="not_exist">
            <i class='fa fa-qrcode'></i>
            สร้าง
          </a>
        </td>

        <?php 
          }elseif (mysqli_num_rows($sql2) > 0){
        ?>
        <td class="text-center">
          <a href="#" class="duplicate" data-data_point_id=<?= $row['point_id'] ?> data-data_point_name=<?= $row['point_name'] ?> data-data_point_lat=<?= $row['point_lat'] ?> data-data_point_lng=<?= $row['point_lng'] ?>>
            <i class='fa fa-qrcode'></i>
            สร้าง
          </a>
        </td>
      
        <?php }else{ ?>
        <td class="text-center">
          <a href="qrcodelib/index.php?point_id=<?= $row['point_id'] ?>&point_name=<?= $row['point_name'] ?>&point_lat=<?= $row['point_lat'] ?>&point_lng=<?= $row['point_lng'] ?>" target=_blank>
            <i class='fa fa-qrcode'></i>
            สร้าง
          </a>
        </td>
        <?php } ?>

        <td class="text-center">
          <a href="bird.php?path_id=<?= $_REQUEST['path_id'] ?>&path_name=<?= $_REQUEST['path_name'] ?>&point_id=<?= $row['point_id'] ?>&point_name=<?= $row['point_name'] ?>&point_lat=<?= $row['point_lat'] ?>&point_lng=<?= $row['point_lng'] ?>">
            <i class='fa fa-crow'></i>
            จัดการนกในจุด
          </a>
        </td>

        <td class="text-center" div class="red">
          <button type="submit" class="editPointModal btn btn-warning btn-sm" id="btnEditPoint" 
          data-data_edit_point_point_id="<?php echo $row['point_id']; ?>" 
          data-data_edit_point_point_name="<?php echo $row['point_name']; ?>"
          data-data_edit_point_point_lat="<?php echo $row['point_lat']; ?>" 
          data-data_edit_point_point_lng="<?php echo $row['point_lng']; ?>" 
          data-target="#editPointModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-pen'></i>
              แก้ไข
            </span>
            </a>
          </button>

          <button type="summit" class="btn btn-danger btn-sm" id="btnDeletePoint" 
          data-data_delete_point_point_id="<?php echo $row['point_id']; ?>" 
          data-target="#deletePointModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-trash'></i>
              ลบ
            </span>
            </a>
          </button>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>
<br>

<div class="modal fade" id="addPointModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>
          แบบฟอร์มเพิ่มจุด
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addPointForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อจุด</span>
            <input type="text" name="input_add_point_point_name" class="form-control" required>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">ชื่อเส้นทาง</span>
            <input type="hidden" name="input_add_point_path_id" class="form-control" value="<?= $_REQUEST['path_id']; ?>" readonly>
            <input type="text" name="input_add_point_path_name" class="form-control" value="<?= $_REQUEST['path_name']; ?>" readonly>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">ระบุสถานที่</span>
            <hr>
            <div id="pointMap"></div>
          </div>
          <!-- <div class="form-group">
            <span style="font-size:14px;">ที่อยู่</span>
            <input type="text" id="input_add_point_point_address" name="input_add_point_point_address" class="form-control" require>
          </div> -->
          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">Latitude</span>
              <input type="text" id="input_add_point_point_lat" name="input_add_point_point_lat" class="form-control input-md" require>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">Longitude</span>
              <input type="text" id="input_add_point_point_lng" name="input_add_point_point_lng" class="form-control input-md" require>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnConfirmAddPoint" class="btn btn-success"><i class="fa fa-save"></i>
              บันทึกรายการ
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<br>

<div class="modal fade" id="editPointModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
          แบบฟอร์มแก้ไขจุด
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editPointForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อจุด</span>
            <input type="hidden" id="input_edit_point_point_id" name="input_edit_point_point_id" value="">
            <input type="text" id="input_edit_point_point_name" name="input_edit_point_point_name" class="form-control" value="">
          </div>
          <div class="form-group">
            <span style="font-size:14px;">ระบุสถานที่</span>
            <hr>
            <div id="pointMapEdit"></div>
          </div>
          <!-- <div class="form-group">
            <span style="font-size:14px;">ที่อยู่</span>
            <input type="text" id="input_add_point_point_address" name="input_add_point_point_address" class="form-control" require>
          </div> -->
          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">Latitude</span>
              <input type="text" id="input_edit_point_point_lat" name="input_edit_point_point_lat" class="form-control input-md" require>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">Longitude</span>
              <input type="text" id="input_edit_point_point_lng" name="input_edit_point_point_lng" class="form-control input-md" require>
            </div>
          </div>

          <!-- <div class="form-group">
            <span style="font-size:14px;">Latitude</span>
            <input type="text" id="input_edit_point_point_lat" name="input_edit_point_point_lat" class="form-control" value="">
          </div>
          <div class="form-group">
            <span style="font-size:14px;">Longitude</span>
            <input type="text" id="input_edit_point_point_lng" name="input_edit_point_point_lng" class="form-control" value="">
          </div> -->
          <!-- <div class="form-group">
            <span style="font-size:14px;">ที่อยู่</span>
            <input type="text" id="input_edit_point_point_address" name="input_edit_point_point_address" class="form-control" value="">
          </div> -->
          <div class="form-group">
            <span style="font-size:14px;">ชื่อเส้นทาง</span>
            <input type="text" id="input_edit_point_path_name" name="input_edit_point_path_name" class="form-control" value="<?= $_REQUEST['path_name']; ?>" readonly>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">รูปภาพ</span>
            <div class="table-responsive" id="image_qrcode_table">

            </div>
          </div>
          
          <div class="modal-footer">
            <button type="submit" id="btnConfirmEditPoint" class="btn btn-success"><i class="fa fa-save"></i>
              บันทึกรายการ
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deletePointModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลบข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="deletePointForm">
        <div class="modal-body text-center">
          <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></h1>
          <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
          <input type="hidden" id="input_delete_point_point_id" name="input_delete_point_point_id" value="">
        </div>
        <div class="modal-footer">

          <button type="button" id="btnConfirmDeletePoint" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteQRCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteQRCodeForm">
                <div class="modal-body text-center">
                    <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning"
                            aria-hidden="true"></i></h1>
                    <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
                    <input type="hidden" id="input_delete_qrcode_id" name="input_delete_qrcode_id" value="">
                    <input type="hidden" id="input_delete_qrcode_image" name="input_delete_qrcode_image" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnConfirmDeleteQRCode" class="confirmDeleteQRCode btn btn-danger"><i
                            class="fa fa-trash"></i> ลบ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php mysqli_close($con); ?>
<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/qrcode.php');

$sql = "SELECT * FROM path";

$query = mysqli_query($con, $sql);

?>

<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr class='info'>
        <th width='5%'>ID</th>
        <th>ชื่อเส้นทาง</th>
        <th width=17% class="text-center">รายละเอียดจุดในเส้นทาง</th>
        <th width=13% class="text-center">จัดการ</th>

      </tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($query)) { ?>
      <tr>

        <td><?= $row['path_id'] ?></td>
        <td><?= $row['path_name'] ?></td>
        <td class="text-center">
          <a href='point.php?path_id=<?= $row['path_id']; ?>&path_name=<?= $row['path_name'] ?>'>
            <i class='fa fa-map-marker-alt'></i>
            จัดการจุดในเส้นทาง
          </a>
        </td>

        <td class="text-center">

          <button type="summit" class="btn btn-warning btn-sm" id="btnEditPath" data-data_edit_path_path_id="<?php echo $row['path_id']; ?>" data-data_edit_path_path_name="<?php echo $row['path_name']; ?>" data-target="#editPathModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-pen'></i>
              แก้ไข
            </span>
            </a>
          </button>

          <button type="summit" class="btn btn-danger btn-sm" id="btnDeletePath" data-data_delete_path_path_id="<?php echo $row['path_id']; ?>" data-target="#deletePathModal" data-toggle="modal">
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

<div class="modal fade" id="addPathModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>
          แบบฟอร์มเพิ่มเส้นทาง
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addPathForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อเส้นทาง</span>
            <input type="text" name="input_add_path_path_name" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="btnConfirmAddPath" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
    </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editPathModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
          แบบฟอร์มแก้ไขเส้นทาง
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editPathForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อเส้นทาง</span>
            <input type="hidden" name="input_edit_path_path_id" id="input_edit_path_path_id" value="">
            <input type="text" name="input_edit_path_path_name" id="input_edit_path_path_name" class="form-control" value="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmEditPath" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
    </div>
    </form>
  </div>
</div>
</div>

<div class="modal fade" id="deletePathModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลบข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deletePathForm">
        <div class="modal-body text-center">
          <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></h1>
          <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
          <input type="hidden" name="input_delete_path_path_id" id="input_delete_path_path_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmDeletePath" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php mysqli_close($con); ?>
<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/bird.php');

$sql = "SELECT * FROM user";
$query = mysqli_query($con2, $sql);

?>

<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr class='info'>
        <th width='5%'>ID</th>
        <th>ชื่อ</th>
        <th>นามสกุล</th>
        <th>E-mail</th>
        <th width=13% class="text-center">จัดการ</th>
      </tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($query)) { ?>
      <tr>

        <td><?= $row['user_id'] ?></td>
        <td><?= $row['first_name'] ?></td>
        <td><?= $row['last_name'] ?></td>
        <td><?= $row['email'] ?></td>

        <td class="text-center">
          <button type="summit" class="btn btn-warning btn-sm" id="btnEditUser" data-data_edit_user_id="<?php echo $row['user_id']; ?>" data-data_edit_user_firstname="<?php echo $row['first_name']; ?>" data-data_edit_user_lastname="<?php echo $row['last_name']; ?>" data-data_edit_user_email="<?php echo $row['email']; ?>" data-target="#editUserModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-pen'></i>
              แก้ไข
            </span>
            </a>
          </button>

          <button type="summit" class="btn btn-danger btn-sm" id="btnDeleteUser" data-data_delete_user_id="<?php echo $row['user_id']; ?>" data-target="#deleteUserModal" data-toggle="modal">
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

<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
          แบบฟอร์มแก้ไขผู้ใช้งาน
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editUserForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อ</span>
            <input type="hidden" name="input_edit_user_id" id="input_edit_user_id" class="form-control" value="">
            <input type="text" name="input_edit_user_firstname" id="input_edit_user_firstname" class="form-control">
          </div>
          <div class="form-group">
            <span style="font-size:14px;">นามสกุล</span>
            <input type="text" name="input_edit_user_lastname" id="input_edit_user_lastname" class="form-control">
          </div>
          <div class="form-group">
            <span style="font-size:14px;">E-mail</span>
            <input type="text" name="input_edit_user_email" id="input_edit_user_email" class="form-control" readonly>
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmEditUser" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลบข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteUserForm">
        <div class="modal-body text-center">
          <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></h1>
          <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
          <input type="hidden" name="input_delete_user_id" id="input_delete_user_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmDeleteUser" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php mysqli_close($con2); ?>
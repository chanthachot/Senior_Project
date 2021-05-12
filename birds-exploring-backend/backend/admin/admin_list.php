<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/qrcode.php');

$sql = "SELECT * FROM user,user_type WHERE user.type_id = user_type.type_id";
$query = mysqli_query($con, $sql);

$sql2 = "SELECT * FROM user_type";
$query2 = mysqli_query($con, $sql2);

$sql3 = "SELECT * FROM user_type";
$query3 = mysqli_query($con, $sql3);

?>

<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr class='info'>
        <th width='5%'>ID</th>
        <th>ชื่อผู้ใช้</th>
        <th>สถานะ</th>
        <th width=13% class="text-center">จัดการ</th>

      </tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($query)) { ?>
      <tr>

        <td><?= $row['user_id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['type_name'] ?></td>

        <td class="text-center">
          <button type="summit" class="btn btn-warning btn-sm" id="btnEditAdmin" data-data_edit_admin_id="<?php echo $row['user_id']; ?>" data-data_edit_admin_username="<?php echo $row['username']; ?>" data-data_edit_admin_password="<?php echo $row['password']; ?>" data-data_edit_admin_type_id="<?php echo $row['type_id']; ?>" data-data_edit_admin_type_name="<?php echo $row['type_name']; ?>" data-target="#editAdminModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-pen'></i>
              แก้ไข
            </span>
            </a>
          </button>

          <button type="summit" class="btn btn-danger btn-sm" id="btnDeleteAdmin" data-data_delete_admin_id="<?php echo $row['user_id']; ?>" data-target="#deleteAdminModal" data-toggle="modal">
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

<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>
          แบบฟอร์มเพิ่มผู้ดูแลระบบ
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addAdminForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อผู้ใช้</span>
            <input type="text" id="input_add_admin_username" name="input_add_admin_username" class="form-control" required>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">รหัสผ่าน</span>
            <i class="zmdi zmdi-eye"></i>
            <input type="password" id="input_add_admin_password" name="input_add_admin_password" class="form-control" required>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">สถานะ</span>
            <select name="select_add_admin_type_id" id="select_add_admin_type_id" class="form-control" required>
              <option value="" selected disabled>เลือกสถานะ</option>
              <?php while ($row = mysqli_fetch_array($query2)) : ?>
                <option value="<?= $row['type_id'] ?>"><?= $row['type_name'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="btnConfirmAddAdmin" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
    </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
          แบบฟอร์มแก้ไขผู้ดูแลระบบ
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editAdminForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อผู้ใช้</span>
            <input type="hidden" name="input_edit_admin_id" id="input_edit_admin_id" class="form-control" value="">
            <input type="text" name="input_edit_admin_username" id="input_edit_admin_username" class="form-control">
          </div>
          <div class="inputPassword">
            <div class="form-group">
              <span style="font-size:14px;">รหัสผ่าน</span>
              <input type="password" name="input_edit_admin_password" id="input_edit_admin_password" class="form-control">
              <span id="showPassword" class="fa fa-eye-slash"> </span>
            </div>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">สถานะ</span>
            <select name="select_edit_admin_type_id" id="select_edit_admin_type_id" class="form-control select" required>
              <option name="option_edit_admin_type_id" id="option_edit_admin_type_id" disabled selected></option>
              <?php while ($row = mysqli_fetch_array($query3)) : ?>
                <option name="other_option_edit_admin_type_id" id="other_option_edit_admin_type_id" value="<?= $row['type_id'] ?>"><?= $row['type_name'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmEditAdmin" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลบข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteAdminForm">
        <div class="modal-body text-center">
          <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></h1>
          <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
          <input type="hidden" name="input_delete_admin_id" id="input_delete_admin_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmDeleteAdmin" class="btn btn-danger"></i>ลบ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php mysqli_close($con); ?>
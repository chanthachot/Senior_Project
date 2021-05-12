<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/bird.php');

$sql = "SELECT * FROM bird_family";

$query = mysqli_query($con2, $sql);

?>

<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr class='info'>
        <th width='5%'>ID</th>
        <th>ชื่อวงศ์นก</th>
        <th width=17% class="text-center">รูปภาพ</th>
        <th class="text-center">รายละเอียดนกในวงศ์</th>
        <th width=13% class="text-center">จัดการ</th>
      </tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($query)) { ?>
      <tr>

        <td><?= $row['bird_family_id'] ?></td>
        <td><?= $row['bird_family_name'] ?></td>
        <td><img src="<?php $workDir ?>/birds-exploring-backend/backend/birddb/dist/bird_family_img/<?= $row['bird_family_pic'] ?>" style="width:100%;height:auto;"></td>
        <td class="text-center">
          <a href='birds.php?bird_family_id=<?= $row['bird_family_id']; ?>&bird_family_name=<?= $row['bird_family_name'] ?>'>
            <i class='fa fa-crow'></i>
            จัดการนกในวงศ์
          </a>
        </td>

        <td class="text-center">

          <button type="summit" class="btn btn-warning btn-sm" id="btnEditBirdFamily" data-data_edit_bird_family_bird_family_id="<?php echo $row['bird_family_id']; ?>" data-data_edit_bird_family_bird_family_name="<?php echo $row['bird_family_name']; ?>" data-data_edit_bird_family_bird_family_pic="/birds-exploring-backend/backend/birddb/dist/bird_family_img/<?php echo $row['bird_family_pic']; ?>" data-target="#editBirdFamilyModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-pen'></i>
              แก้ไข
            </span>
            </a>
          </button>

          <button type="summit" class="btn btn-danger btn-sm" id="btnDeleteBirdFamily" data-data_delete_bird_family_bird_family_id="<?php echo $row['bird_family_id']; ?>" data-target="#deleteBirdFamilyModal" data-toggle="modal">
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

<div class="modal fade" id="addBirdFamilyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>
          แบบฟอร์มเพิ่มวงศ์นก
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addBirdFamilyForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อวงศ์นก</span>
            <input type="text" name="input_add_bird_family_bird_family_name" class="form-control" required>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">รูปภาพ</span></br>
            <p></p>
            <input type="file" name="input_add_bird_family_bird_family_pic" id="input_add_bird_family_bird_family_pic" onchange="previewAddBirdFamilyImage()"></br>
            <div class="text-muted">ไฟล์ที่อนุญาต .jpg, png, .gif</div>
            <div id="error_msg"></div>
            <p></p>
            <img name="image_add_bird_family" id="image_add_bird_family" style="width: 70%;height: auto;object-fit: cover;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnConfirmAddBirdFamily" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>
<br>

<div class="modal fade" id="editBirdFamilyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
          แบบฟอร์มแก้ไขวงศ์นก
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editBirdFamilyForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อวงศ์นก</span>
            <input type="hidden" name="input_edit_bird_family_bird_family_id" id="input_edit_bird_family_bird_family_id" value="">
            <input type="text" name="input_edit_bird_family_bird_family_name" id="input_edit_bird_family_bird_family_name" class="form-control" value="">
          </div>
          <div class="form-group">
            <span style="font-size:14px;">เปลี่ยนรูป</span></br>
            <p></p>
            <input type="file" name="input_edit_bird_family_bird_family_pic" id="input_edit_bird_family_bird_family_pic" onchange="previewEditBirdFamilyImage()"></br>
            <p></p>
            <img name="image_edit_bird_family" id="image_edit_bird_family" style="width: 70%;height: auto;object-fit: cover;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmEditBirdFamily" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteBirdFamilyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลบข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteBirdFamilyForm">
        <div class="modal-body text-center">
          <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></h1>
          <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
          <input type="hidden" name="input_delete_bird_family_bird_family_id" id="input_delete_bird_family_bird_family_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmDeleteBirdFamily" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php mysqli_close($con2); ?>
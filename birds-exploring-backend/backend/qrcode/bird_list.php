<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/qrcode.php');
include('../connection/bird.php');

$point_id = $_REQUEST['point_id'];
$sql = "SELECT * FROM bird WHERE point_id = $point_id";
$query = mysqli_query($con, $sql);

$sql2 = "SELECT * FROM bird_family";
$query2 = mysqli_query($con2, $sql2);

?>

<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr class='info'>
        <th width='5%'>ID</th>
        <th width="10%">ชื่อนก</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>ชื่อวิทยาศาสตร์</th>
        <th>ลักษณะ</th>
        <th width="15%">รูปภาพ</th>
        <th width="13%" class="text-center">จัดการ</th>
      </tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($query)) { ?>
      <tr>

        <td><?= $row['id'] ?></td>
        <td><?= $row['bird_name'] ?></td>
        <td><?= $row['bird_lat'] ?></td>
        <td><?= $row['bird_lng'] ?></td>
        <td><?= $row['bird_sciname'] ?></td>
        <td><?= $row['bird_description'] ?></td>
        <?php $workDir = $_SERVER['HTTP_HOST']; ?>
        <td><img src="<?php $workDir ?>/birds-exploring/backend/birddb/dist/birds_img/<?= $row['bird_pic'] ?>" style="width:100%;height:auto;"></td>

        <td class="text-center" div class="red">

          <button type="submit" class="btn btn-warning btn-sm" id="btnEditBird" data-data_edit_bird_id="<?php echo $row['bird_id']; ?>" data-data_edit_bird_name="<?php echo $row['bird_name']; ?>" data-data_edit_bird_lat="<?php echo $row['bird_lat']; ?>" data-data_edit_bird_lng="<?php echo $row['bird_lng']; ?>" data-data_edit_bird_sciname="<?php echo $row['bird_sciname']; ?>" data-data_edit_bird_description="<?php echo $row['bird_description']; ?>" data-data_edit_bird_pic="../birddb/dist/birds_img/<?php echo $row['bird_pic'] ?>" data-target="#editBirdModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-pen'></i>
              แก้ไข
            </span>
            </a>
          </button>

          <button type="summit" class="btn btn-danger btn-sm" id="btnDeleteBird" data-data_delete_bird_id="<?php echo $row['bird_id']; ?>" data-target="#deleteBirdModal" data-toggle="modal">
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

<div class="modal fade" id="addBirdModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>
          แบบฟอร์มเพิ่มนก
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addBirdForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อวงศ์นก</span>
            <select name="bird_family_id" id="bird_family_id" class="form-control" onchange="get_bird_family_text(this)" required>
              <option value="" disabled selected>เลือกวงศ์นก</option>
              <?php while ($row = mysqli_fetch_array($query2)) : ?>
                <option value="<?= $row['bird_family_id'] ?>"><?= $row['bird_family_name'] ?></option>
              <?php endwhile; ?>
            </select>
            <input type="hidden" name="bird_family_text" id="bird_family_text">

          </div>

          <div class="form-group">
            <span style="font-size:14px;">ชื่อนก</span>
            <select name="bird_id" id="bird_id" class="form-control" onChange="showBirdDetail(this.value)" required>
              <option value="">เลือกนก</option>
            </select>
          </div>
          
          <div id="bird_sciname" name="bird_sciname"></div>

          <div id="bird_description" name="bird_description"></div>

          <div id="bird_pic" name="bird_pic"></div>

          <div class="form-group">
            <span style="font-size:14px;">ชื่อจุด</span>
            <input type="hidden" name="input_add_bird_point_id" class="form-control" value="<?php echo $_REQUEST['point_id']; ?>" readonly>
            <input type="text" name="input_add_bird_point_name" class="form-control" value="<?php echo $_REQUEST['point_name']; ?>" readonly>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">ระบุตำแหน่งนก</span>
            <hr>
            <div id="birdMap"></div>
          </div>

          <div class="form-group row">

            <div class="col-md-6">
              <span style="font-size:14px;">Latitude</span>
              <input id="input_add_bird_lat" name="input_add_bird_lat" type="text" class="form-control input-md" require>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">Longitude</span>
              <input id="input_add_bird_lng" name="input_add_bird_lng" type="text" class="form-control input-md" require>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnConfirmAddBird" class="btn btn-success"><i class="fa fa-save"></i>
              บันทึกรายการ
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="editBirdModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
          แบบฟอร์มแก้ไขนก
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editBirdForm">
        <div class="modal-body">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อนก</span>
            <input type="hidden" name="input_edit_bird_id" id="input_edit_bird_id" value="">
            <input type="text" name="input_edit_bird_name" id="input_edit_bird_name" class="form-control" value="" readonly>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">ชื่อวิทยาศาสตร์</span>
            <input type="text" name="input_edit_bird_sciname" id="input_edit_bird_sciname" class="form-control" value="" readonly>
          </div>
          <div class="form-group">
            <span style="font-size:14px;">ลักษณะ</span>
            <textarea rows="4" cols="50" style="resize: none;" name="input_edit_bird_description" id="input_edit_bird_description" class="form-control" value="" readonly></textarea>
          </div>

          <div class="form-group">
          <span style="font-size:14px;">รูปภาพ</span></br>
            <img name="image_edit_bird" id="image_edit_bird" style="width: 70%;height: auto;object-fit: cover;">
          </div>

          <div class="form-group">
            <span style="font-size:14px;">ระบุตำแหน่งนก</span>
            <hr>
            <div id="birdMapEdit"></div>
          </div>

          <div class="form-group row">

            <div class="col-md-6">
              <span style="font-size:14px;">Latitude</span>
              <input id="input_edit_bird_lat" name="input_edit_bird_lat" type="text" class="form-control input-md" require>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">Longitude</span>
              <input id="input_edit_bird_lng" name="input_edit_bird_lng" type="text" class="form-control input-md" require>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" id="btnConfirmEditBird" class="btn btn-success"><i class="fa fa-save"></i>
              บันทึกรายการ
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteBirdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลบข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="deleteBirdForm">
        <div class="modal-body text-center">
          <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></h1>
          <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
          <input type="hidden" name="input_delete_bird_id" id="input_delete_bird_id" value="">
        </div>
        <div class="modal-footer">

          <button type="button" id="btnConfirmDeleteBird" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php mysqli_close($con); ?>
<?php mysqli_close($con2); ?>
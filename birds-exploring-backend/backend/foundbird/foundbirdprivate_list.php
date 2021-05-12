<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/bird.php');

$sql = "SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.type = 2 AND foundbird.foundbird_id = foundbird_pic.foundbird_id GROUP BY foundbird.foundbird_id ORDER BY foundbird.foundbird_id DESC";

$query = mysqli_query($con2, $sql);

?>

<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr class='info'>
        <th width='5%'>ID</th>
        <th class="text-center">ชื่อวงศ์นก</th>
        <th class="text-center">ชื่อนก</th>
        <th class="text-center">จำนวนนกที่พบ</th>
        <th class="text-center">วันที่พบนก</th>
        <th class="text-center">เวลาที่พบนก</th>
        <th class="text-center">เวลาที่เพิ่มนก</th>
        <th width='15%' class="text-center">รูปภาพนก</th>
        <th class="text-center">สถานที่พบนก</th>
        <th class="text-center">ชื่อคนพบ</th>
        <th class="text-center">รายละเอียดเพิ่มเติม</th>
        <th width=13% class="text-center">จัดการ</th>
      </tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($query)) { 
      $foundbird_id = $row['foundbird_id'];
      $sql2 = "SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.type = 2 AND foundbird.foundbird_id = foundbird_pic.foundbird_id AND foundbird.foundbird_id = $foundbird_id";
      
      $query2 = mysqli_query($con2, $sql2);
      ?>
      <tr>

        <td><?= $row['foundbird_id'] ?></td>
        <td><?= $row['bird_family_name'] ?></td>
        <td><?= $row['bird_name'] ?></td>
        <td><?= $row['amount'] ?></td>
        <td><?= $row['date'] ?></td>
        <td><?= $row['time'] ?></td>
        <td><?= $row['timestamp'] ?></td>
        <td>
          <div class="slider">
            <?php foreach($query2 as $row2){ ?>
            <div>
              <img src="<?php echo $row2['foundbird_pic_url'];?>" style="width:100%;height:auto;">
            </div>
            <?php } ?>
          </div>
        </td>
        <td><?= $row['place'] ?></td>
        <td>
        <?php 
      
          echo $row['first_name'] . " " . $row['last_name']; 
    
        ?>
        </td>
        <td class="text-center">
          <a href="#ViewFoundBirdPrivateModal" class="ViewFoundBirdPrivateModal"
          data-data_view_foundbirdprivate_foundbird_id="<?php echo $row['foundbird_id']; ?>" 
          data-data_view_foundbirdprivate_bird_family_name="<?php echo $row['bird_family_name']; ?>" 
          data-data_view_foundbirdprivate_bird_name="<?php echo $row['bird_name']; ?>" 
          data-data_view_foundbirdprivate_amount="<?php echo $row['amount']; ?>" 
          data-data_view_foundbirdprivate_lat="<?php echo $row['lat']; ?>" 
          data-data_view_foundbirdprivate_lng="<?php echo $row['lng']; ?>" 
          data-data_view_foundbirdprivate_date="<?php echo $row['date']; ?>"
          data-data_view_foundbirdprivate_time="<?php echo $row['time']; ?>" 
          data-data_view_foundbirdprivate_timestamp="<?php echo $row['timestamp']; ?>" 
          data-data_view_foundbirdprivate_mouth_desc="<?php echo $row['mouth_desc']; ?>" 
          data-data_view_foundbirdprivate_body_desc="<?php echo $row['body_desc']; ?>" 
          data-data_view_foundbirdprivate_tail_desc="<?php echo $row['tail_desc']; ?>" 
          data-data_view_foundbirdprivate_wings_desc="<?php echo $row['wings_desc']; ?>" 
          data-data_view_foundbirdprivate_legs_desc="<?php echo $row['legs_desc']; ?>"
          data-data_view_foundbirdprivate_other_desc="<?php echo $row['other_desc']; ?>" 
          data-data_view_foundbirdprivate_place="<?php echo $row['place']; ?>" 
          data-data_view_foundbirdprivate_first_name="<?php echo $row['first_name']; ?>" 
          data-data_view_foundbirdprivate_last_name="<?php echo $row['last_name']; ?>" 
          data-target="#ViewFoundBirdPrivateModal" data-toggle="modal">
          <i class="fas fa-search"></i>
            ดูรายละเอียดเพิ่มเติม
          </a>
        </td>

        <td class="text-center">
          <button type="summit" class="editFoundBirdPrivateModal btn btn-warning btn-sm" id="btnEditFoundBirdPrivate" 
          data-data_edit_foundbirdprivate_foundbird_id="<?php echo $row['foundbird_id']; ?>" 
          data-data_edit_foundbirdprivate_bird_family_name="<?php echo $row['bird_family_name']; ?>" 
          data-data_edit_foundbirdprivate_bird_name="<?php echo $row['bird_name']; ?>" 
          data-data_edit_foundbirdprivate_amount="<?php echo $row['amount']; ?>" 
          data-data_edit_foundbirdprivate_lat="<?php echo $row['lat']; ?>" 
          data-data_edit_foundbirdprivate_lng="<?php echo $row['lng']; ?>" 
          data-data_edit_foundbirdprivate_date="<?php echo $row['date']; ?>"
          data-data_edit_foundbirdprivate_time="<?php echo $row['time']; ?>" 
          data-data_edit_foundbirdprivate_timestamp="<?php echo $row['timestamp']; ?>" 
          data-data_edit_foundbirdprivate_mouth_desc="<?php echo $row['mouth_desc']; ?>" 
          data-data_edit_foundbirdprivate_body_desc="<?php echo $row['body_desc']; ?>" 
          data-data_edit_foundbirdprivate_tail_desc="<?php echo $row['tail_desc']; ?>" 
          data-data_edit_foundbirdprivate_wings_desc="<?php echo $row['wings_desc']; ?>" 
          data-data_edit_foundbirdprivate_legs_desc="<?php echo $row['legs_desc']; ?>"
          data-data_edit_foundbirdprivate_other_desc="<?php echo $row['other_desc']; ?>" 
          data-data_edit_foundbirdprivate_place="<?php echo $row['place']; ?>" 
          data-data_edit_foundbirdprivate_first_name="<?php echo $row['first_name']; ?>" 
          data-data_edit_foundbirdprivate_last_name="<?php echo $row['last_name']; ?>" 
          data-target="#editFoundBirdPrivateModal" data-toggle="modal">
            <span style="color: white;">
              <i class='fa fa-pen'></i>
              แก้ไข
            </span>
            </a>
          </button>

          <button type="summit" class="deleteFoundBirdPrivateModal btn btn-danger btn-sm" id="btnDeleteFoundBirdPrivate" data-data_delete_foundbirdprivate_foundbird_id="<?php echo $row['foundbird_id']; ?>" data-target="#deleteFoundBirdPrivateModal" data-toggle="modal">
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

<div class="modal fade" id="ViewFoundBirdPrivateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-search"></i>
          แบบฟอร์มพบนกสาธาณะ
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="ViewFoundBirdPrivateForm">
        <div class="modal-body">
          <input type="hidden" name="input_view_foundbirdprivate_foundbird_id" id="input_view_foundbirdprivate_foundbird_id" value="" readonly>
          <div class="form-group">
            <span style="font-size:14px;">ชื่อวงศ์นก</span>
            <input type="text" name="input_view_foundbirdprivate_bird_family_name" id="input_view_foundbirdprivate_bird_family_name" class="form-control" value="" readonly>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">ชื่อนก</span>
            <input type="text" name="input_view_foundbirdprivate_bird_name" id="input_view_foundbirdprivate_bird_name" class="form-control" value="" readonly>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">จำนวนนกที่พบ</span>
            <input type="text" name="input_view_foundbirdprivate_amount" id="input_view_foundbirdprivate_amount" class="form-control" value="" readonly>
          </div>

          
          <div class="form-group">
            <span style="font-size:14px;">สถานที่พบนก</span>
            <input type="text" name="input_view_foundbirdprivate_place" id="input_view_foundbirdprivate_place" class="form-control" value="" readonly>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">สถานที่</span>
            <hr>
            <div id="foundbirdprivate_map_view"></div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">Latitude</span>
              <input type="text" id="input_view_foundbirdprivate_lat" name="input_view_foundbirdprivate_lat" class="form-control input-md" readonly>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">Longitude</span>
              <input type="text" id="input_view_foundbirdprivate_lng" name="input_view_foundbirdprivate_lng" class="form-control input-md" readonly>
            </div>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">วันที่พบนก</span>
            <input type="text" name="input_view_foundbirdprivate_date" id="input_view_foundbirdprivate_date" class="form-control" value="" readonly>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">เวลาที่พบนก</span>
            <input type="text" name="input_view_foundbirdprivate_time" id="input_view_foundbirdprivate_time" class="form-control" value="" readonly>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">เวลาที่เพิ่มนก</span>
            <input type="text" name="input_view_foundbirdprivate_timestamp" id="input_view_foundbirdprivate_timestamp" class="form-control" value="" readonly>
          </div>

          <div class="form-group row">
            <span style="font-size:14px;" class="col-md-12 control-label">ลักษณะ/สี</span>

            <div class="col-md-6">
              <span style="font-size:14px;">ปาก</span>
              <input id="input_view_foundbirdprivate_mouth" name="input_view_foundbirdprivate_mouth" type="text" class="form-control input-md" readonly>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">ตัว</span>
              <input id="input_view_foundbirdprivate_body" name="input_view_foundbirdprivate_body" type="text" class="form-control input-md" readonly>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">หาง</span>
              <input id="input_view_foundbirdprivate_tail" name="input_view_foundbirdprivate_tail" type="text" class="form-control input-md" readonly>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">ปีก</span>
              <input id="input_view_foundbirdprivate_wings" name="input_view_foundbirdprivate_wings" type="text" class="form-control input-md" readonly>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">ขา</span>
              <input id="input_view_foundbirdprivate_legs" name="input_view_foundbirdprivate_legs" type="text" class="form-control input-md" readonly>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">อื่นๆ</span>
              <input id="input_view_foundbirdprivate_other" name="input_view_foundbirdprivate_other" type="text" class="form-control input-md" readonly>
            </div>
          </div>
          <span style="font-size:14px;">รูปภาพ</span></br>
          <div class="table-responsive" id="image_table_view"></div>

          <div class="form-group row">
            <span style="font-size:14px;" class="col-md-12 control-label">ชื่อคนพบ</span>

            <div class="col-md-6">
              <span style="font-size:14px;">ชื่อ</span>
              <input id="input_view_foundbirdprivate_first_name" name="input_view_foundbirdprivate_first_name" type="text" class="form-control input-md" readonly>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">นามสกุล</span>
              <input id="input_view_foundbirdprivate_last_name" name="input_view_foundbirdprivate_last_name" type="text" class="form-control input-md" readonly>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
    </div>
    </form>
  </div>
</div>
</div>

<div class="modal fade" id="editFoundBirdPrivateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
          แบบฟอร์มแก้ไขพบนกสาธาณะ
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editFoundBirdPrivateForm">
        <div class="modal-body">
          <input type="hidden" name="input_edit_foundbirdprivate_foundbird_id" id="input_edit_foundbirdprivate_foundbird_id" value="">
          <div class="form-group">
            <span style="font-size:14px;">ชื่อวงศ์นก</span>
            <input type="text" name="input_edit_foundbirdprivate_bird_family_name" id="input_edit_foundbirdprivate_bird_family_name" class="form-control" value="">
          </div>

          <div class="form-group">
            <span style="font-size:14px;">ชื่อนก</span>
            <input type="text" name="input_edit_foundbirdprivate_bird_name" id="input_edit_foundbirdprivate_bird_name" class="form-control" value="">
          </div>

          <div class="form-group">
            <span style="font-size:14px;">จำนวนนกที่พบ</span>
            <input type="text" name="input_edit_foundbirdprivate_amount" id="input_edit_foundbirdprivate_amount" class="form-control" value="">
          </div>

          <div class="form-group">
            <span style="font-size:14px;">สถานที่พบนก</span>
            <input type="text" name="input_edit_foundbirdprivate_place" id="input_edit_foundbirdprivate_place" class="form-control" value="">
          </div>

          <div class="form-group">
            <span style="font-size:14px;">ระบุสถานที่</span>
            <hr>
            <div id="foundbirdprivate_map_edit"></div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">Latitude</span>
              <input type="text" id="input_edit_foundbirdprivate_lat" name="input_edit_foundbirdprivate_lat" class="form-control input-md">
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">Longitude</span>
              <input type="text" id="input_edit_foundbirdprivate_lng" name="input_edit_foundbirdprivate_lng" class="form-control input-md">
            </div>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">วันที่พบนก</span>
            <input type="text" name="input_edit_foundbirdprivate_date" id="input_edit_foundbirdprivate_date" class="form-control" value="">
          </div>

          <div class="form-group">
            <span style="font-size:14px;">เวลาที่พบนก</span>
            <input type="text" name="input_edit_foundbirdprivate_time" id="input_edit_foundbirdprivate_time" class="form-control" value="">
          </div>

          <div class="form-group">
            <span style="font-size:14px;">เวลาที่เพิ่มนก</span>
            <input type="text" name="input_edit_foundbirdprivate_timestamp" id="input_edit_foundbirdprivate_timestamp" class="form-control" value="" readonly>
          </div>

          <div class="form-group row">
            <span style="font-size:14px;" class="col-md-12 control-label">ลักษณะ/สี</span>

            <div class="col-md-6">
              <span style="font-size:14px;">ปาก</span>
              <input id="input_edit_foundbirdprivate_mouth" name="input_edit_foundbirdprivate_mouth" type="text" class="form-control input-md">
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">ตัว</span>
              <input id="input_edit_foundbirdprivate_body" name="input_edit_foundbirdprivate_body" type="text" class="form-control input-md">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">หาง</span>
              <input id="input_edit_foundbirdprivate_tail" name="input_edit_foundbirdprivate_tail" type="text" class="form-control input-md">
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">ปีก</span>
              <input id="input_edit_foundbirdprivate_wings" name="input_edit_foundbirdprivate_wings" type="text" class="form-control input-md">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <span style="font-size:14px;">ขา</span>
              <input id="input_edit_foundbirdprivate_legs" name="input_edit_foundbirdprivate_legs" type="text" class="form-control input-md">
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">อื่นๆ</span>
              <input id="input_edit_foundbirdprivate_other" name="input_edit_foundbirdprivate_other" type="text" class="form-control input-md">
            </div>
          </div>

          <div class="form-group">
            <span style="font-size:14px;">เพิ่มรูปภาพ</span></br>
            <p></p>

            <div class="row">
              <div class="col-md-12">
                <button type="button" class="imgbuts4 btn btn-success">เลือกรูป</button></br>
                <div class="text-muted">ไฟล์ที่อนุญาต .jpg, png, .gif</div>
                <div id="error_msg4"></div>

                <div class="ui-block">
                  <aside class="suggested-posts">
                    <div class="suggested-posts-container">
                      <div class="row" id="message_box4"></div>
                    </div>
                  </aside>
                </div>
              </div>
            </div>
            <p></p>
            <span style="font-size:14px;">รูปภาพ</span></br>
            <div class="table-responsive" id="image_table_edit"></div>
          </div>

          <div class="form-group row">
            <span style="font-size:14px;" class="col-md-12 control-label">ชื่อคนพบ</span>

            <div class="col-md-6">
              <span style="font-size:14px;">ชื่อ</span>
              <input id="input_edit_foundbirdprivate_first_name" name="input_edit_foundbirdprivate_first_name" type="text" class="form-control input-md" readonly>
            </div>

            <div class="col-md-6">
              <span style="font-size:14px;">นามสกุล</span>
              <input id="input_edit_foundbirdprivate_last_name" name="input_edit_foundbirdprivate_last_name" type="text" class="form-control input-md" readonly>
            </div>
          </div>

      
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmEditFoundBirdPrivate" class="btn btn-success"><i class="fa fa-save"></i>
            บันทึกรายการ
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
    </div>
    </form>
  </div>
</div>
</div>

<div class="modal fade" id="deleteFoundBirdPrivateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลบข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteFoundBirdPrivateForm">
        <div class="modal-body text-center">
          <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></h1>
          <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
          <input type="hidden" name="input_delete_foundbirdprivate_foundbird_id" id="input_delete_foundbirdprivate_foundbird_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmDeleteFoundBirdPrivate" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteFoundBirdPicPrivateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteFoundBirdPicPrivateForm">
                <div class="modal-body text-center">
                    <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning"
                            aria-hidden="true"></i></h1>
                    <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
                    <input type="hidden" id="input_delete_foundbirdprivate_foundbird_pic_id" name="input_delete_foundbirdprivate_foundbird_pic_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnConfirmDeleteFoundBirdPicPrivate" class="confirmDeleteFoundBirdPicPrivate btn btn-danger"><i
                            class="fa fa-trash"></i> ลบ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php mysqli_close($con2); ?>
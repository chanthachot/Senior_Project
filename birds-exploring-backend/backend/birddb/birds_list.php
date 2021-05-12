<?php
error_reporting(error_reporting() & ~E_NOTICE);

include('../connection/bird.php');

$bird_family_id = $_REQUEST['bird_family_id'];
// SELECT * FROM bird_family INNER JOIN bird_family_pic ON bird_family.bird_family_id = bird_family_pic.bird_family_id WHERE bird_family.bird_family_id = 1
$sql = "SELECT * FROM birds,bird_pic WHERE birds.bird_id = bird_pic.bird_id AND birds.bird_family_id = $bird_family_id GROUP BY bird_name";

$query = mysqli_query($con2, $sql);

?>

<div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr class='info'>
                <th>ID</th>
                <th width='9%'>ชื่อนก</th>
                <th>ชื่อสามัญ</th>
                <th width='12%'>ชื่อวิทยาศาสตร์</th>
                <th width='25%'>ลักษณะ</th>
                <th>ถิ่นที่อยู่</th>
                <th width='17%'>รูปภาพ</th>
                <th width='12%' class="text-center">จัดการ</th>
            </tr>
        </thead>

        <?php
    while ($row = mysqli_fetch_array($query)) { 

    $bird_id = $row['bird_id'];
    $sql2 = "SELECT * from birds,bird_pic WHERE birds.bird_id = bird_pic.bird_id AND birds.bird_id = $bird_id";

    $query2 = mysqli_query($con2, $sql2);
    ?>
        <tr>
            <td><?= $row['bird_id'] ?></td>
            <td><?= $row['bird_name'] ?></td>
            <td><?= $row['bird_commonname'] ?></td>
            <td><?= $row['bird_sciname'] ?></td>
            <td><?= $row['bird_description'] ?></td>
            <td><?= $row['bird_habitat'] ?></td>
            <td>
              <div class="slider">
                <?php foreach($query2 as $row2){ ?>
                <div>
                  <img src="<?php $workDir ?>/birds-exploring/backend/birddb/dist/birds_img/<?= $row2['bird_pic_name'] ?>" style="width:100%;height:auto;">
                </div>
                <?php } ?>
              </div>
            </td>
            <td class="text-center" div class="red">
                <button type="submit" class="editBirdsModal btn btn-warning btn-sm" id="btnEditBirds"
                    data-data_edit_bird_bird_id="<?php echo $row['bird_id']; ?>"
                    data-data_edit_bird_bird_name="<?php echo $row['bird_name']; ?>"
                    data-data_edit_bird_bird_commonname="<?php echo $row['bird_commonname']; ?>"
                    data-data_edit_bird_bird_sciname="<?php echo $row['bird_sciname']; ?>"
                    data-data_edit_bird_bird_description="<?php echo $row['bird_description']; ?>"
                    data-data_edit_bird_bird_habitat="<?php echo $row['bird_habitat']; ?>" data-target="#editBirdsModal"
                    data-toggle="modal">
                    <span style="color: white;">
                        <i class='fa fa-pen'></i>
                        แก้ไข
                    </span>
                    </a>
                </button>


                <button type="summit" class="deleteBirdModal btn btn-danger btn-sm" id="btnDeleteBirds"
                    data-data_delete_bird_bird_id="<?php echo $row['bird_id']; ?>" data-target="#deleteBirdModal"
                    data-toggle="modal">
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
</br>


<div class="modal fade" id="addBirdsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>
                    แบบฟอร์มเพิ่มนกในวงศ์
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addBirdForm">
                <div class="modal-body">
                    <div class="form-group">
                        <span style="font-size:14px;">ชื่อนก</span>
                        <input type="text" name="input_add_bird_bird_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <span style="font-size:14px;">ชื่อสามัญ</span>
                        <input type="text" name="input_add_bird_bird_commonname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <span style="font-size:14px;">ชื่อวิทยาศาสตร์</span>
                        <input type="text" name="input_add_bird_bird_sciname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <span style="font-size:14px;">ลักษณะ</span>
                        <textarea style="resize:none" rows="4" cols="50" type="text"
                            name="input_add_bird_bird_description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <span style="font-size:14px;">ถิ่นที่อยู่</span>
                        <input type="text" name="input_add_bird_bird_habitat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <span style="font-size:14px;">รูปภาพ</span></br>
                        <p></p>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="imgbuts btn btn-success">เลือกรูป</button></br>
                                <div class="text-muted">ไฟล์ที่อนุญาต .jpg, png, .gif</div>
                                <div id="error_msg"></div>

                                <div class="ui-block">
                                    <aside class="suggested-posts">
                                        <div class="suggested-posts-container">
                                            <div class="row" id="message_box"></div>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnConfirmAddBird" class="btnConfirmAddBird btn btn-success"><i
                            class="fa fa-save"></i>
                        บันทึกรายการ
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBirdsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pen"></i>
                    แบบฟอร์มแก้ไขนกในวงศ์
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBirdForm">
                <div class="modal-body">
                  <div class="form-group">
                      <span style="font-size:14px;">ชื่อนก</span>
                      <input type="hidden" id="input_edit_bird_bird_id" name="input_edit_bird_bird_id" value="">
                      <input type="text" id="input_edit_bird_bird_name" name="input_edit_bird_bird_name"
                          class="form-control" value="">
                  </div>
                  <div class="form-group">
                      <span style="font-size:14px;">ชื่อสามัญ</span>
                      <input type="text" id="input_edit_bird_bird_commonname" name="input_edit_bird_bird_commonname"
                          class="form-control" value="">
                  </div>
                  <div class="form-group">
                      <span style="font-size:14px;">ชื่อวิทยาศาสตร์</span>
                      <input type="text" id="input_edit_bird_bird_sciname" name="input_edit_bird_bird_sciname"
                          class="form-control" value="">
                  </div>
                  <div class="form-group">
                      <span style="font-size:14px;">ลักษณะ</span>
                      <textarea style="resize:none" rows="4" cols="50" type="text"
                          id="input_edit_bird_bird_description" name="input_edit_bird_bird_description"
                          class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                      <span style="font-size:14px;">ถิ่นที่อยู่</span>
                      <input type="text" id="input_edit_bird_bird_habitat" name="input_edit_bird_bird_habitat"
                          class="form-control" value="">
                  </div>

                  <div class="form-group">
                    <span style="font-size:14px;">เพิ่มรูปภาพ</span>
                    <p></p>

                    <div class="row">
                      <div class="col-md-12">
                        <button type="button" class="imgbuts2 btn btn-success">เลือกรูป</button></br>
                        <div class="text-muted">ไฟล์ที่อนุญาต .jpg, png, .gif</div>
                        <div id="error_msg2"></div>

                        <div class="ui-block">
                          <aside class="suggested-posts">
                            <div class="suggested-posts-container">
                              <div class="row" id="message_box2"></div>
                            </div>
                          </aside>
                        </div>
                      </div>
                    </div>
                    <p></p>
                    <span style="font-size:14px;">รูปภาพ</span>
                    <div class="table-responsive" id="image_table">

                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnConfirmEditBird" class="btnConfirmEditBird btn btn-success"><i
                            class="fa fa-save"></i>
                        บันทึกรายการ
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
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
                    <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning"
                            aria-hidden="true"></i></h1>
                    <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
                    <input type="hidden" id="input_delete_bird_bird_id" name="input_delete_bird_bird_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnConfirmDeleteBird" class="btnConfirmDeleteBird btn btn-danger"><i
                            class="fa fa-trash"></i> ลบ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteBirdPicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteBirdPicForm">
                <div class="modal-body text-center">
                    <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-warning"
                            aria-hidden="true"></i></h1>
                    <p>คุณแน่ใจหรือว่าต้องการลบรายการนี้ ?</p>
                    <input type="hidden" id="input_delete_bird_pic_id" name="input_delete_bird_pic_id" value="">
                    <input type="hidden" id="input_delete_bird_pic_name" name="input_delete_bird_pic_name" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnConfirmDeleteBirdPic" class="confirmDeleteBirdPic btn btn-danger"><i
                            class="fa fa-trash"></i> ลบ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php mysqli_close($con2); ?>
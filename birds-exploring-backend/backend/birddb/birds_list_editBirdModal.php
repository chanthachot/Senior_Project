<!-- <?php
include('../connection/bird.php');

$bird_id = mysqli_real_escape_string($con2, $_GET['bird_id']);

$query = mysqli_query($con2, "SELECT * from birds,bird_pic WHERE birds.bird_id = bird_pic.bird_id AND birds.bird_id = $bird_id") or die(mysql_error($con2)); 
$row = mysqli_fetch_assoc($query);
?>

<div class="form-group">
  <span style="font-size:14px;">ชื่อนก</span>
  <input type="hidden" id="input_edit_bird_bird_id" name="input_edit_bird_bird_id" value="<?php echo $row["bird_id"]?>"">
  <input type="text" id="input_edit_bird_bird_name" name="input_edit_bird_bird_name" class="form-control"
      value="<?php echo $row["bird_name"]?>">
</div>
<div class="form-group">
  <span style="font-size:14px;">ชื่อสามัญ</span>
  <input type="text" id="input_edit_bird_bird_commonname" name="input_edit_bird_bird_commonname"
      class="form-control" value="<?php echo $row["bird_commonname"]?>"">
</div>
<div class="form-group">
  <span style="font-size:14px;">ชื่อวิทยาศาสตร์</span>
  <input type="text" id="input_edit_bird_bird_sciname" name="input_edit_bird_bird_sciname"
      class="form-control" value="<?php echo $row["bird_sciname"]?>"">
</div>
<div class="form-group">
  <span style="font-size:14px;">ลักษณะ</span>
  <textarea style="resize:none" rows="4" cols="50" type="text" id="input_edit_bird_bird_description"
      name="input_edit_bird_bird_description" class="form-control"><?php echo $row["bird_description"]?></textarea>
</div>
<div class="form-group">
  <span style="font-size:14px;">ถิ่นที่อยู่</span>
  <input type="text" id="input_edit_bird_bird_habitat" name="input_edit_bird_bird_habitat"
      class="form-control" value="<?php echo $row["bird_habitat"]?>"">
</div>
<div class="form-group">
  <span style="font-size:14px;">เพิ่มรูป</span></br>
  <p></p>
  <input type="file" name="multiple_files" id="multiple_files" multiple />
  <span id="error_multiple_files"></span>

  
  <div class="table-responsive" id="image_table">
    
  </div>
</div> -->
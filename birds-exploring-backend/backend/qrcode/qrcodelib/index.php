<?php
include('header.php');

?>

<body>
  <?php
  error_reporting(error_reporting() & ~E_NOTICE);

  include('meRaviQr/qrlib.php');
  include('../../connection/qrcode.php');

  $point_id = $_REQUEST['point_id'];
  $point_name = $_REQUEST['point_name'];
  $point_lat = $_REQUEST['point_lat'];
  $point_lng = $_REQUEST['point_lng'];

  $sql = "SELECT * FROM bird WHERE point_id = $point_id";
  $query = mysqli_query($con, $sql);

  $act = $_GET['act'];
  if ($act == 'success') {
    include('success.php');
  } else {
    include('create_qrcode.php');
  ?>
    <div id="qrcodeModal" class="modal">
      <form id="createQRCodeForm" class="modal-content animate" method="POST" enctype="multipart/form-data">
        <div class="container">
          <h2 align="center">สร้างคิวอาร์โค้ดจุด <?php echo $point_name ?></h2>
          <label for="uname"><b>ชื่อจุด</b></label>
          <input type="hidden" name="input_point_id" id="input_point_id" value="<?php echo $point_id; ?>" readonly>
          <input type="text" value="<?php echo $point_name; ?>" readonly>

          <label for="psw"><b> Latitude</b></label>
          <input type="text" value="<?php echo $point_lat; ?>" readonly>

          <label for="psw"><b> Longitude</b></label>
          <input type="text" value="<?php echo $point_lng; ?>" readonly>
          <hr>
          <label for="psw"><b> นกที่อยู่ในจุด <?php echo $point_name; ?></b></label>
          <?php while ($row = mysqli_fetch_array($query)) { ?>
            <label>
            
              <br><br>ชื่อนก<input type="text" name="input_qrcode_bird_name" id="input_qrcode_bird_name" value="<?= $row["bird_name"] ?>" readonly />
              <br>Latitude<input type="text" name="input_qrcode_bird_lat" id="input_qrcode_bird_lat" value="<?= $row["bird_lat"] ?>" readonly />
              <br>Longitude<input type="text" name="input_qrcode_bird_lng" id="input_qrcode_bird_lng" value="<?= $row["bird_lng"] ?>" readonly />
              <br>ชื่อวิทยาศาสตร์<input type="text" name="input_qrcode_bird_sciname" id="input_qrcode_bird_sciname" value="<?= $row["bird_sciname"] ?>" readonly />
              <br>ลักษณะ<br><textarea rows="4" cols="50" style="resize: none;" name="input_qrcode_bird_description" id="input_qrcode_bird_description" readonly><?= $row["bird_description"] ?></textarea>
              <br>รูปภาพ<br><img name="input_qrcode_bird_pic" id="input_qrcode_bird_pic" src="<?php $workDir ?>../../birddb/dist/birds_img/<?= $row["bird_pic"] ?>" style="width: 100%;height: auto;object-fit: cover;" readonly />
            </label>
          <?php } ?>
          <input type="submit" value="สร้าง" id="btnCreateQRCode" name="btnCreateQRCode">
        </div>
      </form>
    </div>
  <?php
  }
  ?>

</body>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>

</html>
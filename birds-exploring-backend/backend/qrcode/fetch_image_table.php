<?php
include('../connection/qrcode.php');

$point_id = mysqli_real_escape_string($con, $_GET['point_id']);

$query = mysqli_query($con, "SELECT * FROM qrcode,point WHERE qrcode.point_id = point.point_id AND point.point_id = $point_id") or die(mysql_error($con2)); 
$row = mysqli_fetch_assoc($query);

?>

<table id="editQRCodeTable" class="table table-bordered table-striped">
    <thead>
    <tr class='info'>
        <th width='10%'>ID</th>
        <th width='10%'>รูป</th>
        <th width='10%'>วัน/เวลาที่สร้าง</th>
        <th width='5%' class="text-center">จัดการ</th>
    </tr>
    </thead>
    <?php 
    foreach($query as $row2){
    ?>
    <tr>
        <td><?php echo $row2['qrcode_id']; ?></td>
        <td class="text-center"><img src="/birds-exploring/backend/qrcode/qrcodelib/userQr/<?php echo $row2['qrcode_image']; ?>" name="image_edit_birds" id="image_edit_birds" style="width: 70%;height: auto;object-fit: cover;"></td>
        <td><?php echo $row2['qrcode_timestamp']; ?></td>
        <td class="text-center" div class="red">
        <button type="button" class="deleteQRCodeModal btn btn-danger btn-sm" id="<?= $row2['qrcode_id']?>" 
        data-data_qrcode_image="<?php echo $row2['qrcode_image']; ?>" data-target="#deleteQRCodeModal" data-toggle="modal">
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
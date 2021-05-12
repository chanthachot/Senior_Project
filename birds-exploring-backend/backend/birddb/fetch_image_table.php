<?php
include('../connection/bird.php');

$bird_id = mysqli_real_escape_string($con2, $_GET['bird_id']);

$query = mysqli_query($con2, "SELECT * from birds,bird_pic WHERE birds.bird_id = bird_pic.bird_id AND birds.bird_id = $bird_id") or die(mysql_error($con2)); 
$row = mysqli_fetch_assoc($query);

$rowcount = mysqli_num_rows($query);
?>

<table id="editBirdPicTable" class="table table-bordered table-striped">
    <thead>
    <tr class='info'>
        <th width='10%'>ชื่อ</th>
        <th width='10%'>รูป</th>
        <th width='5%' class="text-center">จัดการ</th>
    </tr>
    </thead>
    <?php 
    foreach($query as $row2){
    ?>
    <tr>
        <td><?php echo $row2['bird_pic_name']; ?></td>
        <td class="text-center"><img src="/birds-exploring/backend/birddb/dist/birds_img/<?php echo $row2['bird_pic_name']; ?>" name="image_edit_birds" id="image_edit_birds" style="width: 70%;height: auto;object-fit: cover;"></td>
        <td class="text-center" div class="red">
        
        <?php if($rowcount <= 1){ ?>
        <button type="button" class="oneDataTable btn btn-danger btn-sm" id="<?= $row2['bird_pic_id']?>" 
        data-data_bird_pic_name="<?php echo $row2['bird_pic_name']; ?>">
            <span style="color: white;">
            <i class='fa fa-trash'></i>
            ลบ
            </span>
            </a>
        </button>
        
        <?php }else{ ?>

        <button type="button" class="deleteBirdPicModal btn btn-danger btn-sm" id="<?= $row2['bird_pic_id']?>" 
        data-data_bird_pic_name="<?php echo $row2['bird_pic_name']; ?>" data-target="#deleteBirdPicModal" data-toggle="modal">
            <span style="color: white;">
            <i class='fa fa-trash'></i>
            ลบ
            </span>
            </a>
        </button>

        <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
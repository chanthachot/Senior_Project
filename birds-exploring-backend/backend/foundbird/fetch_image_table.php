<?php include('../connection/bird.php'); 

$act = mysqli_real_escape_string($con2, $_REQUEST['act']);

?>

<!-- view_foundbird_public -->
<?php 

if($act == 'view_foundbird_public'){ 

$foundbirdpublic_foundbird_id = mysqli_real_escape_string($con2, $_GET['foundbirdpublic_foundbird_id']);
$query = mysqli_query($con2, "SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.type = 1 AND foundbird.foundbird_id = foundbird_pic.foundbird_id AND foundbird.foundbird_id = $foundbirdpublic_foundbird_id") or die(mysql_error($con2)); 
$row = mysqli_fetch_assoc($query);
?>

<table id="editFoundBirdPicTable" class="table table-bordered table-striped">
    <thead>
    <tr class='info'>
        <th width='20%'>รูป</th>
    </tr>
    </thead>
    <?php 
    foreach($query as $row2){
    ?>
    <tr>
        <td class="text-center"><img src="<?php echo $row2['foundbird_pic_url'];?>" name="image_edit_birds" id="image_edit_birds" style="width: 30%;height: auto;object-fit: cover;"></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>


<!-- edit_foundbird_public -->
<?php 

if($act == 'edit_foundbird_public'){ 

$foundbirdpublic_foundbird_id = mysqli_real_escape_string($con2, $_GET['foundbirdpublic_foundbird_id']);
$query = mysqli_query($con2, "SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.type = 1 AND foundbird.foundbird_id = foundbird_pic.foundbird_id AND foundbird.foundbird_id = $foundbirdpublic_foundbird_id") or die(mysql_error($con2)); 
$row = mysqli_fetch_assoc($query);

$rowcount = mysqli_num_rows($query);
?>

<table id="editFoundBirdPicTable" class="table table-bordered table-striped">
    <thead>
    <tr class='info'>
        <th width='20%'>รูป</th>
        <th width='5%' class="text-center">จัดการ</th>
    </tr>
    </thead>
    <?php 
    foreach($query as $row2){
    ?>
    <tr>
        <td class="text-center"><img src="<?php echo $row2['foundbird_pic_url'];?>" name="image_edit_birds" id="image_edit_birds" style="width: 30%;height: auto;object-fit: cover;"></td>
        <td class="text-center" div class="red">
        
        <?php if($rowcount <= 1){ ?>
        <button type="button" class="oneDataTable btn btn-danger btn-sm" id="<?php echo $row2['foundbird_pic_id'];?>">
            <span style="color: white;">
            <i class='fa fa-trash'></i>
            ลบ
            </span>
            </a>
        </button>
        
        <?php }else{ ?>

        <button type="button" class="deleteFoundBirdPicPublicModal btn btn-danger btn-sm" id="<?php echo $row2['foundbird_pic_id'];?>" data-target="#deleteFoundBirdPicPublicModal" data-toggle="modal">
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
<?php } ?>

<!-- view_foundbird_private -->
<?php 

if($act == 'view_foundbird_private'){ 

$foundbirdprivate_foundbird_id = mysqli_real_escape_string($con2, $_GET['foundbirdprivate_foundbird_id']);
$query = mysqli_query($con2, "SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.type = 2 AND foundbird.foundbird_id = foundbird_pic.foundbird_id AND foundbird.foundbird_id = $foundbirdprivate_foundbird_id") or die(mysql_error($con2)); 
$row = mysqli_fetch_assoc($query);
?>

<table id="editFoundBirdPicTable" class="table table-bordered table-striped">
    <thead>
    <tr class='info'>
        <th width='20%'>รูป</th>
    </tr>
    </thead>
    <?php 
    foreach($query as $row2){
    ?>
    <tr>
        <td class="text-center"><img src="<?php echo $row2['foundbird_pic_url'];?>" name="image_edit_birds" id="image_edit_birds" style="width: 30%;height: auto;object-fit: cover;"></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>


<!-- edit_foundbird_private -->
<?php 

if($act == 'edit_foundbird_private'){ 

$foundbirdprivate_foundbird_id = mysqli_real_escape_string($con2, $_GET['foundbirdprivate_foundbird_id']);
$query = mysqli_query($con2, "SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.type = 2 AND foundbird.foundbird_id = foundbird_pic.foundbird_id AND foundbird.foundbird_id = $foundbirdprivate_foundbird_id") or die(mysql_error($con2)); 
$row = mysqli_fetch_assoc($query);

$rowcount = mysqli_num_rows($query);
?>

<table id="editFoundBirdPicTable" class="table table-bordered table-striped">
    <thead>
    <tr class='info'>
        <th width='20%'>รูป</th>
        <th width='5%' class="text-center">จัดการ</th>
    </tr>
    </thead>
    <?php 
    foreach($query as $row2){
    ?>
    <tr>
        <td class="text-center"><img src="<?php echo $row2['foundbird_pic_url'];?>" name="image_edit_birds" id="image_edit_birds" style="width: 30%;height: auto;object-fit: cover;"></td>
        <td class="text-center" div class="red">
        
        <?php if($rowcount <= 1){ ?>
        <button type="button" class="oneDataTable btn btn-danger btn-sm" id="<?php echo $row2['foundbird_pic_id'];?>">
            <span style="color: white;">
            <i class='fa fa-trash'></i>
            ลบ
            </span>
            </a>
        </button>
        
        <?php }else{ ?>

        <button type="button" class="deleteFoundBirdPicPrivateModal btn btn-danger btn-sm" id="<?php echo $row2['foundbird_pic_id'];?>" data-target="#deleteFoundBirdPicPrivateModal" data-toggle="modal">
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
<?php } ?>




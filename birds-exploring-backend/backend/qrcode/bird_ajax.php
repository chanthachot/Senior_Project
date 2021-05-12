<?php
include('../connection/bird.php');
$bird_id = $_GET['bird_id'];

$query = "SELECT * FROM birds , bird_pic WHERE birds.bird_id = bird_pic.bird_id AND birds.bird_id = $bird_id GROUP BY birds.bird_id";
$result = mysqli_query($con2, $query);


while ($row = mysqli_fetch_assoc($result)) {

?>
    <div class="form-group">
        <span style="font-size:14px;">ชื่อวิทยาศาสตร์</span>
        <input type="text" class="form-control" value="<?= $row['bird_sciname'] ?>" readonly>
    </div>

    <div class="form-group">
        <span style="font-size:14px;">คำอธิบาย</span>
        <textarea style="padding-left: 10px;resize:none" class="form-control" rows="4" cols="50" readonly><?= $row['bird_description'] ?></textarea>
    </div>

    <div class="form-group">
        <span style="font-size:14px;">รูปภาพ</span> </br>
        <img src="../birddb/dist/birds_img/<?= $row['bird_pic_name'] ?>" style="width: 70%;height: auto;object-fit: cover;" />
    </div>


<?php
}

mysqli_close($con2);
?>
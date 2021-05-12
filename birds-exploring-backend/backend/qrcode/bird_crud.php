<?php
include('../connection/qrcode.php');
include('../connection/bird.php');

$act = mysqli_real_escape_string($con, $_REQUEST['act']);

if ($act == 'add') {
    $bird_id = mysqli_real_escape_string($con2, $_REQUEST['bird_id']);

    $sql = "SELECT * FROM birds , bird_pic WHERE birds.bird_id = bird_pic.bird_id AND birds.bird_id = $bird_id GROUP BY birds.bird_id";
    $query = mysqli_query($con2, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        $bird_id = mysqli_real_escape_string($con2, $row['bird_id']);
        $bird_name = mysqli_real_escape_string($con2, $row['bird_name']);
        $input_add_bird_lat = mysqli_real_escape_string($con, $_REQUEST['input_add_bird_lat']);
        $input_add_bird_lng = mysqli_real_escape_string($con, $_REQUEST['input_add_bird_lng']);
        $bird_sciname = mysqli_real_escape_string($con2, $row['bird_sciname']);
        $bird_description = mysqli_real_escape_string($con2, $row['bird_description']);
        $bird_pic_name = mysqli_real_escape_string($con2, $row['bird_pic_name']);
        $bird_family_text = mysqli_real_escape_string($con, $_REQUEST['bird_family_text']);
        $input_add_bird_point_id = mysqli_real_escape_string($con, $_REQUEST['input_add_bird_point_id']);

        mysqli_query($con, "INSERT INTO bird(bird_id, bird_name,bird_family_name,bird_lat,bird_lng,bird_sciname,bird_description,bird_pic,point_id) 
        VALUES ('$bird_id','$bird_name','$bird_family_text','$input_add_bird_lat','$input_add_bird_lng','$bird_sciname','$bird_description','$bird_pic_name'
        ,'$input_add_bird_point_id')");
    }
    mysqli_close($con);
    mysqli_close($con2);
}

if ($act == 'update') {
    $input_edit_bird_id = mysqli_real_escape_string($con, $_REQUEST['input_edit_bird_id']);
    $input_edit_bird_lat = mysqli_real_escape_string($con, $_REQUEST['input_edit_bird_lat']);
    $input_edit_bird_lng = mysqli_real_escape_string($con, $_REQUEST['input_edit_bird_lng']);

    mysqli_query($con, "UPDATE bird SET bird_lat = '$input_edit_bird_lat', bird_lng = '$input_edit_bird_lng' WHERE bird_id = '$input_edit_bird_id' ");  
    
    mysqli_close($con);
}

if ($act == 'delete') {
    $input_delete_bird_id = mysqli_real_escape_string($con, $_REQUEST['input_delete_bird_id']);

    mysqli_query($con, "DELETE FROM bird WHERE bird_id = '{$input_delete_bird_id}'");

    mysqli_close($con);
}
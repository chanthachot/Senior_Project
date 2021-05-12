<?php
include('../connection/bird.php');

$act = mysqli_real_escape_string($con2, $_REQUEST['act']);

if ($act == 'add') {
    $input_add_bird_family_bird_family_name = mysqli_real_escape_string($con2, $_REQUEST['input_add_bird_family_bird_family_name']);

    $image_name = $_FILES['input_add_bird_family_bird_family_pic']['name'];
    $image_tmp = $_FILES['input_add_bird_family_bird_family_pic']['tmp_name'];

    $file_name = explode(".", $image_name);
    $allowed_ext = array("jpg", "jpeg", "png", "gif");

    $new_name = time() . rand() . '.' . $file_name[1];
    $sourcePath = $image_tmp;
    $targetPath = "../birddb/dist/bird_family_img/".$new_name;  

    $move_uploaded_file = move_uploaded_file($sourcePath, $targetPath);

    if($move_uploaded_file){
        mysqli_query($con2,"INSERT INTO bird_family(bird_family_name,bird_family_pic) VALUES('$input_add_bird_family_bird_family_name','$new_name')");
    }

    mysqli_close($con2);
}

if ($act == 'update') {
    $input_edit_bird_family_bird_family_id = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_family_bird_family_id']);
    $input_edit_bird_family_bird_family_name = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_family_bird_family_name']);

    $image_name = $_FILES['input_edit_bird_family_bird_family_pic']['name'];
    $image_tmp = $_FILES['input_edit_bird_family_bird_family_pic']['tmp_name'];
    
    if(!empty($image_name)){ 
        $file_name = explode(".", $image_name);
        $allowed_ext = array("jpg", "jpeg", "png", "gif");

        $new_name = time() . rand() . '.' . $file_name[1];
        $sourcePath = $image_tmp;
        $targetPath = "../birddb/dist/bird_family_img/".$new_name;  

        $move_uploaded_file = move_uploaded_file($sourcePath, $targetPath);

        if($move_uploaded_file){
            mysqli_query($con2,"UPDATE bird_family SET bird_family_name = '$input_edit_bird_family_bird_family_name' , bird_family_pic = '$new_name' WHERE bird_family_id = '$input_edit_bird_family_bird_family_id' ");
        }
    } else {
        mysqli_query($con2,"UPDATE bird_family SET bird_family_name = '$input_edit_bird_family_bird_family_name' WHERE bird_family_id = '$input_edit_bird_family_bird_family_id' ");
    }
    mysqli_close($con2);
}

if ($act == 'delete') {
    $input_delete_bird_family_bird_family_id = mysqli_real_escape_string($con2, $_REQUEST['input_delete_bird_family_bird_family_id']);

    mysqli_query($con2,"DELETE bird_family, birds from bird_family LEFT join birds on bird_family.bird_family_id = birds.bird_family_id WHERE bird_family.bird_family_id = '{$input_delete_bird_family_bird_family_id}'");

    mysqli_close($con2);
}
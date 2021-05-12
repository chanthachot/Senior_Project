<?php
include('../connection/bird.php');

$act = mysqli_real_escape_string($con2, $_REQUEST['act']);

if ($act == 'add_bird') {
    $bird_family_id = mysqli_real_escape_string($con2, $_REQUEST['bird_family_id']);
    $input_add_bird_bird_name = mysqli_real_escape_string($con2, $_REQUEST['input_add_bird_bird_name']);
    $input_add_bird_bird_commonname = mysqli_real_escape_string($con2, $_REQUEST['input_add_bird_bird_commonname']);
    $input_add_bird_bird_sciname = mysqli_real_escape_string($con2, $_REQUEST['input_add_bird_bird_sciname']);
    $input_add_bird_bird_description = mysqli_real_escape_string($con2, $_REQUEST['input_add_bird_bird_description']);
    $input_add_bird_bird_habitat = mysqli_real_escape_string($con2, $_REQUEST['input_add_bird_bird_habitat']);

    mysqli_query($con2,"INSERT INTO birds(bird_name,bird_commonname,bird_sciname,bird_description,bird_habitat,bird_family_id) VALUES('$input_add_bird_bird_name','$input_add_bird_bird_commonname','$input_add_bird_bird_sciname','$input_add_bird_bird_description','$input_add_bird_bird_habitat','$bird_family_id')");

    $dts = $_POST['dts'];
    $ttt = explode(',',$dts);
    $others_image_last='';
    $image_link="/dist/birds_img/"; //folder name

    for($i=0; $i<sizeof($_FILES['upload_files']['name']); $i++) {
        if (in_array($i+1, $ttt)){}else{	 
            $new_file = md5(microtime());
            $image_type = $_FILES["upload_files"]["type"][$i];
            $image_name = $_FILES["upload_files"]["name"][$i];
            $image_error = $_FILES["upload_files"]["error"][$i];
            $image_temp_name = $_FILES["upload_files"]["tmp_name"][$i];
            if (($image_type == "image/jpeg") || ($image_type == "image/png") || ($image_type == "image/pjpeg") || ($image_type == "image/jpg")) {
                $test = explode('.', $image_name);
                $name = $new_file.'.'.end($test);
                $url = '.'.$image_link. $name;
                $info = getimagesize($image_temp_name);
                if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($image_temp_name);
                elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($image_temp_name);
                elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($image_temp_name);
                imagejpeg($image,$url,80);
            } 
            echo $name;
            /****** insert query here ******/
            $last_bird_id_query = mysqli_query($con2, "SELECT bird_id FROM birds WHERE bird_family_id = $bird_family_id ORDER BY bird_id DESC LIMIT 1;");
            while($row = mysqli_fetch_array($last_bird_id_query)){
                $last_bird_id = $row['bird_id'];
                mysqli_query($con2,"INSERT INTO bird_pic(bird_pic_name,bird_id) VALUES('$name','$last_bird_id')");
            }
        }
    }

    mysqli_close($con2);
}


if ($act == 'update') {
    $input_edit_bird_bird_id = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_id']);
    $input_edit_bird_bird_name = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_name']);
    $input_edit_bird_bird_commonname = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_commonname']);
    $input_edit_bird_bird_sciname = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_sciname']);
    $input_edit_bird_bird_description = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_description']);
    $input_edit_bird_bird_habitat = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_habitat']);

    mysqli_query($con2, "UPDATE birds SET bird_name = '$input_edit_bird_bird_name', bird_commonname = '$input_edit_bird_bird_commonname',
    bird_sciname = '$input_edit_bird_bird_sciname', bird_description = '$input_edit_bird_bird_description', bird_habitat = '$input_edit_bird_bird_habitat' WHERE bird_id = '$input_edit_bird_bird_id' ");

    mysqli_close($con2);
}

if ($act == 'update_with_bird_pic'){
    $input_edit_bird_bird_id = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_id']);
    $input_edit_bird_bird_name = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_name']);
    $input_edit_bird_bird_commonname = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_commonname']);
    $input_edit_bird_bird_sciname = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_sciname']);
    $input_edit_bird_bird_description = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_description']);
    $input_edit_bird_bird_habitat = mysqli_real_escape_string($con2, $_REQUEST['input_edit_bird_bird_habitat']);

    $sql = "UPDATE birds SET bird_name = '$input_edit_bird_bird_name', bird_commonname = '$input_edit_bird_bird_commonname',
    bird_sciname = '$input_edit_bird_bird_sciname', bird_description = '$input_edit_bird_bird_description', bird_habitat = '$input_edit_bird_bird_habitat' WHERE bird_id = '$input_edit_bird_bird_id' ";
    $query = mysqli_query($con2, $sql);

    $dts = $_POST['dts'];
    $ttt = explode(',',$dts);
    $others_image_last='';
    $image_link="/dist/birds_img/"; //folder name

    for($i=0; $i<sizeof($_FILES['upload_files']['name']); $i++) {
        if (in_array($i+1, $ttt)){}else{	 
            $new_file = md5(microtime());
            $image_type = $_FILES["upload_files"]["type"][$i];
            $image_name = $_FILES["upload_files"]["name"][$i];
            $image_error = $_FILES["upload_files"]["error"][$i];
            $image_temp_name = $_FILES["upload_files"]["tmp_name"][$i];
            if (($image_type == "image/jpeg") || ($image_type == "image/png") || ($image_type == "image/pjpeg") || ($image_type == "image/jpg")) {
                $test = explode('.', $image_name);
                $name = $new_file.'.'.end($test);
                $url = '.'.$image_link. $name;
                $info = getimagesize($image_temp_name);
                if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($image_temp_name);
                elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($image_temp_name);
                elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($image_temp_name);
                imagejpeg($image,$url,80);
            } 
            echo $name;
            /****** insert query here ******/
            mysqli_query($con2,"INSERT INTO bird_pic(bird_pic_name,bird_id) VALUES('$name','$input_edit_bird_bird_id')");
        }
    }
}

if ($act == 'delete') {
    $input_delete_bird_bird_id = mysqli_real_escape_string($con2, $_REQUEST['input_delete_bird_bird_id']);

    mysqli_query($con2,"DELETE birds , bird_pic from birds LEFT JOIN bird_pic on birds.bird_id = bird_pic.bird_id WHERE birds.bird_id = '{$input_delete_bird_bird_id}'");

    mysqli_close($con2);
}

if ($act == 'delete_bird_pic') {
    $bird_pic_id = mysqli_real_escape_string($con2, $_POST['input_delete_bird_pic_id']);

    $bird_pic_name = mysqli_real_escape_string($con2, $_POST['input_delete_bird_pic_name']);

    // $file_path = '../birddb/dist/birds_img/' . $bird_pic_name;

    // if(unlink($file_path)){
        mysqli_query($con2,"DELETE FROM bird_pic WHERE bird_pic_id = '{$bird_pic_id}'");
    // }

    mysqli_close($con2);
}


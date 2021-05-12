<?php
include('../connection/bird.php');

$act = mysqli_real_escape_string($con2, $_REQUEST['act']);

if ($act == 'update') {
    $input_edit_foundbirdpublic_foundbird_id = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_foundbird_id']);
    $input_edit_foundbirdpublic_bird_family_name = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_bird_family_name']);
    $input_edit_foundbirdpublic_bird_name = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_bird_name']);
    $input_edit_foundbirdpublic_amount = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_amount']);
    $input_edit_foundbirdpublic_lat = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_lat']);
    $input_edit_foundbirdpublic_lng = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_lng']);
    $input_edit_foundbirdpublic_date = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_date']);
    $input_edit_foundbirdpublic_time = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_time']);
    $input_edit_foundbirdpublic_timestamp = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_timestamp']);
    $input_edit_foundbirdpublic_mouth = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_mouth']);
    $input_edit_foundbirdpublic_body = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_body']);
    $input_edit_foundbirdpublic_tail = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_tail']);
    $input_edit_foundbirdpublic_wings = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_wings']);
    $input_edit_foundbirdpublic_legs = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_legs']);
    $input_edit_foundbirdpublic_other = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_other']);
    $input_edit_foundbirdpublic_place = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_place']);

    mysqli_query($con2, "UPDATE foundbird SET bird_family_name = '$input_edit_foundbirdpublic_bird_family_name' , bird_name = '$input_edit_foundbirdpublic_bird_name' , 
    amount = '$input_edit_foundbirdpublic_amount' , lat = '$input_edit_foundbirdpublic_lat' , lng = '$input_edit_foundbirdpublic_lng' , 
    date = '$input_edit_foundbirdpublic_date' , time = '$input_edit_foundbirdpublic_time' , timestamp = '$input_edit_foundbirdpublic_timestamp' , 
    mouth_desc = '$input_edit_foundbirdpublic_mouth' , body_desc = '$input_edit_foundbirdpublic_body' , tail_desc = '$input_edit_foundbirdpublic_tail' , 
    wings_desc = '$input_edit_foundbirdpublic_wings' , legs_desc = '$input_edit_foundbirdpublic_legs' , other_desc = '$input_edit_foundbirdpublic_other' , 
    place = '$input_edit_foundbirdpublic_place' WHERE foundbird_id = '$input_edit_foundbirdpublic_foundbird_id' ");

    mysqli_close($con2);
}

if ($act == 'update_with_foundbird_pic'){
    $input_edit_foundbirdpublic_foundbird_id = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_foundbird_id']);
    $input_edit_foundbirdpublic_bird_family_name = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_bird_family_name']);
    $input_edit_foundbirdpublic_bird_name = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_bird_name']);
    $input_edit_foundbirdpublic_amount = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_amount']);
    $input_edit_foundbirdpublic_lat = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_lat']);
    $input_edit_foundbirdpublic_lng = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_lng']);
    $input_edit_foundbirdpublic_date = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_date']);
    $input_edit_foundbirdpublic_time = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_time']);
    $input_edit_foundbirdpublic_timestamp = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_timestamp']);
    $input_edit_foundbirdpublic_mouth = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_mouth']);
    $input_edit_foundbirdpublic_body = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_body']);
    $input_edit_foundbirdpublic_tail = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_tail']);
    $input_edit_foundbirdpublic_wings = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_wings']);
    $input_edit_foundbirdpublic_legs = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_legs']);
    $input_edit_foundbirdpublic_other = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_other']);
    $input_edit_foundbirdpublic_place = mysqli_real_escape_string($con2, $_REQUEST['input_edit_foundbirdpublic_place']);

    mysqli_query($con2, "UPDATE foundbird SET bird_family_name = '$input_edit_foundbirdpublic_bird_family_name' , bird_name = '$input_edit_foundbirdpublic_bird_name' , 
    amount = '$input_edit_foundbirdpublic_amount' , lat = '$input_edit_foundbirdpublic_lat' , lng = '$input_edit_foundbirdpublic_lng' , 
    date = '$input_edit_foundbirdpublic_date' , time = '$input_edit_foundbirdpublic_time' , timestamp = '$input_edit_foundbirdpublic_timestamp' , 
    mouth_desc = '$input_edit_foundbirdpublic_mouth' , body_desc = '$input_edit_foundbirdpublic_body' , tail_desc = '$input_edit_foundbirdpublic_tail' , 
    wings_desc = '$input_edit_foundbirdpublic_wings' , legs_desc = '$input_edit_foundbirdpublic_legs' , other_desc = '$input_edit_foundbirdpublic_other' , 
    place = '$input_edit_foundbirdpublic_place' WHERE foundbird_id = '$input_edit_foundbirdpublic_foundbird_id' ");

    $dts = $_POST['dts'];
    $ttt = explode(',',$dts);
    $others_image_last='';
    $image_link="/../birddb/dist/foundbird_img/"; //folder name

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
                $workDir = 'http://' . $_SERVER['HTTP_HOST'];
                $newname = $workDir . '/birds-exploring-backend/backend/birddb/dist/foundbird_img/' . $name;
            } 
            echo $name;
            /****** insert query here ******/
            mysqli_query($con2,"INSERT INTO foundbird_pic(foundbird_pic_url,foundbird_id) VALUES('$newname','$input_edit_foundbirdpublic_foundbird_id')");
        }
    }
}

if ($act == 'delete') {
    $input_delete_foundbirdpublic_foundbird_id = mysqli_real_escape_string($con2, $_REQUEST['input_delete_foundbirdpublic_foundbird_id']);

    mysqli_query($con2, "DELETE FROM foundbird WHERE foundbird_id = '{$input_delete_foundbirdpublic_foundbird_id}'");

    mysqli_close($con2);
}

if ($act == 'delete_foundbird_pic') {
    $foundbird_pic_id = mysqli_real_escape_string($con2, $_POST['input_delete_foundbirdpublic_foundbird_pic_id']);

    // if(unlink($file_path)){
        mysqli_query($con2,"DELETE FROM foundbird_pic WHERE foundbird_pic_id = '{$foundbird_pic_id}'");
    // }

    mysqli_close($con2);
}


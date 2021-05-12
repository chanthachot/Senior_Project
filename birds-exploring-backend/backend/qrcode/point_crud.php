<?php
include('../connection/qrcode.php');

$act = mysqli_real_escape_string($con, $_REQUEST['act']);

if ($act == 'add') {
    $input_add_point_point_name = mysqli_real_escape_string($con, $_REQUEST['input_add_point_point_name']);
    $input_add_point_point_lat = mysqli_real_escape_string($con, $_REQUEST['input_add_point_point_lat']);
    $input_add_point_point_lng = mysqli_real_escape_string($con, $_REQUEST['input_add_point_point_lng']);
    $input_add_point_path_id = mysqli_real_escape_string($con, $_REQUEST['input_add_point_path_id']);

    mysqli_query($con, "INSERT INTO point(point_name,point_lat,point_lng,path_id) VALUES ('$input_add_point_point_name',
    '$input_add_point_point_lat','$input_add_point_point_lng','$input_add_point_path_id')");

    mysqli_close($con);
}

if ($act == 'update') {
    $point_id = mysqli_real_escape_string($con, $_REQUEST['point_id']);
    $input_edit_point_point_id = mysqli_real_escape_string($con, $_REQUEST['input_edit_point_point_id']);
    $input_edit_point_point_name = mysqli_real_escape_string($con, $_REQUEST['input_edit_point_point_name']);
    $input_edit_point_point_lat = mysqli_real_escape_string($con, $_REQUEST['input_edit_point_point_lat']);
    $input_edit_point_point_lng = mysqli_real_escape_string($con, $_REQUEST['input_edit_point_point_lng']);
    // $input_edit_point_point_address = mysqli_real_escape_string($con, $_REQUEST['input_edit_point_point_address']);

    mysqli_query($con, "UPDATE point SET point_name = '$input_edit_point_point_name' , point_lat = '$input_edit_point_point_lat',  point_lng = '$input_edit_point_point_lng'
    WHERE point_id = '$input_edit_point_point_id' ");
    mysqli_query($con, "UPDATE bird SET point_id = '$input_edit_point_point_id' WHERE point_id = '$point_id' ");

    mysqli_close($con);
}

if ($act == 'delete') {
    $input_delete_point_point_id = mysqli_real_escape_string($con, $_REQUEST['input_delete_point_point_id']);

    mysqli_query($con, "DELETE point, bird from point LEFT join bird on point.point_id = bird.point_id WHERE point.point_id = '{$input_delete_point_point_id}'");

    mysqli_close($con);
}

if ($act == 'delete_qrcode') {
    $qrcode_id = mysqli_real_escape_string($con, $_POST['input_delete_qrcode_id']);

    $qrcode_image = mysqli_real_escape_string($con, $_POST['input_delete_qrcode_image']);

    // $file_path = '../qrcode/qrcodelib/userQr/' . $qrcode_image;

    // if(unlink($file_path)){
        mysqli_query($con,"DELETE FROM qrcode WHERE qrcode_id = '{$qrcode_id}'");
    // }

    mysqli_close($con);
}


<?php
include('../connection/qrcode.php');

$act = mysqli_real_escape_string($con, $_REQUEST['act']);

if ($act == 'add') {
    $input_add_path_path_name = mysqli_real_escape_string($con, $_REQUEST['input_add_path_path_name']);

    mysqli_query($con, "INSERT INTO path(path_name) VALUES ('$input_add_path_path_name')");

    mysqli_close($con);
}

if ($act == 'update') {
    $input_edit_path_path_id = mysqli_real_escape_string($con, $_REQUEST['input_edit_path_path_id']);
    $input_edit_path_path_name = mysqli_real_escape_string($con, $_REQUEST['input_edit_path_path_name']);

    mysqli_query($con, "UPDATE path SET path_name = '$input_edit_path_path_name' WHERE path_id = '$input_edit_path_path_id' ");
    mysqli_query($con, "UPDATE qrpath SET path_name = '$input_edit_path_path_name' WHERE path_id = '$input_edit_path_path_name' ");

    mysqli_close($con);
}

if ($act == 'delete') {
    $input_delete_path_path_id = mysqli_real_escape_string($con, $_REQUEST['input_delete_path_path_id']);

    mysqli_query($con, "DELETE path, point, bird from path LEFT join point on path.path_id = point.path_id LEFT join bird on bird.point_id = point.point_id WHERE path.path_id = $input_delete_path_path_id");

    mysqli_close($con);
}
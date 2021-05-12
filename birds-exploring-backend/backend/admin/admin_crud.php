<?php
include('../connection/qrcode.php');

$act = mysqli_real_escape_string($con, $_REQUEST['act']);

if ($act == 'add') {
    $input_add_admin_username = mysqli_real_escape_string($con, $_REQUEST['input_add_admin_username']);
    $input_add_admin_password = mysqli_real_escape_string($con, $_REQUEST['input_add_admin_password']);
    $select_add_admin_type_id = mysqli_real_escape_string($con, $_REQUEST['select_add_admin_type_id']);

    $sql = "INSERT INTO user(username,password,type_id) VALUES('$input_add_admin_username' , '$input_add_admin_password' , '$select_add_admin_type_id')";

    $query = mysqli_query($con, $sql);

    mysqli_close($con);
}

if ($act == 'update') {
    $input_edit_admin_id = mysqli_real_escape_string($con, $_REQUEST['input_edit_admin_id']);
    $input_edit_admin_username = mysqli_real_escape_string($con, $_REQUEST['input_edit_admin_username']);
    $input_edit_admin_password = mysqli_real_escape_string($con, $_REQUEST['input_edit_admin_password']);
    $select_edit_admin_type_id = mysqli_real_escape_string($con, $_REQUEST['select_edit_admin_type_id']);

    $sql = "UPDATE user SET username = '$input_edit_admin_username' , password = '$input_edit_admin_password' , type_id = '$select_edit_admin_type_id' WHERE user_id = $input_edit_admin_id ";

    $query = mysqli_query($con, $sql);

    mysqli_close($con);
}

if ($act == 'delete') {
    $input_delete_admin_id = mysqli_real_escape_string($con, $_REQUEST['input_delete_admin_id']);

    $sql = "DELETE FROM user WHERE user_id = '{$input_delete_admin_id}'";

    $query = mysqli_query($con, $sql);

    mysqli_close($con);
}
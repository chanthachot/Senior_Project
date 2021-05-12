<?php
include('../connection/bird.php');

$act = mysqli_real_escape_string($con2, $_REQUEST['act']);

if ($act == 'update') {
    $input_edit_user_id = mysqli_real_escape_string($con2, $_REQUEST['input_edit_user_id']);
    $input_edit_user_firstname = mysqli_real_escape_string($con2, $_REQUEST['input_edit_user_firstname']);
    $input_edit_user_lastname = mysqli_real_escape_string($con2, $_REQUEST['input_edit_user_lastname']);
    $input_edit_user_email = mysqli_real_escape_string($con2, $_REQUEST['input_edit_user_email']);

    mysqli_query($con2, "UPDATE user SET first_name = '$input_edit_user_firstname' , last_name = '$input_edit_user_lastname' , email = '$input_edit_user_email' WHERE user_id = $input_edit_user_id ");

    mysqli_close($con2);
}

if ($act == 'delete') {
    $input_delete_user_id = mysqli_real_escape_string($con2, $_REQUEST['input_delete_user_id']);

    mysqli_query($con2, "DELETE FROM user WHERE user_id = '{$input_delete_user_id}'");

    mysqli_close($con2);
}
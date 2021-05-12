<?php

$act = mysqli_real_escape_string($con, $_REQUEST['act']);

if (isset($_POST['btnCreateQRCode'])) {

    $input_point_id = mysqli_real_escape_string($con, $_REQUEST['input_point_id']);

    while ($row = mysqli_fetch_array($query)) {
        $array_qrcode_bird_name .= $row["bird_name"] . "/";
        $array_qrcode_bird_lat .= $row["bird_lat"] . "/";
        $array_qrcode_bird_lng .= $row["bird_lng"] . "/";
        $array_qrcode_bird_sciname .= $row["bird_sciname"] . "/";
        $array_qrcode_bird_description .= $row["bird_description"] . "/";
        $array_qrcode_bird_pic .= $row["bird_pic"] . "/";
        $all_bird .= $row["bird_lat"] . "/" . $row["bird_lng"] . "/" . $row["bird_id"] . "/";
    }

    date_default_timezone_set("Asia/Bangkok");
    $timestamp = date("d-m-Y") . " - " . date("H:i"); 
    $qrImgName = md5(microtime());
    $qrs = QRcode::png($all_bird, "userQr/$qrImgName.png", "H", "10", "10");
    $qrimage = $qrImgName . ".png";
    $workDir = $_SERVER['HTTP_HOST'];
    // $qrlink = $workDir . "/birds-exploring/backend/qrcode/qrcodelib/userQr/" . $qrImgName . ".png";

    $sql2 = "INSERT INTO qrcode(qrcode_bird_name,qrcode_bird_lat,qrcode_bird_lng,qrcode_bird_sciname,qrcode_bird_description,qrcode_bird_pic,qrcode_image,qrcode_timestamp,point_id) 
    VALUES('$array_qrcode_bird_name','$array_qrcode_bird_lat','$array_qrcode_bird_lng','$array_qrcode_bird_sciname','$array_qrcode_bird_description',
    '$array_qrcode_bird_pic','$qrimage', '$timestamp', '$input_point_id')";
    $query2 = mysqli_query($con, $sql2);
    if ($sql2 == true) {
        echo "<script>window.location='index.php?act=success&qrimage=$qrimage';</script>";
    } else {
        echo "<script>alert('ไม่สามารถสร้าง QR Code ได้');</script>";
    }
}

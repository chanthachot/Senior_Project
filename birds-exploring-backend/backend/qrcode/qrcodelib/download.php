<?php 
if(isset($_GET['download']))
$file_name = $_GET['download'];
$workDir = $_SERVER['HTTP_HOST'];
$file_url = $workDir."/birds-exploring/backend/qrcode/qrcodelib/userQr/".$file_name."";

header('Content-type: image/jpeg');
header("Content-disposition: attachment; filename=\"".$file_name."\""); 


echo "<script>console.log('$file_url');</script>";


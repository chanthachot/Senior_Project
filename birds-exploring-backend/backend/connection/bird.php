<?php
$con2 = mysqli_connect("localhost","root","","bird") or die("Error: " . mysqli_error($con2));
mysqli_query($con2, "SET NAMES 'utf8' ");
error_reporting( error_reporting() & ~E_NOTICE );
date_default_timezone_set('Asia/Bangkok');
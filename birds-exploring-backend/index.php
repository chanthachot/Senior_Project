<?php
require_once("backend/connection/qrcode.php");
if(isset($_SESSION["USER_ID"])){
    header("Location: backend/index.php");

}else{
    include('login.php');
}
?>
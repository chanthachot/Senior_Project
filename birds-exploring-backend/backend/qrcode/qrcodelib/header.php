<?php
session_start();

error_reporting(error_reporting() & ~E_NOTICE);
if (!$_SESSION["USER_ID"]) {  //check session
    echo "<script type='text/javascript'>";
    echo "alert('กรุณาเข้าสู่ระบบก่อน');";
    echo "window.location = '../../../login.php'; ";
    echo "</script>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Birds Exploring | สร้างคิวอาร์โค้ด</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
        
    
        /* Full-width input fields */
        input[type=submit],
        input[type=text],
        input[type=password] {
            font-family: 'Kanit', sans-serif;
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            border-radius: 5px;
            font-size: 15px;
            display: inline-block;
            font-weight: 590;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        textarea {
            font-family: 'Kanit', sans-serif;
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            border-radius: 5px;
            font-size: 15px;
            display: inline-block;
            font-weight: 590;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Set a style for all buttons */
        #btnCreateQRCode {
            font-family: 'Kanit', sans-serif;
            background-color: #4CAF50;
            color: white;
            font-size: 15px;
            border-radius: 10px;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            text-decoration: none;

        }

        input[type=submit]:hover {
            font-family: 'Kanit', sans-serif;
            opacity: 0.8;
        }

        /* Extra styles for the cancel button */
        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        /* Center the image and position the close button */
        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
            position: relative;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* The Modal (background) */
        .modal {
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            padding-top: 60px;
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto;
            /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 40%;
            /* Could be more or less, depending on screen size */
        }

        /* The Close Button (x) */
        .close {
            position: absolute;
            right: 25px;
            top: 0;
            color: #000;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }

        /* Add Zoom Animation */
        .animate {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes animatezoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }

        #createQRCodeSuccess {
            width: 90%;
            margin: auto;
            text-align: center;
        }

        #createQRCodeSuccess a {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
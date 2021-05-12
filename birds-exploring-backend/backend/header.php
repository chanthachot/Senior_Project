  <?php
  session_start();

  error_reporting(error_reporting() & ~E_NOTICE);
  if (!$_SESSION["USER_ID"]) {  //check session
    echo "<script type='text/javascript'>";
    echo "window.location = '../../login.php'; ";
    echo "</script>";
  }

  ?>
  <!DOCTYPE html>
  <html>

  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Birds Exploring | Backend</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      <!-- boostrap -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
      <!-- Font Awesome -->
      <!-- fontawesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
          integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
          crossorigin="anonymous" />
      <!-- datatable -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css" />
      <!-- adminLTE -->
      <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap">
      <!-- jQuery -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css"> 

      <style>
      *:not(i) {
          font-family: 'Kanit', sans-serif;
      }

      .error {
          color: red;
          font-style: normal;
      }

      #pointMap .centerMarker,
      #pointMapEdit .centerMarker,
      #birdMap .centerMarker,
      #birdMapEdit .centerMarker,
      #foundbirdpublic_map_edit .centerMarker,
      #foundbirdprivate_map_edit .centerMarker {
          position: absolute;
          /*url of the marker*/
          background: url(http://maps.gstatic.com/mapfiles/markers2/marker.png) no-repeat;
          /*center the marker*/
          top: 50%;
          left: 50%;
          z-index: 1;
          /*fix offset when needed*/
          margin-left: -10px;
          margin-top: -34px;
          /*size of the image*/
          height: 34px;
          width: 20px;
          cursor: pointer;
      }

      #pointMap,
      #pointMapEdit,
      #birdMap,
      #birdMapEdit,
      #foundbirdpublic_map_view,
      #foundbirdpublic_map_edit,
      #foundbirdprivate_map_view,
      #foundbirdprivate_map_edit {
          height: 350px;
          width: auto;
      }

      .inputPassword {
          position: relative;
      }

      #showPassword {
          position: absolute;
          right: 10px;
          top: 35px;
          z-index: 2;
          cursor: pointer;
      }


      .suggested-posts-article {
          background: white;
          -moz-box-shadow: rgba(0, 0, 0, 0.0666) 0 3px 10px;
          -webkit-box-shadow: rgba(0, 0, 0, 0.0666) 0 3px 10px;
          box-shadow: rgba(0, 0, 0, 0.0666) 0 3px 10px;
          display: inline-block;
          margin: 5px;
          width: 23%;
      }

      article,
      aside,
      details,
      figcaption,
      figure,
      footer,
      header,
      main,
      nav,
      section {
          display: block;
      }

      article,
      aside,
      footer,
      header,
      hgroup,
      main,
      nav,
      section {
          display: block;
      }

      .suggested-posts-articlees {
          display: inline-block;
          width: 49.5%;
      }

      @media screen and (max-width:450px) {
          .suggested-posts-article {

              width: 40% !important;
          }
      }

      .more-photos:after {
          right: 3px !important;
          bottom: 0px !important;
      }

      article,
      aside,
      details,
      figcaption,
      figure,
      footer,
      header,
      main,
      nav,
      section {
          display: block;
      }

      .posts_article {
          background-color: #333;
          background-position: 50%;
          background-size: cover;
          margin-bottom: 2px;
          padding-bottom: 63.5%;
      }


      @media screen and (max-width:450px) {
          .suggested-posts-article {

              width: 40% !important;
          }
      }

      .more-photos:after {
          right: 3px !important;
          bottom: 0px !important;
      }

      .more-photos {
          cursor: pointer !important;
      }

      .bluess {
          width: 100%;
          margin: 10px;
      }


      .btn-group-sm>.btn,
      .btn-sm {
          padding: .25rem .5rem;
          font-size: .875rem;
          line-height: 1.5;
          border-radius: .2rem;
      }

      .btn-outline-secondary {
          color: #868e96;
          background-color: transparent;
          background-image: none;
          border-color: #868e96;
      }


      .btnxc {
          display: inline-block;
          padding: .5rem .75rem;
          border: 1px solid #868e96;
          margin: 3px;
          padding: .25rem .5rem;
          font-size: .875rem;
          line-height: 1.5;
          border-radius: .2rem;
          color: #868e96;
      }

      .rrrr {
          color: red;
          fill: red;
      }

      .rrrr2 {

          background-color: red;

      }

      .datepost {
          margin-top: -15px;
      }

      .anther_ma {
          margin: 1px;
      }

      .set_process {
          margin: 0px 7px 0px 0px;
      }

      .fa_p {
          margin-right: 20px;
          margin-top: 10px;
          border: 0px;
          z-index: 9999
      }

      .p_run_div {
          margin-top: -7px;
          border-radius: 0px;
          padding: 0px;
          margin-bottom: 8px;
          display: none;
      }

      .btnxc {
          margin-left: 15px;
          cursor: pointer;
      }

      .btnxc_r {
          margin-left: 15px;
          display: none;
      }
      </style>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
          <?php error_reporting(error_reporting() & ~E_NOTICE); ?>
          <?php include('navbar.php') ?>
          <?php include('menu_left.php') ?>
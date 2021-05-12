<?php
require_once("backend/connection/qrcode.php");
if (isset($_SESSION["USER_ID"])) {
  header("Location: backend/index.php");
} else {

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Birds Exploring | เข้าสู่ระบบ</title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <!-- boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> <!-- Font Awesome -->
    <!-- custom css -->
    <link rel="stylesheet" href="dist/css/login.css">
  </head>

  <body>
    <style>
      body {
        background-color: black;
        background-size: cover;
        font-family: 'Kanit', sans-serif;

        background-image: linear-gradient( rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3) ), url(dist/img/pexels-negative-space-34628.jpg) , linear-gradient(#ffffff, #57d4e7);
        /* background-image: linear-gradient(#ffffff, #57d4e7); */
        ;
      }
    </style>

    <div class="login-box">
      <div class="login-logo">
        <a>เข้าสู่ระบบ
      </div>
      <div class="card">
        <div class="card-body">
          <form action="#" method="POST" autocomplete="off">
            <div class="alert alert-danger alert-incorrect d-none" role="alert"></div>
            <?php if (isset($_COOKIE["user_id"])) { ?>
              <?php foreach ($_COOKIE["user_id"] as $k => $v) { ?>
                <div title="<?php echo $v; ?>" style="width:99px;display:inline-block;position:relative;cursor:pointer;" class="text-center card-user-cookie card-user-<?php echo $k; ?> formlogin" data-key="<?php echo $k; ?>" data-username="<?php echo $v; ?>">
                  <button type="button" class="close" aria-label="Close" style="position: absolute; right: 14px;" data-toggle="modal" data-target="#deleteModal" data-key="<?php echo $k; ?>" data-username="<?php echo $v; ?>">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <div class="account_info" data-key="<?php echo $k; ?>" data-username="<?php echo $v; ?>">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png" alt="" width="75" class="img-fluid rounded-circle img-thumbnail">
                    <?php echo "<p>" . $v . "</p>"; ?>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>

            <div title="" style="width:99px;display:inline-block;position:relative;cursor:pointer;" class="text-center  formlogin card-user-choose d-none mx-auto">
              <button type="button" class="close" aria-label="Close" style="position: absolute; right: 14px;" data-toggle="modal" data-target="#deleteModal">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="account_info_choose">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png" alt="" width="75" class="img-fluid rounded-circle img-thumbnail">

              </div>
              <p style="display:inline-block;margin: 0;"></p> <span class="small notme text-danger">ไม่ใช่ฉัน?</span>
            </div>

            <div class="form-group username">
              <div class="input-group">
                <input type="text" class="form-control login-input" id="username" name="username" placeholder="ชื่อผู้ใช้งาน" value="">
                <div class="input-group-prepend">
                  <div class="input-group-text login-input-group-text" id="btnGroupAddon"><span class="fa fa-user"></span>
                  </div>
                </div>
              </div>
              <span id="error-username" class="text-danger small"></span>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="password" class="form-control login-input" id="password" name="password" placeholder="รหัสผ่าน" value="">
                <div class="input-group-prepend">
                  <div class="input-group-text login-input-group-text" id="btnGroupAddon"><span class="fa fa-lock"></span>
                  </div>
                </div>
              </div>
              <span id="error-password" class="text-danger small"></span>
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox my-1 mr-sm-2">
                <input type="checkbox" name="remember" value="1" class="custom-control-input" id="remember">
                <label class="custom-control-label small" for="remember">จดจำฉันไว้</label>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block btn-login">เข้าสู่ระบบ</button>
              <button class="btn btn-primary btn-block d-none btn-loading align-items-center center justify-content-center" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;รอสักครู่...
              </button>
            </div>
          </form>

        </div>

      </div>
    </div>

    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">ลบผู้ใช้ ? <span class="account_id"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></h1>
            <p>คุณแน่ใจหรือว่าจะลบผู้ใช้นี้ ?</p>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-danger btn-delete">ยืนยัน</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          </div>
        </div>
      </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="dist/js/login.js"></script>
  </body>

  </html>
<?php
}
?>
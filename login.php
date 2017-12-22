<?php
session_start();
session_destroy();
include("connect.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>เข้าสู่ระบบ</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
      
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
      
    <section class="login-content">
      <div class="logo">
        <h1>ระบบติดตามความคืบหน้าวิทยานิพนธ์</h1>
      </div>
        
      <div class="login-box">
        <form data-toggle="validator" id="login_user" role="form" class="login-form" method="post"  onsubmit="return false">
          <h3 class="login-head">ลงชื่อเข้าใช้งานระบบ</h3>
          <div class="form-group">
            <label class="control-label" for="inputName">ชื่อผู้ใช้</label>
            <input class="form-control" id="inputName" name="user" type="text" placeholder="" maxlength="32" data-error="กรุณาใส่ชื่อผู้ใช้" required />
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group">
            <label class="control-label" for="inputPassword">รหัสผ่าน *</label>
            <input class="form-control" id="inputPassword" name="pw" type="password" placeholder="" maxlength="20" data-error="กรุณาใส่รหัสผ่าน" required>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" id="save"><i class="fa fa-sign-in fa-lg fa-fw"></i>เข้าสู่ระบบ</button>
          </div>
        </form>
          
<!--
        <form data-toggle="validator" role="form" class="forget-form" action="index.php">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>ลืมรหัสผ่าน ?</h3>
          <div class="form-group">
            <label class="control-label">อีเมล</label>
            <input class="form-control" type="text" placeholder="Email">
          </div>
        
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>ขอรหัสผ่านใหม่</button>
          </div>
          <div class="form-group mt-20">
            <p class="semibold-text mb-0"><a data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> ย้อนกลับ</a></p>
          </div>
        </form>
-->
      </div>
        
    </section>
  </body>
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/plugins/pace.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/plugins/validator.js"></script>
  <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
  <script type="text/javascript">
    $(document).on('click','#save',function(e) {
        var txtuser = $("#inputName").val();
        var txtpw = $("#inputPassword").val();
            if(txtuser!= "" && txtpw != ""){
                var datafrom = $("#login_user").serialize();
                $.ajax({
                         data: datafrom,
                         type: "post",
                         url: "login-check.php",
                         success: function(data){
                            if(data == 'false'){
                                $.notify({
                                    title: "ชื่อผู้ใช้ หรือหรัสผ่าน ไม่ถูกต้อง โปรดลองใหม่อีกครั้ง",
                                    message: " ",
                                    icon: "fa fa-check", 
                                },{
                                    type: "danger"
                                });
                            }
                            else{
                                window.location.href = 'index.php';
                            }
                         }
                });
            }
        });
  </script>
</html>
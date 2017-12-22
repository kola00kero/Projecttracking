<?php
	session_start();
    include("connect.php");
//    if($_SESSION['login']!=1){ 
//	header("location:login.php"); 
//    }
//    $user=$_SESSION["mem_username"];
//    $sql = "SELECT mem_fname, mem_lname FROM member WHERE mem_username = '".$user."'";
//
//    $query = mysqli_query($conn,$sql);
//    $result = mysqli_fetch_array($query);
//    $name = $result["mem_fname"]." ".$result["mem_lname"];
//    if ($_SESSION["mem_type"]==0){$type= "ผู้ดูแลระบบ";}
//    else if ($_SESSION["mem_type"]==1){$type= "อาจารย์";}
//    else if ($_SESSION["mem_type"]==2){$type= "นักศึกษา";}
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
    <link rel="stylesheet" type="text/css" href="css/summernote.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>สมัครสมาชิก</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>

<body class="sidebar-mini fixed">
    <div class="wrapper">
      <!-- Navbar-->
      <header class="main-header hidden-print"><a class="logo" href="index.php">ระบบติดตามความคืบหน้าวิทยานิพนธ์</a>
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
          <!-- Navbar Right Menu-->
          <div class="navbar-custom-menu">
            <ul class="top-nav">
              <!-- User Menu-->
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu">
                  <li><a href="login.php"><i class="fa fa-sign-out fa-lg"></i> เข้าสู่ระบบ</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Side-Nav-->
      <aside class="main-sidebar hidden-print">
        <section class="sidebar">
          <!-- Sidebar Menu-->
          <ul class="sidebar-menu">
            <li class="active">
                <a href="register.php"><i class="fa fa-pencil-square-o"></i><span>สมัครสมาชิก</span></a>
            </li>
          </ul>
        </section>
      </aside>
        
      <div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-user-plus"></i> เพิ่มข้อมูลสมาชิก</h1>
            <p>หน้าจอสำหรับเพิ่มข้อมูลสมาชิกใหม่ (เพื่อนำชื่อผู้ใช้และรหัสผ่านไปเข้าใช้งานระบบ)</p>
          </div>
          <!--<div>
            <ul class="breadcrumb side">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li>Tables</li>
              <li class="active"><a href="#">Data Table</a></li>
            </ul>
          </div>-->
        </div>
          
        <div class="row user">
          <div class="col-md-3">
            <div class="profile">
              <div class="info"><img class="user-img" src="images/user.png">
                <h4>ชื่อ นามสกุล</h4>
                <p>ประเภทสมาชิก</p>
              </div>
            </div> 
          </div>
            
          <div class="col-md-9">
            <div class="card user-settings">
                <script language="JavaScript" type="text/JavaScript">
                    function check_number() {
                        use_key=event.keyCode
                        if (use_key != 13 && (use_key < 48) || (use_key > 57)) { event.returnValue = false; }
                    }
                    function check_space() {
                        if(event.keyCode == 32)
                        event.returnValue = false;
                    }
                </script>
                <form data-toggle="validator" method="post" id="add_user" onsubmit="return false">
                    
                    <h4 class="line-head">ข้อมูลสมาชิก</h4>

                <div class="row mb-20">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">ชื่อผู้ใช้งาน *</label>
                            <input class="form-control" id="inputName" name="username" type="text" placeholder="A-Z, 0-9 ความยาว 8-32 ตัวอักษร" data-minlength="8" maxlength="32" data-error="ต้องมีความยาวอย่างน้อย 8 ตัวอักษร" onkeypress="check_space();" required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputPassword">รหัสผ่าน *</label>
                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="A-Z, 0-9 ความยาว 4-20 ตัวอักษร" data-minlength="4" maxlength="20" data-error="ต้องมีความยาวอย่างน้อย 4 ตัวอักษร" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="confirmPassword">ยืนยันรหัสผ่าน *</label>
                            <input class="form-control" id="inputPassword" name="cfpassword" type="password" placeholder="" data-match='#inputPassword' data-error="รหัสผ่านไม่ตรงกัน กรุณายืนยันอีกครั้ง" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                    
                <!--<div class="row mb-20">-->
                    <div class="form-group">
                        <input type="hidden" name="usertype" value="2">                            
                    </div>
                <!--</div>-->
                
                <!--<div class="row mb-20">-->
                    <div class="form-group">
                        <label class="control-label">รูปประจำตัวสมาชิก</label>
                        <input class="form-control" type="file" name="profilepic">
                    </div>
                <!--</div>-->   
                    
                    <br>
                    <h4 class="line-head">ข้อมูลส่วนตัว</h4>        
                        
                <div class="row mb-20">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">รหัสประจำตัว *</label>
                            <input class="form-control" id="inputName" name="code" type="text" placeholder="รหัสที่มหาวิทยาลัยกำหนด" data-error="กรุณาใส่รหัสประจำตัว" required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div> 
                    
                <div class="row mb-20">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">คำนำหน้าชื่อ *</label>
                            <input class="form-control" id="inputName" name="tname" type="text" placeholder="" data-error="กรุณาใส่คำนำหน้าชื่อ" required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">ชื่อ *</label>
                            <input class="form-control" id="inputName" name="fname" type="text" placeholder="" data-error="กรุณาใส่ชื่อจริง" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">นามสกุล *</label>
                            <input class="form-control" id="inputName" name="lname" type="text" placeholder="" data-error="กรุณาใส่นามสกุล" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>  
                        
                <div class="row mb-20">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="inputName">ที่อยู่ที่ติดต่อได้</label>
                            <textarea class="form-control" id="textArea" rows="3" name="address" placeholder=""></textarea>
                        </div>
                    </div>
                </div>        
                    
                <div class="row mb-20">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputEmail">อีเมล *</label>
                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="example@mail.com" data-error="รูปแบบอีเมลไม่ถูกต้อง" onkeypress="check_space();" required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputName">หมายเลขโทรศัพท์</label>
                            <input class="form-control" id="inputName" name="mobileno" type="text" maxlength="10" placeholder="0-9 ความยาว 9-10 หลัก" onkeypress="check_number();">
                        </div>
                    </div>
                </div>
                    
                <?php 
                    $sql = "SELECT mem_id, mem_tname, mem_fname, mem_lname FROM member WHERE mem_type = 1";
                    $query = mysqli_query($conn,$sql);
                ?>    
                    
				<div id="Reportto">
					<div class="row mb-20">
					<div class="col-md-12">
						<label>อาจารย์ที่ปรึกษาหลัก</label>
                    	<select class="form-control" id="MainAdvisor" name="MainAdvisor">
                            <optgroup label="เลือกอาจารย์ที่ปรึกษาหลัก">
                                <option></option>
                                <?php 
                                    while($result = mysqli_fetch_array($query)) {
                                        $mem_id = $result["mem_id"];
                                        $name = $result["mem_tname"]." ".$result["mem_fname"]." ".$result["mem_lname"];
                                        echo "<option value=\"".$mem_id."\">".$name."</option>";
                                    }
                                ?>
                            </optgroup>
                        </select>
					</div>
               </div>
                <?php 
                    $sql = "SELECT mem_id, mem_tname, mem_fname, mem_lname FROM member WHERE mem_type = 1";
                    $query2 = mysqli_query($conn,$sql);
                ?>   
			     <div class="row mb-20">
					<div class="col-md-12">
						<label>อาจารย์ที่ปรึกษาอื่น ๆ </label>
                    	<select class="form-control" id="OtherAdvisor" multiple="multiple">
                            <option></option>
                            <?php 
                                    while($result2 = mysqli_fetch_array($query2)) {
                                        $mem_id2 = $result2["mem_id"];
                                        $name2 = $result2["mem_tname"]." ".$result2["mem_fname"]." ".$result2["mem_lname"];
                                        echo "<option value=\"".$mem_id2."\">".$name2."</option>";
                                    }
                            ?>
                        </select>
					</div>
               	</div>
				</div>
                <div class="form-group">
                    <center><button class="btn btn-primary" id="save" >บันทึก</button></center>
                </div>
                </form> 
            </div>
          </div>
            
        </div>
      </div>
      
    <!-- Javascripts-->
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/pace.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
	<script type="text/javascript" src="js/plugins/validator.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript">
        $('#MainAdvisor').select2();
        $('#OtherAdvisor').select2();
        $(document).on('click','#save',function(e) {
            var OtherArr = $( "#OtherAdvisor" ).val() || [];
            var OtherAdvisor = '';
            for(var i = 0; i < OtherArr.length; i++)
                {
                    if(i > 0) OtherAdvisor += " , ";
                     OtherAdvisor += OtherArr[i];
                }
            var datafrom = $("#add_user").serialize() + '&OtherAdvisor=' + OtherAdvisor;
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "user-insert.php",
                     success: function(data){
                        $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                         
                         window.location.href = 'login.php';
                     }
            });
        });
    </script>
  </body>
</html>
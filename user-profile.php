<?php include("EnDeCode.php"); ?>

<?php $title = "ข้อมูลส่วนตัว"; include 'header.php'; ?>

<?php
    $stmtmem = mysqli_prepare($conn, "SELECT * FROM member WHERE mem_id = ?");
    mysqli_stmt_bind_param($stmtmem, "s", $_SESSION["mem_id"]);
    $stmtmem->execute();
    $resultmem = $stmtmem->get_result();
    if($memdata = $resultmem->fetch_assoc()){
        $mem_user = $memdata['mem_username'];
        $mem_password = decryptIt($memdata['mem_password']);
        $mem_type = $memdata['mem_type'];
        $mem_code = $memdata['mem_code'];  
        $mem_tname = $memdata['mem_tname'];
        $mem_fname = $memdata['mem_fname'];
        $mem_lname = $memdata['mem_lname'];
        $mem_address = $memdata['mem_address'];
        $mem_email = $memdata['mem_email'];
        $mem_phone = $memdata['mem_phone'];
        if($mem_type == "2"){
            $j = 0;
            $sqlrep = mysqli_prepare($conn,"SELECT * FROM reportto WHERE rep_std_memid = ? ORDER BY rep_type ASC");
            mysqli_stmt_bind_param($sqlrep, "s", $_SESSION["mem_id"]);
            $sqlrep->execute();
            $resultrep = $sqlrep->get_result();
            while($repdata = $resultrep->fetch_assoc()){
                if($repdata['rep_type'] == "0")
                {
                    $mainadvi = $repdata['rep_teac_memid'];
                }else{
                    $otheradvi[$j] = $repdata['rep_teac_memid'];
                    $j++;
                }
            }
        }
    }
    $stmtmem->close();
?>

<?php $page = "Profile"; include 'manu.php';?>
      <div class="content-wrapper">
        <div class="page-title-1">
          <div>
            <h1><i class="fa fa-user fa-lg"></i> ข้อมูลส่วนตัว</h1>
            <p>หน้าจอสำหรับแสดงข้อมูลส่วนตัวของผู้ใช้งาน</p>
          </div>
        </div>
        
        <div class="row user">       
          <div class="col-md-3">
            <div class="profile">
              <div class="info"><img class="user-img" src="images/user.png">
                <h4><?php echo $name; ?></h4>
                <p><?php echo $type; ?></p>
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
                <form data-toggle="validator" method="post" id="update_user" onsubmit="return false">
                    <h4 class="line-head">ข้อมูลสมาชิก</h4>
                <div class="row mb-20">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">ชื่อผู้ใช้งาน *</label>
                            <input class="form-control" id="inputName" name="username" type="text" placeholder="A-Z, 0-9 ความยาว 8-32 ตัวอักษร" data-minlength="4" maxlength="32" data-error="ต้องมีความยาวอย่างน้อย 4 ตัวอักษร" onkeypress="check_space();" required  value="<?php echo $mem_user ?>"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputPassword">รหัสผ่าน *</label>
                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="A-Z, 0-9 ความยาว 4-20 ตัวอักษร" data-minlength="4" maxlength="20" data-error="ต้องมีความยาวอย่างน้อย 4 ตัวอักษร" required value="<?php echo $mem_password ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="confirmPassword">ยืนยันรหัสผ่าน *</label>
                            <input class="form-control" id="inputPassword" name="cfpassword" type="password" placeholder="" data-match='#inputPassword' data-error="รหัสผ่านไม่ตรงกัน กรุณายืนยันอีกครั้ง" required value="<?php echo $mem_password ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                        <label class="control-label">รูปประจำตัวสมาชิก</label>
                        <input class="form-control" type="file" name="profilepic">
                    </div>
                    <br>
                    <h4 class="line-head">ข้อมูลส่วนตัว</h4>        
                        
                <div class="row mb-20">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">รหัสประจำตัว *</label>
                            <input class="form-control" id="inputName" name="code" type="text" placeholder="รหัสที่มหาวิทยาลัยกำหนด" data-error="กรุณาใส่รหัสประจำตัว" required value="<?php echo $mem_code ?>"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div> 
                    
                <div class="row mb-20">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">คำนำหน้าชื่อ *</label>
                            <input class="form-control" id="inputName" name="tname" type="text" placeholder="" data-error="กรุณาใส่คำนำหน้าชื่อ" required value="<?php echo $mem_tname ?>"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">ชื่อ *</label>
                            <input class="form-control" id="inputName" name="fname" type="text" placeholder="" data-error="กรุณาใส่ชื่อจริง" required value="<?php echo $mem_fname ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="inputName">นามสกุล *</label>
                            <input class="form-control" id="inputName" name="lname" type="text" placeholder="" data-error="กรุณาใส่นามสกุล" required value="<?php echo $mem_lname ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>  
                
                
                            <input class="form-control" id="inputName" name="usertype" type="hidden" value="<?php echo $mem_type ?>"/>
           
                        
                <div class="row mb-20">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="inputName">ที่อยู่ที่ติดต่อได้</label>
                            <textarea class="form-control" id="textArea" rows="3" name="address" ><?php echo $mem_address ?></textarea>
                        </div>
                    </div>
                </div>        
                    
                <div class="row mb-20">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputEmail">อีเมล *</label>
                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="example@mail.com" data-error="รูปแบบอีเมลไม่ถูกต้อง" onkeypress="check_space();" required value="<?php echo $mem_email ?>"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputName">หมายเลขโทรศัพท์</label>
                            <input class="form-control" id="inputName" name="mobileno" type="text" maxlength="10" placeholder="0-9 ความยาว 9-10 หลัก" onkeypress="check_number();" value="<?php echo $mem_phone ?>">
                        </div>
                    </div>
                </div>
                <?php 
                    if ($mem_type==2) {
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
                                        if($mem_id == $mainadvi){
                                             echo "<option value=\"".$mem_id."\" selected>".$name."</option>";
                                        }
                                        else{
                                             echo "<option value=\"".$mem_id."\">".$name."</option>";
                                        }
                                       
                                    }
                                ?>
                            </optgroup>
                        </select>
					</div>
               </div>
               <?php 
                    $sql2 = "SELECT mem_id, mem_tname, mem_fname, mem_lname FROM member WHERE mem_type = 1";
                    $query2 = mysqli_query($conn,$sql2);
               ?>
			   <div class="row mb-20">
					<div class="col-md-12">
						<label>อาจารย์ที่ปรึกษาร่วม  <span class="text-danger"><small>(สามารถเลือกอาจารย์ได้หลายท่าน)</small></label>
                    	<select class="form-control" id="OtherAdvisor" multiple="multiple">
                            <option></option>
                            <?php 
                                    $i = 0 ;
                                    while($result2 = mysqli_fetch_array($query2)) {
                                        $mem_id2 = $result2["mem_id"];
                                        $name2 = $result2["mem_tname"]." ".$result2["mem_fname"]." ".$result2["mem_lname"];
                                        if($mem_id2 == $otheradvi[$i]){
                                             echo "<option value=\"".$mem_id2."\" selected>".$name2."</option>";
                                        $i++;
                                        }
                                        else{
                                             echo "<option value=\"".$mem_id2."\">".$name2."</option>";
                                        }
                                    }
                            ?>
                        </select>
					</div>
                <input type="hidden" id="hidseladvi" value="FALSE"/>
                <input type="hidden" id="hidui" value="<?php echo $memid ?>"/>
				</div>
                </div>
                <?php } ?>    
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
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
	<script type="text/javascript" src="js/plugins/validator.js"></script>
  
    <script type="text/javascript">
      $('#MainAdvisor').select2();
      $('#OtherAdvisor').select2();
      $('select').on('change', function() {
          $("#hidseladvi").val("TRUE");
      });
	  $("input[name='usertype']").change(function(){
		  var x = document.getElementById('Reportto');
		  if($(this).val() != "Student"){
			  x.style.display = "none";
		  }
		  else{
			  x.style.display = "";
		  }
	  });
      $(document).on('click','#save',function(e) {
            var OtherArr = $( "#OtherAdvisor" ).val() || [];
            var OtherAdvisor = '';
            for(var i = 0; i < OtherArr.length; i++)
                {
                    if(i > 0) OtherAdvisor += " , ";
                     OtherAdvisor += OtherArr[i];
                }
            var datafrom = $("#update_user").serialize()+ '&UID=' + $( "#hidui" ).val() + '&OtherAdvisor=' + OtherAdvisor + '&hidseladvi=' + $("#hidseladvi").val();
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "user-update.php",
                     success: function(data){
                        $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                         
                     }
            });
        });    
    </script>
  </body>
</html>
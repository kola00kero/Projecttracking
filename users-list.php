<?php $title = "รายการข้อมูลสมาชิก"; include 'header.php'; ?>

<?php $page = "Users"; include 'manu.php';?>

      <div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-th-list"></i> รายการข้อมูลสมาชิก</h1>
            <p>หน้าจอสำหรับแสดงข้อมูลสมาชิกของระบบ</p>
          </div>
        </div>
          
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-title-w-btn">
                <h3 class="card-title"> </h3>
			    <a class="btn btn-info  btn-xs icon-btn" href="user-new.php"><i class="fa fa-user-plus"></i>เพิ่มสมาชิก</a>
		      </div>
              <div class="card-body">
                <table class="table table-hover table-responsive" id="sampleTable">
                  <thead>
                    <tr>
                      <th>ชื่อผู้ใช้</th>
                      <th>ชื่อ-นามสกุล</th>
                      <th>อีเมล</th>
                      <th>ประเภทสมาชิก</th>
                      <th>เข้าสู่ระบบล่าสุด</th>
                      <th>จัดการข้อมูล</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $sql = "SELECT * FROM member WHERE Isdeleted = ? ORDER By mem_username asc";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            $isdelete = "0";
                            mysqli_stmt_bind_param($stmt, "s", $isdelete);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        while ($resultUser = $result->fetch_assoc()){
                            $mem_id = $resultUser["mem_id"];
                            $mem_username = $resultUser["mem_username"];
                            $mem_name = $resultUser["mem_tname"]." ".$resultUser["mem_fname"]." ".$resultUser["mem_lname"];
                            $mem_email = $resultUser["mem_email"];
                            if($resultUser["mem_type"]=='0') $mem_type = "ผู้ดูแลระบบ";
                            else if($resultUser["mem_type"]=='1') $mem_type = "อาจารย์";
                            else if($resultUser["mem_type"]=='2') $mem_type = "นักศึกษา";
                            $mem_lastogin = $resultUser["mem_lastogin"];
                            $endID = base64_encode(json_encode($resultUser["mem_id"]));
                    ?>
                        <tr>
                            <td><?php echo $mem_username; ?></td>
                            <td><?php echo $mem_name; ?></td>
                            <td><?php echo $mem_email; ?></td>
                            <td><?php echo $mem_type; ?></td>
                            <td><?php echo date("d/M/Y H:i:s", strtotime($mem_lastogin)); ?></td>
                            <td align="center"> 
                                <a href="user-info.php?ui=<?php echo $endID; ?>" class="viewUser" title="View/Edit"><i class="fa fa-file-text-o"></i></a>
                                &nbsp&nbsp&nbsp&nbsp&nbsp
                                <a class="demoSwal" id='<?php echo $mem_id; ?>' title="Delete"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    <?php }
                        mysqli_stmt_close($stmt);
                        }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
    <?php include 'footer.php';?>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
    <script type="text/javascript">
      $('.demoSwal').click(function(){
          var userID = this.id;
      	swal({
      		title: "ต้องการลบข้อมูลสามาชิก ?",
      		text: "หากลบข้อมูล สมาชิกคนดังกล่าวจะไม่สามารถเข้าใช้งานระบบได้!",
      		type: "warning",
      		showCancelButton: true,
      		confirmButtonText: "ลบ !",
      		cancelButtonText: "ยกเลิก",
      		closeOnConfirm: false,
      		closeOnCancel: false
      	}, function(isConfirm) {
      		if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: "user-delete.php",
                    data:{userID: userID},
                    success: function(data1){
                        if(data1 == 1){ 
                            swal({
                                title: "ลบ !",
      		                    text: "ข้อมูลที่เลือกถูกลบเรียบร้อยแล้ว",
                                type: "success",
                                confirmButtonText: "OK"
                            }, function(isConfirm){
                                window.location.reload();
                            }); 
                        }   
                    }
                }); 
      		} else {
      			swal("ยกเลิก", "ข้อมูลที่เลือกยังไม่ถูกลบ :)", "error");
      		}
      	});
      });
    </script>  
</html>
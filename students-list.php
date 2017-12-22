<?php $title = "รายการนักศึกษา"; include 'header.php'; ?>

<?php $page = "Students"; include 'manu.php';?>

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
              <div class="card-body">
                <table class="table table-hover table-responsive" id="sampleTable">
                  <thead>
                    <tr>
                      <th>รหัสนักศึกษา</th>
                      <th>ชื่อ - นามสกุล</th>
                      <th>อีเมล</th>
<!--                      <th>จำนวนโพส</th>-->
                      <th>เข้าสู่ระบบล่าสุด</th>
                      <th>รายละเอียด</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $sql = "SELECT * FROM member AS m LEFT JOIN reportto AS re ON re.rep_std_memid = m.mem_id
                            WHERE re.rep_teac_memid = ? AND m.Isdeleted = 0 ORDER BY mem_username ASC";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmt, "s", $_SESSION["mem_id"]);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        while ($resultmem = $result->fetch_assoc()){
                            $mem_id = $resultmem["mem_id"];
                            $mem_code = $resultmem["mem_code"];
                            $mem_name = $resultmem["mem_tname"]." ".$resultmem["mem_fname"]." ".$resultmem["mem_lname"];
                            $mem_email = $resultmem["mem_email"];
                            $mem_lastogin = $resultmem["mem_lastogin"];
                            $endID = base64_encode(json_encode($resultmem["mem_id"]));
                    ?>
                        <tr>
                            <td><?php echo $mem_code; ?></td>
                            <td><?php echo $mem_name; ?></td>
                            <td><?php echo $mem_email; ?></td>
<!--                            <td><?php echo $mem_type; ?></td>-->
                            <td><?php echo date("d/M/Y H:m:s", strtotime($mem_lastogin)); ?></td>
                            <td align="center"> 
                                <a href="student-info.php?ui=<?php echo $endID; ?>" class="viewUser" title="View/Edit"><i class="fa fa-file-text-o"></i></a>
                            </td>
                        </tr>
                    <?php }
                        mysqli_stmt_close($stmt);
                        }
                      ?>
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
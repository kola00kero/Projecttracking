<?php $title = "ข้อมูลนักศึกษา"; include 'header.php'; ?>

<?php
    $memid = json_decode(base64_decode($_GET["ui"]));

    $stmtStu = mysqli_prepare($conn, "SELECT * FROM member WHERE mem_id = ?");
    mysqli_stmt_bind_param($stmtStu, "s", $memid);
    $stmtStu->execute();
    $resultStu = $stmtStu->get_result();
    if($studata = $resultStu->fetch_assoc()){
        $mem_user = $studata['mem_username'];
        $mem_usertype = $studata['mem_type'];
        $mem_code = $studata['mem_code'];  
        $mem_tname = $studata['mem_tname'];
        $mem_fname = $studata['mem_fname'];
        $mem_lname = $studata['mem_lname'];
        $mem_address = $studata['mem_address'];
        $mem_email = $studata['mem_email'];
        $mem_phone = $studata['mem_phone'];
        $mem_lastogin = $studata["mem_lastogin"];
        if($mem_usertype == "2"){
            $j = 0;
            $sqlrep = mysqli_prepare($conn,"SELECT * FROM reportto WHERE rep_std_memid = ? ORDER BY rep_type ASC");
            mysqli_stmt_bind_param($sqlrep, "s", $memid);
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
    mysqli_stmt_close($stmtStu);

?>

<?php $page = "Students"; include 'manu.php';?>
        
      <div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-user fa-lg"></i> ข้อมูลนักศึกษา</h1>
            <p>หน้าจอสำหรับแสดงข้อมูลนักศึกษาในการดูแล</p>
          </div>
        </div>
          
        <div class="row user">
          <div class="col-md-3">
            <div class="profile">
              <div class="info"><img class="user-img" src="images/user.png">
                <h4><?php echo $mem_fname." ".$mem_lname; ?></h4>
                <p>นักศึกษา</p>
              </div>
            </div> 
             <div class="card p-0">
              <ul class="nav nav-tabs nav-stacked user-tabs">
                <li class="active"><a href="#student-profile" data-toggle="tab">ข้อมูลส่วนตัว</a></li>
                <li><a href="#student-timeline" data-toggle="tab">รายการโพส</a></li>
              </ul>
            </div>  
          </div>
          <div class="col-md-9 tab-content">
                 
            <div class="tab-pane active" id="student-profile">
                <div class="card user-settings">
                  <h4 class="line-head">ข้อมูลส่วนตัว</h4>
                  <form>
                    <div class="row mb-20">
                      <div class="col-md-4">
                        <label>รหัสประจำตัว *</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $mem_code; ?>">
                      </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-md-4">
                        <label>คำนำหน้าชื่อ *</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $mem_tname; ?>">
                      </div>
                      <div class="col-md-4">
                        <label>ชื่อ *</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $mem_fname; ?>">
                      </div>
                      <div class="col-md-4">
                        <label>นามสกุล *</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $mem_lname; ?>">
                      </div>
                    </div>
                    <div class="row mb-20">
                      <div class="col-md-12 mb-20">
                        <label>ที่อยู่ที่ติดต่อได้</label>
                        <textarea class="form-control" id="textArea" rows="3" id="disabledInput" disabled=""><?php echo $mem_address; ?></textarea>
                      </div>
                      <div class="col-md-6 mb-20">
                        <label>อีเมล *</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $mem_email; ?>">
                      </div>
                      <div class="col-md-6 mb-20">
                        <label>หมายเลขโทรศัพท์</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $mem_phone; ?>">
                      </div>
                      
                      <?php 
                        $sql = "SELECT mem_tname, mem_fname, mem_lname FROM member WHERE mem_id = '".$mainadvi."'";
                        $query = mysqli_query($conn,$sql);
                        $result = mysqli_fetch_array($query);
                        $name = $result["mem_tname"]." ".$result["mem_fname"]." ".$result["mem_lname"];
                      ?>    
                        
                      <div class="col-md-12 mb-20">
                        <label>อาจารย์ที่ปรึกษาหลัก</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $name; ?>">
                      </div>
                      <?php 
                            $sql2 = "SELECT mem_id, mem_tname, mem_fname, mem_lname FROM member WHERE mem_type = 1";
                            $query2 = mysqli_query($conn,$sql2);
                       ?>
                       <div class="col-md-12">
                                <label>อาจารย์ที่ปรึกษาร่วม</label>
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
                      </div>
                      <div class="row mb-20">
                      <div class="col-md-4">
                        <?php 
                            $sql3 = "SELECT topp_id FROM toppic WHERE topp_createdby = '".$memid."'";
                            $query3 = mysqli_query($conn,$sql3);
                            //$result3 = mysqli_fetch_array($query3);
                            $row3 = mysqli_num_rows($query3);
                        ?>  
                          
                        <label>จำนวนโพส</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo $row3; ?> หัวข้อ">
                      </div>
                      <div class="col-md-4">
                        <label>เข้าสู่ระบบล่าสุด</label>
                        <input class="form-control" id="disabledInput" disabled="" type="text" value="<?php echo date("d/M/Y H:m:s", strtotime($mem_lastogin)); ?>">
                      </div>
                    </div>
                  </form>
                </div>
            </div>
              
            <div class="tab-pane" id="student-timeline">
                <div class="card-1 user-settings">
                    <table class="table table-hover table-responsive" id="sampleTable">
                        <thead>
                            <tr>
                                <th>วันที่เข้าพบ</th>
                                <th>หัวข้อ</th>
                                <th>อาจารย์ที่เข้าพบ</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <?php 

                            $sql = "SELECT * FROM toppic WHERE Isdeleted = 0 AND topp_approvestartus <> 'D' AND topp_createdby = ? ORDER BY topp_createddate ASC";
                            if ($stmttop = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmttop, "s", $memid);
                            $stmttop->execute();
                            $resulttop = $stmttop->get_result();
                            while ($topdata = $resulttop->fetch_assoc()){
                                $topp_id = base64_encode(json_encode($topdata["topp_id"]));
                                $topp_docdate = $topdata["topp_docdate"];
                                $topp_topic = $topdata["topp_topic"];
                                $topp_advi = $topdata["topp_advi"];
                                $Advarr = explode(" , ", $topp_advi);
                                $adviser = "";
                                    for($i = 0; $i < count($Advarr); $i++)
                                    {
                                        if($i != 0)
                                        {
                                            $adviser .= " , ";
                                        } 
                                        $sql2 = "SELECT * FROM member WHERE mem_id = '".$Advarr[$i]."'";
                                        $query2 = mysqli_query($conn,$sql2);
                                        while($result2 = mysqli_fetch_array($query2))
                                        {
                                            $adviser .= $result2["mem_tname"]." ".$result2['mem_fname']." ".$result2['mem_lname'];
                                        }
                                    }
                                if($topdata["topp_approvestartus"]=='Y') $topp_approvestartus = "Approve";
                                else if($topdata["topp_approvestartus"]=='W') $topp_approvestartus = "Wait Approve";
                                $path = "'Docopen(\"".$topp_id."\")'";
                    ?>
                  <tbody>
                      <tr style="cursor:pointer;" ondblclick =<?php echo $path; ?> >
                        <td><?php echo date("d/M/Y", strtotime($topp_docdate)); ?></td>
                        <td><?php echo $topp_topic; ?></td>
                        <td><?php echo $adviser; ?></td>
                        <td><?php echo $topp_approvestartus; ?></td>
                      </tr>
                  </tbody>
                    <?php
                        }
                        mysqli_stmt_close($stmttop);
                    }
                    ?>
                    </table>
                </div>
            </div>
              
          </div>
        </div>
      </div>
    </div>
     <!-- Javascripts-->
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/pace.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript">
      $('#OtherAdvisor').select2().prop("disabled", true);
    </script>
<script>
    function Docopen(path){
        var link = "form-docinfo.php?doc="+path;
        window.location.href= link;
    }  
    </script>
  </body>
</html>
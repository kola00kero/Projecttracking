<?php $title = "Project's Board"; include 'header.php';?>
<?php $page = "Board"; include 'manu.php';?>
        
      <div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-pencil-square-o"></i> Project's Board</h1>
            <p>List to display Student's Projrct and Projrct's detail</p>
          </div>
        </div>
          
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-title-w-btn">
              <h3 class="card-title"> </h3>
                  <?php if($_SESSION["mem_type"] == '2'){ ?>
			  <a class="btn btn-info  btn-xs icon-btn" href="form-newinfo.php"><i class="fa fa-fw fa-lg fa-plus-circle"></i>New</a>
                  <?php } ?>
		      </div>
              <div class="card-body">
				  <?php $sort=""; if($_SESSION["mem_type"] != '2'){ $sort="6"; }else {$sort="5";}?> 
				  <table class="table table-hover table-responsive" data-order='[[ <?php echo $sort; ?>, "desc" ]]' id="sampleTable">
                    <thead>
                    <tr>
                        <th>วันที่เข้าพบ</th>
                        <th>อาจารย์ที่เข้าพบ</th>
                    <?php if($_SESSION["mem_type"] != '2'){ ?> 
                        <th>โดย</th> 
                    <?php } ?>
                        <th>หัวข้อ</th>
                        <th>สถานะ</th>
						<th>ข้อความล่าสุด</th>
						<th style="display:none;">ข้อความล่าสุด</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $where = "";
                        if($_SESSION["mem_type"] == '1'){
                            $where .= "AND tp.topp_approvestartus <> 'D' AND (tp.topp_createdby in ('";
                            $j = 0;
                            if ($stmt = mysqli_prepare($conn, "SELECT * FROM reportto WHERE rep_teac_memid =?")) {
                                mysqli_stmt_bind_param($stmt, "s", $_SESSION["mem_id"]);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($resultteac = $result->fetch_assoc()){
                                    if($j != 0)$where .= "','";                                        
                                        $where .= $resultteac["rep_std_memid"];
                                    $j++;
                                }
                                mysqli_stmt_close($stmt);
                            }
                            $where .= "') OR tp.topp_advi LIKE '%".$_SESSION["mem_id"]."%')";
                        }
                        else if($_SESSION["mem_type"] == '2'){
                            $where .= "AND tp.topp_createdby = '".$_SESSION["mem_id"]."'";
                        }
                        $sql = "SELECT * FROM toppic AS tp LEFT JOIN member AS mem ON tp.topp_createdby = mem.mem_id WHERE tp.Isdeleted = ? ".$where;
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            $isdelete = "0";
                            mysqli_stmt_bind_param($stmt, "s", $isdelete);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        while ($resultTop = $result->fetch_assoc()){
                            $topp_id = base64_encode(json_encode($resultTop["topp_id"]));
                            $topp_docdate = $resultTop["topp_docdate"];
                            $topp_topic = $resultTop["topp_topic"];
                            $topp_advi = $resultTop["topp_advi"];
                            $topp_mam = $resultTop["mem_tname"]." ".$resultTop['mem_fname']." ".$resultTop['mem_lname'];
							$LastUpdate = $resultTop["LastUpdate"];
							$date = strtotime($LastUpdate);
							
							$datetime1 = new DateTime($LastUpdate);
							$datetime2 = new DateTime();
							$interval = $datetime2->diff($datetime1);
							$overDay = $interval->format('%a');;
							$overhour = $interval->format('%h');;
							if($overDay < 1)
							{
								if($overhour < 1)
								{
                                    if($interval->format('%i') < 5)
                                    {
                                        $newLast = "ตอนนี้";
                                    }else{
                                        $newLast = $interval->format('%i')." นาทีที่แล้ว";
                                    }
									
								}
								else{
									$newLast = $overhour." ชั่วโมงที่แล้ว";//"วันนี้ : ".date('H:m:s', $date);
								}
							}
                            else
                            {
                                $newLast = "วันที่ ".date("d/M/Y H:i:s", strtotime($LastUpdate))." น.";
                            }
							
                            $Advarr = explode(" , ", $topp_advi);
                            $adviser = "";
                                for($i = 0; $i < count($Advarr); $i++)
                                {
                                    if($i != 0)
                                    {
                                        $adviser .= " , ";
                                    } 
                                    if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM member WHERE mem_id = ?")) {
                                        mysqli_stmt_bind_param($stmt2, "s", $Advarr[$i]);
                                        $stmt2->execute();
                                        $result2 = $stmt2->get_result();
                                        while($resultAdv = $result2->fetch_assoc())
                                        {
                                            $adviser .= $resultAdv["mem_tname"]." ".$resultAdv['mem_fname']." ".$resultAdv['mem_lname'];
                                        }
                                        mysqli_stmt_close($stmt2);
                                    }

                                }
                            $path = "";
                                switch ($resultTop["topp_approvestartus"]) {
                                    case "Y":
                                        $topp_approvestartus = "Approve";
                                        $path .= "'Docopen(\"".$topp_id."\")'";
                                        break;
                                    case "W":
                                        $topp_approvestartus = "Wait Approve";
                                        $path .= "'Docopen(\"".$topp_id."\")'";
                                        break;
                                    case "D":
                                        $topp_approvestartus = "Darft";
                                        $path .= "'Docedit(\"".$topp_id."\")'";
                                        break;
                                }
                        ?>
                        <tr style="cursor:pointer;" onclick =<?php echo $path; ?> >
                        <td><?php echo date("d/M/Y", strtotime($topp_docdate)); ?></td>
                        <td><?php echo $adviser; ?></td>
                        <?php if($_SESSION["mem_type"] != '2'){ ?> 
                        <td><?php echo $topp_mam; ?></td>
                        <?php } ?>
                        <td><?php echo $topp_topic; ?></td>
                        <td><?php echo $topp_approvestartus; ?></td>
						<td><?php echo $newLast; ?></td>
						<td style="display:none;"><?php echo $LastUpdate; ?></td>
                      </tr>
                        <?php 
                                }
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
    <!-- Javascripts-->
    <script>
    function Docopen(path){
        var link = "form-docinfo.php?doc="+path;
        window.location.href= link;
    }  
        
    function Docedit(path){
        var link = "form-editinfo.php?doc="+path;
        window.location.href= link;
    }  
    </script>
  </body>

<?php include 'footer.php';?>
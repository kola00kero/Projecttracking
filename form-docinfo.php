<?php $title = "Project's Board"; include 'header.php';?>
<?php $page = "Board"; include 'manu.php';?>
<?php

    $doc = json_decode(base64_decode($_GET["doc"]));
    $sql1 = "SELECT * FROM toppic WHERE topp_id='".$doc."'";
	$query1 = mysqli_query($conn,$sql1);
	$result1 = mysqli_fetch_array($query1);
	if($result1)
	{
        $topp_docdate=$result1['topp_docdate'];
        $topp_advi=$result1['topp_advi'];
        $topp_topic=$result1['topp_topic'];  
        $topp_detail=$result1['topp_detail'];
        $topp_approvestartus=$result1['topp_approvestartus'];
        $topp_createdby=$result1['topp_createdby'];
        $topp_createddate=$result1['topp_createddate'];
        $topp_modifedby=$result1['topp_modifedby'];
        $topp_modifeddate=$result1['topp_modifeddate'];
    }

    $Advarr = explode(", ", $topp_advi);
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
?>

    <div class="content-wrapper">
         <div class="col-md-12">
             <div class="card">
                 <div class="card-title-w-btn">
                     <h3 class="title">หัวข้อ : <?php echo $topp_topic; ?> 
                         <?php if($topp_createdby == $_SESSION["mem_id"]){ ?>
                            <small><a onclick="editTitle()"><i class="fa fa-edit"></i></a></small>
                         <?php } ?>
                     </h3>
                     <div class="btn-group">
                     <?php 
//                            $sqlapprover = "SELECT * FROM reportto WHERE rep_std_memid ='".$topp_createdby."' AND rep_teac_memid ='".$_SESSION["mem_id"]."'  AND rep_type = 0";
//                            $queryapprover = mysqli_query($conn,$sqlapprover);
//                            $resultapprover = mysqli_num_rows($queryapprover);
                            if($_SESSION["mem_type"] == '1' && $topp_approvestartus == 'W')
                            {
                     ?>
                            <a class="btn btn-success  btn-xs icon-btn" onclick="Approve()"><i class="fa fa-fw fa-lg fa-check-circle"></i>Approve</a>
                     <?php 
                            }
                            else
                            {
                                if($topp_approvestartus == 'W')
                                {
                                    echo "<h4 class='text-danger'>Wait Approve</h4>";
                                }
                                else if($topp_approvestartus == 'Y')
                                {
                                    echo "<h4 class='text-success'>Approve</h4>";
                                }
                            }
                     ?>
                    </div>
                 </div>
                 <div class="card-body">
				     <p>อาจารย์ที่เข้าพบ : <?php echo $adviser; ?></p>
				     <p>วันที่เข้าพบ : <?php echo date("M/d/Y", strtotime($topp_docdate)); ?></p>
                     <p>สรุปประเด็นคำปรึกษา</p>
                     <div class="panel panel-primary">
                         <div class="panel-body">
                             <?php echo $topp_detail; ?>
                             <?php if($topp_modifedby != "") { ?>
                             <small>แก้ไขบันทึกครั้งล่าสุด on <cite title="Date"><?php echo date("M/d/Y H:m:s", strtotime($topp_modifeddate)); ?></cite></small>
                             <?php } ?>
                         </div>
                     </div>
                 </div>
                 <?php
                 $dir = "server/uploads/".$doc."/";
                 if ($handle = opendir($dir)) {
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                            echo "<a href='download.php?dir=".$dir."&file=".$entry."'>".$entry."</a>\n";
                        }
                    }
                    closedir($handle);
                }   
                ?>
             </div>
         </div>
         
        <?php
            $sql2 = "SELECT * FROM comment WHERE isdeleted=0 and comm_topid='".$doc."' ORDER BY comm_liston ASC";
            $query2 = mysqli_query($conn,$sql2);
            while($result2 = mysqli_fetch_array($query2)){
                $sql3 = "SELECT * FROM member WHERE mem_id = '".$result2['comm_createdby']."'";
                $query3 = mysqli_query($conn,$sql3);
                while($result3 = mysqli_fetch_array($query3))
                {
                    $Commentname = $result3["mem_tname"]." ".$result3['mem_fname']." ".$result3['mem_lname'];
                }
                $commentby ="";
                if($result2['comm_modifedby']!="")
                {
                    $commentby = "<small>แก้ไขบันทึกครั้งล่าสุด on <cite title='Date'>".date("M/d/Y H:m:s", strtotime($result2['comm_modifeddate']))."</cite></small><br/>";
                }
                $CID = $result2['comm_id'];
                    echo "<div class='col-md-11 "; if($result2['comm_createdby'] != $topp_createdby){echo"col-md-offset-1";} echo"'>
                            <div class='panel panel-primary'>
                                <div class='panel-body' id='com".$result2['comm_liston']."'>";
                                    if($result2['comm_createdby'] == $_SESSION["mem_id"]){
                                    echo "<a class='pull-right' data-toggle='modal' data-target='.bs-example-modal-lg' onclick='editComment(".$result2['comm_liston'].")' id='btnedit'><i class='fa fa-fw fa-lg fa-pencil-square-o'></i></a>";
                                    }
                                echo "
                                <input type='hidden' id='hidcom".$result2['comm_liston']."' value='".$CID."'/>
                                <h5 class='card-title'>ความคิดเห็นที่ ".$result2['comm_liston']."</h5>
                                    <div id='comtext".$result2['comm_liston']."'>
                                    ".$result2['comm_detail']."
                                    </div>
                                    ".$commentby."
                                    <small>Comment by ".$Commentname." on <cite title='Date'>".date("M/d/Y H:m:s", strtotime($result2['comm_createddate']))."</cite></small>
                                </div>
                            </div>
                        </div>";
                
            }
        ?>
         
		  <div class="col-md-12">
              <div class="card card">
                  <h4 class="card-title"><i class="fa fa-fw fa-lg fa-commenting-o"></i>แสดงความคิดเห็น</h4>
                  <div class="card-body">
                      <div class="form-group">
                          <div id="Comment" name="Comment"></div>
                      </div>
                  </div>
                  <div class="card-footer">
                      <button class="btn btn-primary icon-btn" type="button" id="btncomment">บันทึก</button>
                  </div>
              </div>
         </div>
            <input type="hidden" id="hiddoc" value="<?php echo $doc ?>"/>
        
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="commodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <input type="hidden" id="hidcomedit"/>
              <div class="modal-body">
                <div id="editComment" name="editComment"></div>
              </div>
              <div class="modal-footer">
                <button  type="button" id='btneditcom' class="btn btn-primary">บันทึก</button>
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
	<script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/summernote.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript">
        $('#Comment').summernote(
            {
                height: 200,
                minHeight: 200,
                maxHeight: 200,
                toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ]
            });
            $('#editComment').summernote(
            {
                height: 200,
                minHeight: 200,
                maxHeight: 200,
                toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ]
            });
        $(document).on('click','#btncomment',function(e) {
            var commentbox = $("#Comment").summernote('code');
            var datafrom = '&Comment=' + commentbox + '&Docid=' + $("#hiddoc").val();
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "comment-save.php",
                     success: function(result){
//                        alert(result);
                        $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                     }
            });
        });
        function editTitle(){
            var docID = "<?php echo base64_encode(json_encode($doc)); ?>";
            window.location.href = 'form-editinfo.php?doc='+docID;
        }
        function editComment(comID){
            var commhid = $("#hidcom"+comID).val();
            $.ajax({
                     data: { commhid: commhid},
                     type: "post",
                     url: "selectcom.php",
                     success: function(result){
                         var obj = JSON.parse(result);
                         $('#editComment').summernote('code', obj.commdetail);
                         $('#hidcomedit').val(obj.commID);
                     }
            });
        }
        $(document).on('click','#btneditcom',function(e) {
            var editComment = $("#editComment").summernote('code');
            var datafrom = '&Comment=' + editComment + '&comId=' + $("#hidcomedit").val();
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "comment-update.php",
                     success: function(result){
                         $('#commodal').modal('hide');
                         $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                     }
            });
        });
        function Approve(){
            var DocID = $("#hiddoc").val();
            var sta = "Y";
            var datafrom = 'DID=' + DocID + '&Status=' + sta ;
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "Approve.php",
                     success: function(result){
                         $('#commodal').modal('hide');
                         $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                     }
            });
        }
    </script>
  </body>
</html>
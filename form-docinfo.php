<?php $title = "Project's Board"; include 'header.php';?>
<?php $page = "Board"; include 'manu.php';?>
<?php
	if($_GET["doc"] == '')
	{
		header("location:index.php");
	}
	else{
    	$doc = json_decode(base64_decode($_GET["doc"]));
	}
    $stmttopp = $conn->prepare("SELECT * FROM toppic WHERE topp_id = ?");
    $stmttopp->bind_param("s", $doc);
    $stmttopp->execute();
    $resulttopp = $stmttopp->get_result();
    if($toppdata = $resulttopp->fetch_assoc()){
        $topp_docdate = $toppdata['topp_docdate'];
        $topp_advi = $toppdata['topp_advi'];
        $topp_topic = $toppdata['topp_topic'];  
        $topp_detail = $toppdata['topp_detail'];
        $topp_approvestartus = $toppdata['topp_approvestartus'];
        $topp_createdby = $toppdata['topp_createdby'];
        $topp_createddate = $toppdata['topp_createddate'];
        $topp_modifedby = $toppdata['topp_modifedby'];
        $topp_modifeddate = $toppdata['topp_modifeddate'];
    }
    $stmttopp->close();
    $Advarr = explode(" , ", $topp_advi);
    $adviser = "";
    for($i = 0; $i < count($Advarr); $i++)
    {
        if($i != 0)
        {
            $adviser .= " , ";
        }
        $stmtdocAdv = $conn->prepare("SELECT * FROM member WHERE mem_id = ?");
        $stmtdocAdv->bind_param("s", $Advarr[$i]);
        $stmtdocAdv->execute();
        $resultdocAdv = $stmtdocAdv->get_result();
        while($docAdvdata = $resultdocAdv->fetch_assoc()){
            $adviser .= $docAdvdata["mem_tname"]." ".$docAdvdata['mem_fname']." ".$docAdvdata['mem_lname'];
        }
    }
    $stmtdocAdv->close();
?>

    <div class="content-wrapper">
         <div class="col-md-12">
             <div class="card">
                 <div class="card-title-w-btn">
                     <h3 class="title">หัวข้อ : <?php echo $topp_topic; ?> 
                         <?php if($topp_createdby == $_SESSION["mem_id"] && $topp_approvestartus == 'W'){ ?>
                            <small><a onclick="editTitle()"><i class="fa fa-edit"></i></a></small>
                         <?php } ?>
                     </h3>
                     <div class="btn-group">
                     <?php 
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
                 <div class="table-responsive">
  						<table class="table table-bordered">
						  <thead>
							  <th>Upload</th>
						  </thead>
						  <tbody>
							  <?php
                 			$dir = "server/uploads/".$doc."/";
                 			if ($handle = opendir($dir)) {
                    			while (false !== ($entry = readdir($handle))) {
                        			if ($entry != "." && $entry != "..") {
										echo "<tr><td><a href='download.php?dir=".$dir."&file=".$entry."'>".$entry."</a></td></tr>";
										}
                    			}
							closedir($handle);
                			}   
                		?>	
						  </tbody>
					  	</table>
					  </div>
             </div>
         </div>
         
        <?php
            $stmtComm = $conn->prepare("SELECT * FROM comment WHERE isdeleted=0 and comm_topid = ? ORDER BY comm_liston ASC");
            $stmtComm->bind_param("s", $doc);
            $stmtComm->execute();
            $resultComm = $stmtComm->get_result();
            while($Commdata = $resultComm->fetch_assoc()){
                $stmtmem = $conn->prepare("SELECT * FROM member WHERE mem_id = ?");
                $stmtmem->bind_param("s", $Commdata['comm_createdby']);
                $stmtmem->execute();
                $resultmem = $stmtmem->get_result();
                if($memdata = $resultmem->fetch_assoc()){
                    $Commentname = $memdata["mem_tname"]." ".$memdata['mem_fname']." ".$memdata['mem_lname'];
                }
                $stmtmem->close();
                $commentby ="";
                if($Commdata['comm_modifedby']!="")
                {
                    $commentby = "<small>แก้ไขบันทึกครั้งล่าสุด on <cite title='Date'>".date("M/d/Y H:m:s", strtotime($Commdata['comm_modifeddate']))."</cite></small><br/>";
                }
                $CID = $Commdata['comm_id'];
                    echo "<div class='col-md-11 "; if($Commdata['comm_createdby'] != $topp_createdby){echo"col-md-offset-1";} echo"'>
                            <div class='panel panel-primary'>
                                <div class='panel-body' id='com".$Commdata['comm_liston']."'>";
                                    if($Commdata['comm_createdby'] == $_SESSION["mem_id"]){
                                    echo "<a class='pull-right' data-toggle='modal' data-target='.bs-example-modal-lg' onclick='editComment(".$Commdata['comm_liston'].")' id='btnedit'><i class='fa fa-fw fa-lg fa-pencil-square-o'></i></a>";
                                    }
                                echo "
                                <input type='hidden' id='hidcom".$Commdata['comm_liston']."' value='".$CID."'/>
                                <h5 class='card-title'>ความคิดเห็นที่ ".$Commdata['comm_liston']."</h5>
                                    <div id='comtext".$Commdata['comm_liston']."'>
                                    ".$Commdata['comm_detail']."
                                    </div>
                                    ".$commentby."
                                    <small>Comment by ".$Commentname." on <cite title='Date'>".date("M/d/Y H:m:s", strtotime($Commdata['comm_createddate']))."</cite></small>
                                </div>
                            </div>
                        </div>";
                
            }
            $stmtComm->close();
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
            var datafrom = '&Comment=' + editComment + '&comId=' + $("#hidcomedit").val()+ '&Docid=' + $("#hiddoc").val();
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
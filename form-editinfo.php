<?php $title = "เพิ่มข้อมูลสมาชิก"; include 'header.php'; ?>
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

    $Advarr = explode(" , ", $topp_advi);
?>


    <div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-edit"></i>บันทึกการเข้าพบอาจารย์</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <form id="form-info" onsubmit="return false" enctype="multipart/form-data">
                    <div class="form-group">
                            <?php 
                                $sql = "SELECT mem_id, mem_tname, mem_fname, mem_lname FROM member WHERE mem_type = 1";
                                $query = mysqli_query($conn,$sql);
                            ?>    
                        <label class="control-label">อาจารย์ที่เข้าพบ <span class="text-danger"><small>(สามารถเลือกอาจารย์ได้หลายท่าน)</small></span></label>
                        <select id="Advisor" class="js-example-basic-multiple js-states form-control" multiple="multiple" style="width: 100%;">
                            <?php 
                                    $i = 0 ;
                                    while($result = mysqli_fetch_array($query)) {
                                        $mem_id = $result["mem_id"];
                                        $name = $result["mem_tname"]." ".$result["mem_fname"]." ".$result["mem_lname"];
                                        if($mem_id == $Advarr[$i]){
                                             echo "<option value=\"".$mem_id."\" selected>".$name."</option>";
                                        $i++;
                                        }
                                        else{
                                             echo "<option value=\"".$mem_id."\">".$name."</option>";
                                        }
                                    }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">วันที่การเข้าพบ</label>
                        <input class="form-control" type="text" id="VisitDate" name="VisitDate" value="<?php echo  date('d/m/Y', strtotime($topp_docdate)); ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control" type="text" name="Toppic" value="<?php echo $topp_topic ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">สรุปประเด็นคำปรึกษา</label>
                                <div id="Detail" name="Detail">
                                </div>
                    </div>
                  <div class="form-group">
                    <div id="upload_wrapper">

                <div class="row">
                    <div class="col-sm-12">
                        <span class="btn btn-success btn-block fileinput-button">
                            <i class="fa fa-fw fa-lg fa-cloud-upload"></i>
                            <span>Select files...</span>
                            <input id="fileupload" type="file" name="files[]" multiple>
                        </span>
                    </div>
                </div>
                
                <br>
                <br>
                <!-- The global progress bar -->
                <div id="progress" class="progress progress-striped active collapse">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <div class="row">
                    <div id="upload_status" class="col-xs-6 text-left"></div>
                    <div id="upload_speed" class="col-xs-6 text-right"></div>
                </div>
                <br>
                <br>
                <div id="uploads" class="collapse">
                  <div class="panel panel-default">
                      <!-- Default panel contents -->
                      <div class="panel-heading"><strong>Upload status</strong><span id="upload_count" class="badge pull-right"></span></div>
                      <!-- Table -->
                      <table id="file_list" class="table">
                        <tbody></tbody>
                      </table>
                    </div>
                </div>
            </div>
                  </div>

                <div class="form-group">
                    <button class="btn btn-primary icon-btn" type="submit" onclick="Save('W')"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                    &nbsp;&nbsp;&nbsp;<button class="btn btn-primary icon-btn" type="submit" onclick="Save('D')"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Draft</button>
                    &nbsp;&nbsp;&nbsp;<button class="btn btn-default icon-btn" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</button>
                </div>
                </form>
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
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="js/plugins/validator.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/summernote.js"></script>
    <script type="text/javascript" src="js/plugins/jquery.fileupload.js"></script>
    <script type="text/javascript" src="js/plugins/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="js/plugins/upload.js"></script>
    <script type="text/javascript" src="js/plugins/plugin/hello/summernote-ext-hello.js"></script>
    <script type="text/javascript">
        $('#Advisor').select2();
        $('#VisitDate').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            orientation: "bottom auto",
        }).datepicker();
        
         $('#Detail').summernote(
            {
                height: 200,
                minHeight: 200,
                maxHeight: 200,
                toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ]
            });
        
        var db_review_body = '<?php echo($topp_detail);?>';
        $('#Detail').summernote('code',db_review_body);
        
        function Save(sta) {
            var date = $("#VisitDate").val();
            var Advisorarr = $( "#Advisor" ).val() || [];
            var AdvisorValues = '';
            for(var i = 0; i < Advisorarr.length; i++)
                {
                    if(i > 0) AdvisorValues += " , ";
                     AdvisorValues += Advisorarr[i];
                }
            var DetailRaw = $("#Detail").summernote('code');
            var DetailVal = DetailRaw.replace(/&amp;/gi, "&");
            var DocID = "<?php echo($doc);?>";
            var datafrom = $("#form-info").serialize() + '&DID=' + DocID + '&Status=' + sta + '&Detail=' + DetailVal + '&AdvisorValues=' + AdvisorValues;
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "form-update.php",
                     success: function(result){
//                         alert(result);
                        $.notify({
                            title: "Save Success",
                            message: result,
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                        if(sta == "W"){
                            window.location.href = 'form-docinfo.php?doc='+result;
                        }
                     }
            });
        }
    </script>
  </body>
</html>
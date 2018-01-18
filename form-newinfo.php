<?php $title = "เพิ่มข้อมูลสมาชิก"; include 'header.php'; ?>
<?php $page = "Board"; include 'manu.php';?>

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
						<label class="control-label">อาจารย์ที่เข้าพบ  <span class="text-danger"><small>(สามารถเลือกอาจารย์ได้หลายท่าน)</small></span></label>
                        <select id="Advisor" class="js-example-basic-multiple js-states form-control"  multiple="multiple" style="width: 100%;">
                            <?php 
                            $stmtrepto = $conn->prepare("SELECT * FROM reportto WHERE rep_std_memid= ? ORDER BY rep_type ASC");
                            $stmtrepto->bind_param("s", $_SESSION['mem_id']);
                            $stmtrepto->execute();
                            $resultrepto = $stmtrepto->get_result();
                            $j = 0;
                            while($reptodata = $resultrepto->fetch_assoc()){
                                $advi[$j] = $reptodata['rep_teac_memid'];
                                $j++;
                            }
                            $stmtrepto->close();
                            $stmtadv = $conn->prepare("SELECT mem_id, mem_tname, mem_fname, mem_lname FROM member WHERE isdeleted = ? AND mem_type = 1");
                            $isdeleted = "0";   
                            $stmtadv->bind_param("s", $isdeleted);
                            $stmtadv->execute();
                            $resultadv = $stmtadv->get_result();
                            $i = 0 ;
                            while($advdata = $resultadv->fetch_assoc()){
                                $mem_id = $advdata["mem_id"];
                                $name = $advdata["mem_tname"]." ".$advdata["mem_fname"]." ".$advdata["mem_lname"];
                                if($mem_id == $advi[$i]){
                                    echo "<option value=\"".$mem_id."\" selected>".$name."</option>";
                                    $i++;
                                }else{
                                    echo "<option value=\"".$mem_id."\">".$name."</option>";
                                }
                            }
                            $stmtadv->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">วันที่การเข้าพบ</label>
                        <input class="form-control" type="text" id="VisitDate" name="VisitDate">
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control" type="text" id="Toppic" name="Toppic" >
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
                        <p id="msg"></p>
                        <span class="btn btn-success btn-block fileinput-button">
                            <i class="fa fa-fw fa-lg fa-cloud-upload"></i>
                            <span>Select files...</span>
                            <input id="fileupload" type="file" name="files[]" multiple="multiple">
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
                <div id="uploads" class="collapse">
                  <div class="panel panel-default">
                      <table id="file_list" class="table">
                        <tbody></tbody>
                      </table>
                    </div>
                </div>
            </div>
                  </div>

                <div class="form-group">
                    <button class="btn btn-primary icon-btn submit" type="submit" onclick="Save('W')"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                    &nbsp;&nbsp;&nbsp;<button class="btn btn-primary icon-btn submit" type="submit" onclick="Save('D')"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Draft</button>
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
        }).datepicker("setDate", new Date());
        
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
		$('#Detail').summernote('code',"");
        
        function Save(sta) {
            var date = $("#VisitDate").val();
            var Toppic = $("#Toppic").val();
            var Advisorarr = $( "#Advisor" ).val() || [];
            var AdvisorValues = '';
            for(var i = 0; i < Advisorarr.length; i++)
                {
                    if(i > 0) AdvisorValues += " , ";
                     AdvisorValues += Advisorarr[i];
                }
            var DetailVal = $("#Detail").summernote('code');
            var form_data = new FormData();
            var ins = document.getElementById('fileupload').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("files[]", document.getElementById('fileupload').files[x]);
            }
            form_data.append("VisitDate", date);
            form_data.append("Toppic", Toppic);
            form_data.append("Status", sta);
            form_data.append("Detail", DetailVal);
            form_data.append("AdvisorValues", AdvisorValues);
//            var datafrom = form_data + '&VisitDate=' + date + '&Toppic=' + Toppic + '&Status=' + sta + '&Detail=' + DetailVal + '&AdvisorValues=' + AdvisorValues;
            $.ajax({
                    data: form_data,
                    type: "post",
                    url: "form-insert.php",
                    dataType: 'text', // what to expect back from the PHP script
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result){
						alert(result);
                        $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                        if(sta == "W"){
                            window.location.href = 'form-docinfo.php?doc='+result;
                        }
                        else if(sta = "D"){
                            window.location.href = 'form-editinfo.php?doc='+result;
                        }
                    }
            });
      }
    </script>
  </body>
</html>
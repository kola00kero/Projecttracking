<?php $title = "เพิ่มข้อมูลสมาชิก"; include 'header.php'; ?>

<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->

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
                            <?php
                                $sqlrep = "SELECT * FROM reportto WHERE rep_std_memid='".$_SESSION['mem_id']."' ORDER BY rep_type ASC";
                                $queryrep = mysqli_query($conn,$sqlrep);
                                $j = 0;    
                                while($resultrep = mysqli_fetch_array($queryrep)){
                                    $advi[$j] = $resultrep['rep_teac_memid'];
                                    $j++;
                                 }
                                $sql = "SELECT mem_id, mem_tname, mem_fname, mem_lname FROM member WHERE isdeleted = 0 AND mem_type = 1";
                                $query = mysqli_query($conn,$sql);
                            ?>    
                        <label class="control-label">อาจารย์ที่เข้าพบ  <span class="text-danger"><small>(สามารถเลือกอาจารย์ได้หลายท่าน)</small></label>
                        <select id="Advisor" class="js-example-basic-multiple js-states form-control"  multiple="multiple" style="width: 100%;">
                                <?php 
                                        $i = 0 ;
                                        while($result = mysqli_fetch_array($query)) {
                                            $mem_id = $result["mem_id"];
                                            $name = $result["mem_tname"]." ".$result["mem_fname"]." ".$result["mem_lname"];
                                            if($mem_id == $advi[$i]){
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
<!--    <script type="text/javascript" src="js/plugins/upload.js"></script>-->
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
         
//        var upload_count = 0;
//        var done_count = 0;
        
//        $(function () {
//        'use strict';
//        $('#fileupload').fileupload({
//        dataType: 'json',
//        add: function (e, data) {
//            upload_count++;
//            if(data.files.length>0){
//                $("#uploads").show();
//                $("#upload_count").text(upload_count);
//                $.each(data.files, function (index, file) {
//                    var row = '<tr id="file_' + upload_count + '">' +
//                    '<td><span class="filename">' + file.name + '</span> ' +
//                    '<span class="pull-right"><small>' + formatFileSize(file.size) + '</small> ' +
//                    '<span class="process_status label label-warning"><span class="fa fa-fw fa-lg fa-cloud-upload"></span></span></span></td>' +
//                    '</tr>';
//                    $('#file_list tbody').append(row);
//                });
//            }
//            
//        },
//        done: function (e, data) {
//            if(data.result.files && data.result.files.length>0){
//                $.each(data.result.files, function (index, file) {
//                    var label = $('#file_' + file.id + ' td .label');
//                    label.removeClass('label-warning');
//                    if(file.error){
//                        console.log(file.error);
//                        label.addClass('label-danger');
//                        label.html('Failed');
//                    } else {
//                        $('#file_' + file.id + " .filename").html(file.name);
//                        label.addClass('label-success');
//                        label.html('<span class="fa fa-fw fa-lg fa-check-circle"></span>');
//                    }
//                    done_count++;
//                });
//                if(upload_count==done_count){
//                    $("#progress").removeClass('active');
//                    $("#progress").removeClass('progress-striped');
//                    $("#upload_status").text('Done!');
//                }
//            }else if(data.result.error){
//                $("#progress").removeClass('active');
//                $("#progress").removeClass('progress-striped');
//                $("#upload_status").text('Upload failed!');
//                var label = $('.process_status');
//                label.removeClass('label-warning');
//                label.addClass('label-danger');
//                label.html('<span class="fa fa-fw fa-lg fa-minus-circle"></span>');
//            }
//        },
//        start: function (e, data) {
//            $("#progress").show();
//        },
//        stop: function (e, data) {
//            $("#progress").hide();
//        },
//        progressall: function (e, data) {
//            var progress = parseInt(data.loaded / data.total * 100, 10);
//            $('#progress .progress-bar').css(
//                'width',
//                progress + '%'
//            );
//            $("#upload_progress").text(progress + '%');
//            if(data.loaded < data.total){
//                $("#upload_speed").text(formatBitrate(data.bitrate));
//            }
//        }
//        }).prop('disabled', !$.support.fileInput)
//        .parent().addClass($.support.fileInput ? undefined : 'disabled');
//        });
        
//         $('.submit').on('click', function () {
//                    var form_data = new FormData();
//                    var ins = document.getElementById('fileupload').files.length;
//                    for (var x = 0; x < ins; x++) {
//                        form_data.append("files[]", document.getElementById('fileupload').files[x]);
//                    }
//                    $.ajax({
//                        url: 'upload_file.php', // point to server-side PHP script 
//                        dataType: 'text', // what to expect back from the PHP script
//                        cache: false,
//                        contentType: false,
//                        processData: false,
//                        data: form_data,
//                        type: 'post',
//                        success: function (response) {
//                            $('#msg').html(response); // display success response from the PHP script
//                        },
//                        error: function (response) {
//                            $('#msg').html(response); // display error response from the PHP script
//                        }
//                    });
//            });
        
        
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
            var datafrom = form_data + '&VisitDate=' + date + '&Toppic' + Toppic + '&Status=' + sta + '&Detail=' + DetailVal + '&AdvisorValues=' + AdvisorValues;
            $.ajax({
                    data: form_data,
                    type: "post",
                    url: "form-insert.php",
                    dataType: 'text', // what to expect back from the PHP script
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result){
//                         alert(result);
                        $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                        if(sta = "W"){
                            window.location.href = 'form-docinfo.php?doc='+result;
                        }
                        else if(sta = "D"){
                            window.location.href = 'form-docinfo.php?doc='+result;
                        }
                    }
            });
      }
    </script>
  </body>
</html>
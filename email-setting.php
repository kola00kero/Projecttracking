<?php $title = "ตั้งค่าการส่ง E-mail"; include 'header.php'; ?>

<?php $page = "Board"; include 'manu.php';?>

    <div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-edit"></i>ตั้งค่าการส่ง E-mail</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
            <div class="card">
                <div class="card-body">
                <form id="form-info" onsubmit="return false" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label">Host</label>
                        <input class="form-control" type="text" >
                    </div>
                    <div class="form-group">
                        <label class="control-label">Port</label>
                        <input class="form-control" type="text" >
                    </div>
                    <div class="form-group">
                    <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">Use Secure Sockets Layer (SSL)</label>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox"><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">SMTP Authentication </label>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox"><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input class="form-control" type="text" >
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input class="form-control" type="password" >
                    </div>
                <div class="form-group">
                    <button class="btn btn-primary icon-btn submit" type="submit" onclick="Save()"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary icon-btn submit" type="submit" onclick="TestConn()"><i class="fa fa-fw fa-lg fa-paper-plane"></i>TestConnetion</button>
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
	<script src="js/plugins/validator.js"></script>
    <script src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript"> 
        function Save() {
            var datafrom = $("#form-info").serialize();
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "savemail.php",
                     success: function(result){
                        $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                     }
            });
        }
        function TestConn(){
            var datafrom = $("#form-info").serialize();
            $.ajax({
                     data: datafrom,
                     type: "post",
                     url: "sendemail.php",
                     success: function(result){
                        $.notify({
                            title: "Save Success",
                            message: " ",
                            icon: "fa fa-check", 
                        },{
                            type: "success"
                        });
                     }
            });
        }
    </script>
  </body>
</html>
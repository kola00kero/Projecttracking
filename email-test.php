<html>
<head>
<title>PHP Sending Email</title>
</head>
<body>

    <p>Send From :</p><input type="text" id="EmailFrom" />
    <p>Send To :</p><input type="text" id="EmailTo" />
    <p></p>
   <button id="Sendmail" >SEND</button>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
        $(document).on('click','#Sendmail',function(e) {
            var sdto = $("#EmailTo").val();
            var sdfr = $("#EmailFrom").val();
            $.ajax({
                     data: { SendTo: sdto, SendFr: sdfr},
                     type: "post",
                     url: "email-send.php",
                     success: function(data){                     
                         alert(data);
                     }
            });
        });
    </script>

</body>
</html>

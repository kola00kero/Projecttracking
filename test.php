<html>
<head>
<title>PHP Sending Email</title>
</head>
<body>

    <p>Send From :</p><input type="text" id="EmailFrom" />
    <p>Send To :</p><input type="text" id="EmailTo" />
    <p></p>
    <input type="button" id="Sendmail" value="SEND"/>
    
    <script type="text/javascript">
        $(document).on('click','#Sendmail',function(e) {
            var sdto = $("#EmailFrom").val();
            var sdfr = $("#EmailTo").val();
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
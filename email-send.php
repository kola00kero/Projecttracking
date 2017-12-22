<?php
    $SendTo=$_POST['SendTo'];
    $SendFr=$_POST['SendFr'];
    $SendFcc = "";

    $to = $SendTo;
    $headers ="Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: ".$SendFr. "\r\n" .
    "CC: ".$SendFcc;
    $subject = "Test Send Email";
    $txt = "<h1>ทกสอบการส่ง email จากระบบติดตามงาน</h1>";

    $flgSend = mail($to,$subject,$txt,$headers);  // @ = No Show Error //
	if($flgSend)
	{
		echo "Email Sending.";
	}
	else
	{
		echo "Email Can Not Send.";
	}


?>
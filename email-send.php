<?php
function Sendmail($SendTo, $SendFr, $subject, $message) {
    $headers = $SendFr;
    $subjectUTF = "=?UTF-8?B?".base64_encode($subject)."?=";
    $flgSend = mail($SendTo,$subjectUTF,null,$headers);   // @ = No Show Error //
    
	if($flgSend)
	{
		return "Email Sending.";
	}
	else
	{
		return "Email Can Not Send.";
	}
}
?>
<?php
session_start();
include("connect.php");
include("email-send.php");
?>
<?php 
$VisitDate = $_POST['VisitDate'];
$myDateTime = DateTime::createFromFormat('d/m/Y', $VisitDate);
$newVisitDate = $myDateTime->format('Y/m/d');
$Advisor = $_POST['AdvisorValues'];
$Title = $_POST['Toppic'];
$Detail = str_replace ( array ('"', "'"), array ('&quot;', '&apos;' ),$_POST['Detail']); 
$Modifedby = $_SESSION['mem_id'];
$id = json_decode(base64_decode($_POST["DID"]));
$status = $_POST["Status"];

$flax = FALSE;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn->autocommit(FALSE); //turn on transactions
    $stmt = $conn->prepare("UPDATE toppic SET topp_docdate = ? , topp_advi = ? , topp_topic= ? , topp_detail= ? , topp_approvestartus = ? , topp_modifedby = ? ,topp_modifeddate = NOW() ,LastUpdate = NOW()
    WHERE topp_id= ? ");
    $stmt->bind_param("sssssss", $newVisitDate, $Advisor, $Title, $Detail, $status, $Modifedby, $id);
    $stmt->execute();
    $stmt->close();
    if($conn->autocommit(TRUE)){
        $flax = TRUE;   
    }
} catch (Exception $e) {
    $conn->rollback(); //remove all queries from queue if error (undo)
    echo $e; //use in development
    error_log($e); //use in production
}

if ($flax == TRUE) {
    
	if (isset($_FILES['files']) && !empty($_FILES['files'])) {
    mkdir("server/uploads/".$id, 0700);
    $target_dir = "server/uploads/".$id."/";
    $no_files = count($_FILES["files"]['name']);
        
        for ($i = 0; $i < $no_files; $i++) {
            if ($_FILES["files"]["error"][$i] > 0) {
                echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
            } else {
                if (file_exists($target_dir . $_FILES["files"]["name"][$i])) {
                    $filename  = basename($_FILES['file']['name']);
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $filenew       = $filename.'.'.$extension;
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_dir . $filenew);
                } else {
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_dir . $_FILES["files"]["name"][$i]);
                }
            }
        }
    }
	
    $Advarr = explode(" , ", $Advisor);
    $adviser = "";
    for($i = 0; $i < count($Advarr); $i++)
    {
        if($i != 0)
        {
            $adviser .= ",";
        }
        $stmtdocAdv = $conn->prepare("SELECT * FROM member WHERE mem_id = ?");
        $stmtdocAdv->bind_param("s", $Advarr[$i]);
        $stmtdocAdv->execute();
        $resultdocAdv = $stmtdocAdv->get_result();
        while($docAdvdata = $resultdocAdv->fetch_assoc()){
            $adviser .= $docAdvdata["mem_email"];
        }
    }
    $stmtdocAdv->close();
    
    $SendTo = $adviser;
    $subject = "[แก้ไข] บันทึกการเข้าพบอาจารย์ หัวข้อ".$_POST['Toppic'];
    $message = "<body><div id='site_content'><div class='col-md-12'>
                    <div>
                        <h3 class='title'>หัวข้อ : ".$_POST['Toppic']."</h3>
                    </div>
					<p>โดย : ".$_SESSION['mem_fullname']."</p>
                    <p>อาจารย์ที่เข้าพบ : ".$adviser."</p>
				    <p>วันที่เข้าพบ : ".date("M/d/Y", strtotime($newVisitDate))."</p>
                    <p>สรุปประเด็นคำปรึกษา</p>
                    <div>".$_POST['Detail']."</div>
                </div></div></body>";
                
    //*** Uniqid Session ***//
	$strSid = md5(uniqid(time()));
	
	$SendFr = "";
    $SendFr .= "From: ".$_SESSION["mem_address"]."\r\n";
	
	$SendFr .= "MIME-Version: 1.0\n";
	$SendFr .= "Content-Type: multipart/mixed; boundary=\"".$strSid."\"\n\n";
	$SendFr .= "This is a multi-part message in MIME format.\n";

	$SendFr .= "--".$strSid."\n";
	$SendFr .= "Content-type: text/html; charset=UTF-8\n";
	$SendFr .= "Content-Transfer-Encoding: 7bit\n\n";
	$SendFr .= $message."\n\n";

    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
    $no_files = count($_FILES["files"]['name']);
        for ($i = 0; $i < $no_files; $i++) {
            $filename  = basename($_FILES['file']['name']);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $filenew   = $filename.'.'.$extension;
            
            $strFilesName = $filenew;
            $strContent = chunk_split(base64_encode(file_get_contents($strFilesName)));
            $SendFr .= "--".$strSid."\n";
            $SendFr .= "Content-Type: application/octet-stream; name=\"".$strFilesName."\"\n";
            $SendFr .= "Content-Transfer-Encoding: base64\n";
            $SendFr .= "Content-Disposition: attachment; filename=\"".$strFilesName."\"\n\n";
            $SendFr .= $strContent."\n\n";
        }
    }
    
    $send = Sendmail($SendTo, $SendFr, $subject, $message);
    
    echo base64_encode(json_encode($id));
}
?>


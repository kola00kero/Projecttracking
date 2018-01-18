<?php
session_start();
include("connect.php");
include("email-send.php");
$Comment = str_replace ( array ('"', "'"), array ('&quot;', '&apos;'),$_POST['Comment']); 
$comId = $_POST['comId'];
$Modifedby = $_SESSION['mem_id'];
$DocId = $_POST['Docid'];
$flax = FALSE;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn->autocommit(FALSE); //turn on transactions
    $stmt1 = $conn->prepare("UPDATE comment SET comm_detail = ? , comm_modifedby = ? ,comm_modifeddate = NOW() WHERE comm_id= ? ");
    $stmt1->bind_param("sss", $Comment, $Modifedby ,$comId);
    $stmt1->execute();
    $stmt2 = $conn->prepare("UPDATE toppic SET LastUpdate = NOW() WHERE topp_id= ? ");
    $stmt2->bind_param("s", $DocId);
    $stmt2->execute();
    $stmt2->close();
    $stmt1->close();
    if($conn->autocommit(TRUE)){
        $flax = TRUE;   
    }
} catch (Exception $e) {
    $conn->rollback(); //remove all queries from queue if error (undo)
    echo $e; //use in development
    error_log($e); //use in production
}

if ($flax == TRUE) {
    $stmttopp = $conn->prepare("SELECT * FROM toppic WHERE topp_id = ?");
    $stmttopp->bind_param("s", $DocId);
    $stmttopp->execute();
    $resulttopp = $stmttopp->get_result();
    if($toppdata = $resulttopp->fetch_assoc()){
        $topp_topic = $toppdata['topp_topic']; 
        $topp_advi = $toppdata['topp_advi'];
        $topp_advi .= " , ".$toppdata['topp_createdby'];
    }
    $stmttopp->close();
    $Advarr = explode(" , ", $topp_advi);
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
    $stmtComm = $conn->prepare("SELECT * FROM comment WHERE isdeleted=0 and comm_topid = ? ORDER BY comm_liston ASC");
            $stmtComm->bind_param("s", $doc);
            $stmtComm->execute();
            $resultComm = $stmtComm->get_result();
            if($Commdata = $resultComm->fetch_assoc()){
                $listno = $Commdata['comm_liston'];
            }
    $stmtComm->close();
    $SendTo = $adviser;
    $SendFr = $_SESSION["mem_address"];
    $subject = "[แก้ไข] มีความคิดเห็นที่".$listno." หัวข้อ ".$topp_topic;
    $message = "<body><div id='site_content'><div class='col-md-12'>
                    <h5 class='card-title'>ความคิดเห็นที่ ".$listno."</h5>
                        ".$_POST['Comment']."
                        <small>Comment by ".$_SESSION["mem_fullname"]." on <cite title='Date'>".date("M/d/Y H:m:s")."</cite></small>   
                </div></div></body>";
    
    $send = Sendmail($SendTo, $SendFr, $subject, $message);
    
    
    echo $Comment;
}
?>


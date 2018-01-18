<?php
session_start();
include("connect.php");
include("email-send.php");
?>
<?php 
$Comment = str_replace ( array ('"', "'"), array ('&quot;', '&apos;'),$_POST['Comment']); 
$DocId = $_POST['Docid'];
$Createdby = $_SESSION['mem_id'];


$sql = "SELECT UUID() as id";
$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($query);
$id =  $result["id"];

$stmtlist = $conn->prepare("SELECT * FROM comment WHERE comm_topid = ? ORDER BY comm_liston DESC");
$stmtlist->bind_param("s", $DocId);
$stmtlist->execute();
$resultlist = $stmtlist->get_result();
if($listdata = $resultlist->fetch_assoc()){
    $listno = $listdata["comm_liston"] + 1;
}
else
{
    $listno = 1;
}

$flax = FALSE;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn->autocommit(FALSE); //turn on transactions
    $stmt1 = $conn->prepare("INSERT INTO comment(comm_id, comm_topid, comm_detail, comm_liston, comm_createdby, comm_createddate) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt1->bind_param("sssis", $id, $DocId, $Comment, $listno, $Createdby);
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
    
    $SendTo = $adviser;
    $SendFr = $_SESSION["mem_address"];
    $subject = "มีความคิดเห็นใหม่ หัวข้อ".$topp_topic;
    $message = "<body><div id='site_content'><div class='col-md-12'>
                    <h5 class='card-title'>ความคิดเห็นที่ ".$listno."</h5>
                        ".$_POST['Comment']."
                        <small>Comment by ".$_SESSION["mem_fullname"]." on <cite title='Date'>".date("M/d/Y H:m:s")."</cite></small>   
                </div></div></body>";
    
    $send = Sendmail($SendTo, $SendFr, $subject, $message);
    
    echo base64_encode(json_encode($DocId));
}


?>


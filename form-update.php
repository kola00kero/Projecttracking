<?php
session_start();
include("connect.php");
?>
<?php 
$VisitDate = $_POST['VisitDate'];
$myDateTime = DateTime::createFromFormat('d/m/Y', $VisitDate);
$newVisitDate = $myDateTime->format('Y/m/d');
$Advisor = $_POST['AdvisorValues'];
$Title = $_POST['Toppic'];
//$Detail = str_replace (,$_POST['Detail'])
$Detail = str_replace ( array ('&','"', "'"), array ('&amp;','&quot;', '&apos;' ),$_POST['Detail']); 
//$Detail = $_POST['Detail'];
$Modifedby = $_SESSION['mem_id'];
$id = $_POST["DID"];
$status = $_POST["Status"];

$sql = "UPDATE toppic SET topp_docdate ='$newVisitDate', topp_advi ='$Advisor', topp_topic='$Title', topp_detail='$Detail', topp_approvestartus = '$status', topp_modifedby ='$Modifedby',topp_modifeddate = NOW()
WHERE topp_id='$id'";
//echo $sql
if (mysqli_query($conn,$sql) === TRUE) {
    echo base64_encode(json_encode($id));
}
?>


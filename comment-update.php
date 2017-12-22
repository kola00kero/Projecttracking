<?php
session_start();
include("connect.php");
$Comment = str_replace ( array ( '&', '"', "'"), array ( '&amp;' , '&quot;', '&apos;' ),$_POST['Comment']); 
//$Comment = $_POST['Comment'];
$comId = $_POST['comId'];
$Modifedby = $_SESSION['mem_id'];


$sql = "UPDATE comment SET comm_detail ='$Comment', comm_modifedby ='$Modifedby',comm_modifeddate = NOW()
WHERE comm_id='$comId'";

//echo $sql
if (mysqli_query($conn,$sql) === TRUE) {
    echo $Comment;
}
?>


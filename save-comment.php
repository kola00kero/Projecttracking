
<?php
session_start();
include("connect.php");
?>
<?php 
$Comment = $_POST['Comment'];
$DocId = $_POST['Docid'];
$Createdby = $_SESSION['mem_id'];

$sql = "SELECT UUID() as id";
$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($query);
$id =  $result["id"];

$sql = "SELECT * FROM comment WHERE comm_topid='".$DocId."'";
$query = mysqli_query($conn,$sql);
$listno = 1;
while($result = mysqli_fetch_array($query))
{
    $listno ++;
}

$sql = "INSERT INTO comment(comm_id, comm_topid, comm_detail, comm_liston, comm_createdby, comm_createddate) 
VALUES ('$id', '$DocId', '$Comment', '$listno', '$Createdby', NOW())";

if (mysqli_query($conn,$sql) === TRUE) {
    echo base64_encode(json_encode($DocId));
}
?>


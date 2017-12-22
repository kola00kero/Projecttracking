<?php
session_start();
include("connect.php");
?>
<?php 
$comm = $_POST['commhid'];

$sql = "SELECT * FROM comment WHERE isdeleted=0 and comm_id='".$comm."'";
$query = mysqli_query($conn,$sql);
$result2 = mysqli_fetch_array($query);
    echo json_encode(array('commID' => $comm, 'commdetail' => $result2["comm_detail"]));
?>

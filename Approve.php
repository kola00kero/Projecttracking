<?php
session_start();
include("connect.php");
?>
<?php 
$id = $_POST["DID"];
$status = $_POST["Status"];

$sql = "UPDATE toppic SET topp_approvestartus = '$status' WHERE topp_id='$id'";

if (mysqli_query($conn,$sql) === TRUE) {
    echo base64_encode(json_encode($id));
}
?>


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
$Detail = $_POST['Detail'];
$Createdby = $_SESSION['mem_id'];

$sql = "SELECT UUID() as id";
$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($query);
$id =  $result["id"];

$sql = "INSERT INTO Toppic
(topp_id, topp_docdate, topp_advi, topp_topic, topp_detail, topp_approvestartus, topp_createdby, topp_createddate) 
VALUES 
('$id', '$newVisitDate', '$Advisor','$Title', '$Detail', 'W', '$Createdby', NOW())";

if (mysqli_query($conn,$sql) === TRUE) {
    echo $id;
}
?>


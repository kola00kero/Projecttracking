<?php
session_start();
include("connect.php");
?>
<?php 
$comm = $_POST['commhid'];
$stmt = mysqli_prepare($conn, "SELECT * FROM comment WHERE isdeleted=0 and comm_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $comm);
    $stmt->execute();
    $result = $stmt->get_result();
    if($data = $result->fetch_assoc()){
        echo json_encode(array('commID' => $comm, 'commdetail' => $data["comm_detail"]));
    }
$stmt->close();
?>

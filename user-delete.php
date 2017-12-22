<?php
include("connect.php");
$userID = $_POST['userID'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn->autocommit(FALSE); //turn on transactions
    $stmtdel = $conn->prepare("UPDATE member SET Isdeleted = '1' WHERE mem_id = ?");
    $stmtdel->bind_param("s", $userID);
    $stmtdel->execute();
    $stmtdel->close();
    if($conn->autocommit(TRUE)){
        echo "1";  
    }
} catch (Exception $e) {
    $conn->rollback(); //remove all queries from queue if error (undo)
    echo $e; //use in development
    error_log($e); //use in production
}


   

//$sql = "UPDATE member SET Isdeleted = '1' WHERE mem_id = '$userID'";
//$result = mysqli_query($conn,$sql);
//$num_rows = mysqli_affected_rows($conn);
//if($num_rows > 0)
//{
//    echo "1";
//}else{
//    echo "0";
//}
?>
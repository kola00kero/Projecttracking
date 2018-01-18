<?php
session_start();
include("connect.php");
include("EnDeCode.php");

$memid=$_POST['UID'];
$user=$_POST['username'];
$pw=$_POST['password'];
$cfpassword=$_POST['cfpassword'];
$usertype=$_POST['usertype'];
$code=$_POST['code'];  
$tname=$_POST['tname'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$address=$_POST['address'];
$email=$_POST['email'];
$mobileno=$_POST['mobileno'];
$MainAdvisor = $_POST['MainAdvisor'];
$OtherAdvisor = $_POST['OtherAdvisor'];
$OtherAdvarr = explode(" , ", $OtherAdvisor);
$hidseladvi = $_POST['hidseladvi'];
$flax = FALSE;

$pw = encryptIt($pw);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn->autocommit(FALSE); //turn on transactions
    $stmt1 = $conn->prepare("UPDATE member SET mem_code = ?, mem_username = ?, mem_password = ?, mem_type = ?, mem_tname = ?, mem_fname = ?, mem_lname = ?, mem_address = ?, mem_email = ?, mem_phone = ? WHERE mem_id = ?");
    $stmt1->bind_param("sssisssssss", $code, $user, $pw, $usertype, $tname, $fname, $lname, $address, $email, $mobileno, $memid);
    $stmt1->execute();
    if($usertype == 2){
        $stmtdel = $conn->prepare("DELETE FROM reportto WHERE rep_std_memid = ?");
        $stmtdel->bind_param("s", $memid);
        $stmtdel->execute();
        
        $stmt2 = $conn->prepare("INSERT INTO reportto (rep_id, rep_std_memid, rep_teac_memid, rep_type) VALUES ((SELECT UUID()), ?, ?, 0 )");
        $stmt2->bind_param("ss",$memid,$MainAdvisor);
        $stmt2->execute();
        
        $stmt3 = $conn->prepare("INSERT INTO reportto (rep_id, rep_std_memid, rep_teac_memid, rep_type) VALUES ((SELECT UUID()), ?, ?, 1 )");
        for($i = 0; $i < count($OtherAdvarr); $i++)
        {
            $stmt3->bind_param("ss",$memid,$OtherAdvarr[$i]);
            $stmt3->execute();
        }
        $stmtdel->close();
        $stmt2->close();
        $stmt3->close();
    }
    $stmt1->close();
    if($conn->autocommit(TRUE)){
        $flax = TRUE;   
    }
} catch(Exception $e) {
  $conn->rollback(); //remove all queries from queue if error (undo)
  echo $e; //use in development
  error_log($e); //use in production
}

if($flax == TRUE)
{
    echo base64_encode(json_encode($memid));
}

//$sql = "UPDATE member SET mem_code='$code', mem_username='$user', mem_password='$pw', mem_type='$usertype', mem_tname='$tname', mem_fname='$fname', mem_lname='$lname', mem_address='$address', mem_email='$email', mem_phone='$mobileno' WHERE mem_id='$memid'";

//if (mysqli_query($conn,$sql) === TRUE) {
//    $flax = TRUE;
//    if($hidseladvi == "TRUE"){
//        if($usertype == 2){
//            $sqldel = "DELETE FROM reportto WHERE rep_std_memid='".$memid."'";
//            mysqli_query($conn,$sqldel);
//            $sql2 = "INSERT INTO reportto (rep_id, rep_std_memid, rep_teac_memid, rep_type) VALUES ((SELECT UUID()), '$memid', '$MainAdvisor', 0 )";
//            mysqli_query($conn,$sql2);
//            for($i = 0; $i < count($OtherAdvarr); $i++)
//                {
//                    $sql3 = "INSERT INTO reportto (rep_id, rep_std_memid, rep_teac_memid, rep_type) VALUES ((SELECT UUID()), '$memid', '$OtherAdvarr[$i]', 1 )";
//                    mysqli_query($conn,$sql3);
//
//                }
//        }
//    }
//}



?>
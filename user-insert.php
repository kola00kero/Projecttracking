<?php
session_start();
include("connect.php");
include("EnDeCode.php");

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

$sql = "SELECT UUID() as newid";
$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($query);
$newid =  $result["newid"];

$flax = FALSE;
$pw = encryptIt($pw);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn->autocommit(FALSE); //turn on transactions
    $stmt1 = $conn->prepare("INSERT INTO member (mem_id, mem_code, mem_username, mem_password, mem_type, mem_tname, mem_fname, mem_lname, mem_address, mem_email, mem_phone) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssissssss", $newid, $code, $user, $pw, $usertype, $tname, $fname, $lname, $address, $email, $mobileno);
    $stmt1->execute();
    if($usertype == 2){
        $stmt2 = $conn->prepare("INSERT INTO reportto (rep_id, rep_std_memid, rep_teac_memid, rep_type) VALUES ((SELECT UUID()), ?, ?, 0 )");
        $stmt2->bind_param("ss",$newid,$MainAdvisor);

        $stmt2->execute();
        $stmt3 = $conn->prepare("INSERT INTO reportto (rep_id, rep_std_memid, rep_teac_memid, rep_type) VALUES ((SELECT UUID()), ?, ?, 1 )");
        for($i = 0; $i < count($OtherAdvarr); $i++)
        {
            $stmt3->bind_param("ss",$newid,$OtherAdvarr[$i]);
            $stmt3->execute();
        }
        $stmt2->close();
        $stmt3->close();
    }
    $stmt1->close();
    if($conn->autocommit(TRUE)){
        $flax = TRUE;   
    }
} catch (Exception $e) {
    $conn->rollback(); //remove all queries from queue if error (undo)
    echo $e; //use in development
    error_log($e); //use in production
}
if($flax == TRUE)
{
//	
//	$SendTo = $_POST['address'];
//    $subject = "แจ้ง ชื่อผู้ใช้และรหัสผ่าน ของระบบติดตามความคืบหน้าวิทยานิพนธ์";
//    $message = "<body><div id='site_content'><div class='col-md-12'>
//                    <div>
//                        <h3 class='title'>หัวข้อ : ".$_POST['Toppic']."</h3>
//                    </div>
//					<p>โดย : ".$_SESSION['mem_fullname']."</p>
//                    <p>อาจารย์ที่เข้าพบ : ".$adviser."</p>
//				    <p>วันที่เข้าพบ : ".date("M/d/Y", strtotime($newVisitDate))."</p>
//                    <p>สรุปประเด็นคำปรึกษา</p>
//                    <div>".$_POST['Detail']."</div>
//                </div></div></body>";
//
//    
//    $send = Sendmail($SendTo, $SendFr, $subject, $message);
	
    echo base64_encode(json_encode($newid));
}

?>
<?php
	session_start();
	include("connect.php");
    include("EnDeCode.php");
	$user=$_POST['user'];
	$pw=$_POST['pw'];

    $pw = encryptIt($pw);

    if ($stmt = mysqli_prepare($conn, "SELECT * FROM member WHERE mem_username=? AND mem_password=?")) {

        /* bind parameters for markers */
        mysqli_stmt_bind_param($stmt, "ss", $user,$pw);
        $stmt->execute();
        $result = $stmt->get_result();
        if($resultdata = $result->fetch_assoc()){
            
            $stmtlog = $conn->prepare("UPDATE member SET mem_lastogin = (SELECT now()) WHERE mem_id = ?");
            $stmtlog->bind_param("s", $resultdata['mem_id']);
            $stmtlog->execute();
            $stmtlog->close();
            
            $_SESSION["login"] = 1;
            $_SESSION["mem_id"] = $resultdata['mem_id'];
            $_SESSION["mem_username"] = $resultdata['mem_username'];
            $_SESSION["mem_password"] = $resultdata['mem_password'];
            $_SESSION["mem_fullname"] = $resultdata["mem_tname"]." ".$resultdata["mem_fname"]." ".$resultdata["mem_lname"];
            $_SESSION["mem_type"] = $resultdata['mem_type'];
            $_SESSION["mem_email"] = $resultdata['mem_email'];
            echo "true";
        }else{
            echo "false";
        }
        mysqli_stmt_close($stmt);
    }



//	$sql = "SELECT * FROM member WHERE mem_username = '".$user."' and mem_password = '".$pw."'";
//	$query = mysqli_query($conn,$sql);
//	$result = mysqli_fetch_array($query);
//	if(!$result)
//	{
//		echo "<script language=\"javascript\" type=\"text/javascript\">
//			     alert('ชื่อผู้ใช้ หรือหรัสผ่าน ไม่ถูกต้อง โปรดลองใหม่อีกครั้ง');
//			     window.location = \"login.php\";
//		      </script>";
//	}
//	else
//	{
//		$_SESSION["login"]	 = 1;
//        $_SESSION["mem_id"] = $result["mem_id"];
//        $_SESSION["mem_username"] = $result["mem_username"];
//        $_SESSION["mem_password"] = $result["mem_password"];
//        $_SESSION["mem_type"] = $result["mem_type"];
//        echo "<script language=\"javascript\" type=\"text/javascript\">
//			     window.location = \"index.php\";
//			 </script>";
//        session_write_close();		
//	}
//	mysql_close();
?>

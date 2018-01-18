<?php
	session_start();
	include("connect.php");
    include("EnDeCode.php");
    include("ldap_authen.php");
	$user=$_POST['user'];
	$pw=$_POST['pw'];

    function check_password_db($conn,$user,$pw) {
        $pw_encrypt = encryptIt($pw);
        $authen = false;
        if ($stmt = mysqli_prepare($conn, "SELECT * FROM member WHERE mem_username=? AND mem_password=?")) {
            mysqli_stmt_bind_param($stmt, "ss", $user,$pw_encrypt);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0)
                $authen = true;
            mysqli_stmt_close($stmt);
        }
        return $authen;
    }

    function check_password_ldap($user,$pw) {
        return ldap_authen_ku_bkn($user,$pw);
    }

    if (check_password_db($conn,$user,$pw) || check_password_ldap($user,$pw)) {
        if ($stmt = mysqli_prepare($conn, "SELECT * FROM member WHERE mem_username=?")) {

            /* bind parameters for markers */
            mysqli_stmt_bind_param($stmt, "s", $user);
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
    }
    else {
        echo "false";
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

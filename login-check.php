<?php
session_start();
include("connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
<title>Untitled Document</title>

</head>

<body>
<?php 

echo "Username : ".$user=$_POST['user']; echo "<br>";
echo "Password : ".$pw=$_POST['pw']; echo "<br>";

//$sql = "SELECT * FROM users WHERE user_id=\"$user\" and user_pw=\"$pw\"";
//$result = mysql_query($sql);
//$num_rows = mysql_num_rows($result);
//$row=mysql_fetch_array($result);
//$type=$row['user_type'];
//	
//if($num_rows==1) {	
//  	if($type==1)
//    	{ $_SESSION['login'] = 1; header("location:staff_home.php?user=$user"); }
//  	else if($type==2)
//    	{ $_SESSION['login'] = 2; header("location:staff_home.php?user=$user"); }
//	else if($type==3)
//		{ $_SESSION['login'] = 3; header("location:staff_home.php?user=$user"); }
//}
//else {
//	echo "<script language=\"javascript\" type=\"text/javascript\">
//			alert('ชื่อผู้ใช้ หรือหรัสผ่าน ไม่ถูกต้อง โปรดลองใหม่อีกครั้ง');
//			window.location = \"login_staff.php\";
//		  </script>";
//}

/*$sql = "SELECT * FROM users";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)) {
	$user=$row['user_id'];
	$pw=$row['user_pw'];
	$type=$row['user_type'];
	$id=$row['emp_id'];  
	echo "<br>Username : ".$user."<br>";
	echo "Password : ".$pw."<br>";
	echo "User Type : ".$type."<br>";	
	echo "EmployeeID : ".$id."<br>";			   
} */
?>

</body>
</html>
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

echo "Username : ".$username=$_POST['username']; echo "<br>";
echo "Password : ".$password=$_POST['password']; echo "<br>";
echo "Confirm password : ".$cfpassword=$_POST['cfpassword']; echo "<br>";
$usertype=$_POST['usertype'];
if($usertype=="0") echo "User type : Admin<br>";
else if($usertype=="1") echo "User type : Teacher<br>";
else if($usertype=="2") echo "User type : Student<br>";
echo "Code : ".$code=$_POST['code']; echo "<br>";   
echo "Title name : ".$tname=$_POST['tname']; echo "<br>";
echo "First name : ".$fname=$_POST['fname']; echo "<br>";
echo "Last name : ".$lname=$_POST['lname']; echo "<br>";
echo "Address : ".$address=$_POST['address']; echo "<br>";
echo "E-mail : ".$email=$_POST['email']; echo "<br>";
echo "Mobile no. : ".$mobileno=$_POST['mobileno']; echo "<br>";

//$sql = "SELECT * FROM member WHERE mem_username=\"$user\" and mem_password=\"$pw\"";
//$result = mysqli_query($conn,$sql);
//$num_rows = mysqli_num_rows($result);
//$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//$type=$row['mem_startus'];

?>

</body>
</html>
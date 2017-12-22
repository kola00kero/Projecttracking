<?php
	session_start();
    include("connect.php");
    if($_SESSION['login']!=1){ 
	header("location:login.php"); 
    }
    $user=$_SESSION["mem_username"];
    $sql = "SELECT mem_fname, mem_lname FROM member WHERE mem_username = '".$user."'";

    $query = mysqli_query($conn,$sql);
    $result = mysqli_fetch_array($query);
    $name = $result["mem_fname"]." ".$result["mem_lname"];
    if ($_SESSION["mem_type"]==0){$type= "ผู้ดูแลระบบ";}
    else if ($_SESSION["mem_type"]==1){$type= "อาจารย์";}
    else if ($_SESSION["mem_type"]==2){$type= "นักศึกษา";}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/summernote.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?php echo $title; ?></title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>

<?php 
$servername = '158.108.34.31';
$username = 'sukationg';
$password = '5t4r3e2w1q';
$database = 'projecttracking';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);
//$conn = mysqli_connect($hostname,$username,$password,$database) or die("cannot connect DB");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$conn -> set_charset("utf8");
?>
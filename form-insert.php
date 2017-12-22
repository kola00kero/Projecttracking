<?php
session_start();
include("connect.php");
?>
<?php 
$VisitDate = $_POST['VisitDate'];
$myDateTime = DateTime::createFromFormat('d/m/Y', $VisitDate);
$newVisitDate = $myDateTime->format('Y/m/d');
$Advisor = $_POST['AdvisorValues'];
$Title = $_POST['Toppic'];
$Detail = str_replace ( array ( '&', '"', "'"), array ( '&amp;' , '&quot;', '&apos;' ),$_POST['Detail']); 
//$Detail = $_POST['Detail'];
$Createdby = $_SESSION['mem_id'];
$status = $_POST["Status"];

$sql = "SELECT UUID() as id";
$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($query);
$id =  $result["id"];

$sql = "INSERT INTO toppic
(topp_id, topp_docdate, topp_advi, topp_topic, topp_detail, topp_approvestartus, topp_createdby, topp_createddate) 
VALUES 
('$id', '$newVisitDate', '$Advisor','$Title', '$Detail', '$status', '$Createdby', NOW())";

    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
    mkdir("server/uploads/".$id, 0700);
    $target_dir = "server/uploads/".$id."/";
    $no_files = count($_FILES["files"]['name']);
        
        for ($i = 0; $i < $no_files; $i++) {
            if ($_FILES["files"]["error"][$i] > 0) {
                echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
            } else {
                if (file_exists($target_dir . $_FILES["files"]["name"][$i])) {
                    $filename  = basename($_FILES['file']['name']);
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $filenew       = $filename.'.'.$extension;
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_dir . $filenew);
                } else {
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_dir . $_FILES["files"]["name"][$i]);
                }
            }
        }
    }
    
if (mysqli_query($conn,$sql) === TRUE) {
   echo base64_encode(json_encode($id));
}
?>


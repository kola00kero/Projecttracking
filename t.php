<?php
session_start();
include("connect.php");
include("EnDeCode.php");

echo $conn->stat();
function check_password_plain($user,$pw) {
    global $conn;
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
    else {
        echo "xxx";
        echo $mysqli->error;
    }
    return $authen;
}

echo "<br/>";
echo "trying..<br/>";
if (check_password_plain("student004","1234")) {
    echo "success";
}
else {
    echo "fail";
}
?>

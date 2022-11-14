<?php
require "connection.php";
$pass = password_hash($_POST['newpass'],PASSWORD_DEFAULT);
$email = $_POST['email'];
$changesql = "UPDATE users SET Password='$pass' WHERE Email='$email'";
$result = mysqli_query($conn, $changesql);
if ($result){
    echo "1";
}
else{
    echo "0";
}

?>
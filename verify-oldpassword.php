<?php
require "connection.php";

$id = $_POST['userid'];
$old = $_POST['old'];

// Fetching the actual password from database
$sql = "SELECT Password FROM users WHERE Id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$password = $row['Password'];

// Checking if the password matches or not.
$verification = password_verify($old,$password);

// Return if password is correct.
if ($verification){
    echo '1';
}
else{
    echo '0';
}
?>
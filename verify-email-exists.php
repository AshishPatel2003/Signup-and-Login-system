<?php
require "connection.php";

$email = $_POST['email'];

// Extracting the existence of the email from the database.
$sql = "SELECT * FROM users WHERE Email='$email'";
$result = mysqli_query($conn, $sql);
$numrow = mysqli_num_rows($result);

// Returning if the record is there or not.
if ($numrow>=1){
    echo '1';
}else{
    echo '0';
}

?>
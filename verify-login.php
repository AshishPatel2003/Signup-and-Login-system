<?php

require "connection.php";

$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE Email='$email'";
$result = mysqli_query($conn, $sql);
$numrows = mysqli_num_rows($result);

// Checking for the existence of the email.
if ($numrows == 1) {
    $row = mysqli_fetch_assoc($result);
    $password_verify = password_verify($password, $row['Password']);

    // Checking if the password is correct or not.
    if($password_verify){
        session_start();
        $_SESSION['Id'] = $row['Id'];
        $_SESSION['Email'] = $row['Email'];

        // Login details correct.
        echo '3';
    }
    else{
        // Password Incorrect
        echo '2';
    }
}
else{
    // Email not exists
    echo '1';
}

?>
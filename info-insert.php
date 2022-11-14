<?php
require "connection.php";
require "function.php";

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$address = $_POST['address'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$gender = $_POST['gender'];
$password = password_hash($_POST['password'],PASSWORD_DEFAULT);

$profile_name = $_FILES['profile']['name'];
$profile_tmp = $_FILES['profile']['tmp_name'];
$profile_type = $_FILES['profile']['type'];
$uploads = "Uploads/";

# Extracting the Maximun id for record
$lastidsql = "SELECT max(Id) as Id FROM users";
$idresult = mysqli_query($conn, $lastidsql);

if (mysqli_num_rows($idresult)==0){
    $id = 0;
}else{
    $row = mysqli_fetch_assoc($idresult);
    $id = $row['Id'];                                       // Getting the maximum id.
}
$id += 1;

// New name of the Image file.
$filename = 'Image_'.renamefilename($id, $profile_type);

// Moving the Image file to Uploads folder.
move_uploaded_file($profile_tmp, $uploads.$profile_name);

// Renaming the Image file name to new name.
rename($uploads.$profile_name, $uploads.$filename);

$insertsql = "INSERT INTO `users` (
    `Id`, `Firstname`, `Lastname`, `Email`, `Address`, `Country`, `State`, `City`, `Gender`, `Password`, `Profile`) 
    VALUES (
    NULL, '$firstname', '$lastname', '$email', '$address', '$country', '$state', '$city', '$gender', '$password', '$filename')";
$result = mysqli_query($conn, $insertsql);

if($result){
    echo "SignUp Successfully.";
}
else{
    echo "SignUp Failed.";
}

?>
<?php
require "connection.php";
require "function.php";

$firstname = $_POST['editfirstname'];
$lastname = $_POST['editlastname'];
$email = $_POST['editemail'];
$address = $_POST['editaddress'];
$country = $_POST['editcountry'];
$state = $_POST['editstate'];
$city = $_POST['editcity'];
$gender = $_POST['editgender'];
$profile_name = $_FILES['editprofile']['name'];


if ($profile_name != '') {
    $profile_tmp = $_FILES['editprofile']['tmp_name'];
    $profile_type = $_FILES['editprofile']['type'];
    $uploads = "Uploads/";

    # Extracting the id form record
    $lastidsql = "SELECT * FROM users WHERE Email='$email'";
    $idresult = mysqli_query($conn, $lastidsql);
    $row = mysqli_fetch_assoc($idresult);
    $id = $row['Id'];

    // New name of the Image file.
    $filename = 'Image_'.renamefilename($id, $profile_type);

    // Removing the file from folder
    unlink("Uploads/" . $row['Profile']);

    // Moving the Image file to Uploads folder.
    move_uploaded_file($profile_tmp, $uploads . $profile_name);

    // Renaming the Image file name to new name.
    rename($uploads . $profile_name, $uploads . $filename);

    $updatesql = "UPDATE users SET Firstname='$firstname', Lastname='$lastname', Address='$address', Country=$country, State=$state, City=$city, Gender='$gender', Profile='$filename' WHERE Email='$email'";

} else {
    $updatesql = "UPDATE users SET Firstname='$firstname', Lastname='$lastname', Address='$address', Country=$country, State=$state, City=$city, Gender='$gender' WHERE Email='$email'";
}
// Executing the query
$result = mysqli_query($conn, $updatesql);

if ($result) {
    echo '1';
} else {
    echo '0';
}
?>
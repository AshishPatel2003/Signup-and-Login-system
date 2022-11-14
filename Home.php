<!DOCTYPE html>
<?php
session_start();

require "connection.php";

$id = "";
$profile = "white.jpg";
$firstname = " ";
$email = " ";

$message = '';

if (isset($_GET['login_message'])) {
  $message = 'Login Successfully';
}
if (isset($_GET['update_message'])) {
  $message = 'Info Updated Successfully.';
}

?>
<html lang="en">

<head>
  <title>Ashish-Fitness</title>
  <!-- Including the bootstrap link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Including the bootstrap script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- JQuery Script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <!-- Custom Stylesheets -->
  <link rel="stylesheet" href="css/signup.css" />
  <link rel="stylesheet" href="css/home.css" />
  <link rel="stylesheet" href="css/editprofile.css" />
</head>

<body style="background-color: rgb(151, 229, 255);">
  <script>
    $(document).ready(function() {
      $('#login').show();
      $('#signup').hide();
      $('#editprofile').hide();
      $('#changepassword').hide();
      $('#welcome').hide();

      // Function to Reset the Fields.
      function resetfields() {
        // Setting the default border-color of input fields
        $('#firstname').css('border-color', 'lightgray');
        $('#lastname').css('border-color', 'lightgray');
        $('#email').css('border-color', 'lightgray');
        $('#tickboxemailspan').css('border-color', 'lightgray');
        $('#address').css('border-color', 'lightgray');
        $('#flagspan').css('border-color', 'lightgray');
        $('#country').css('border-color', 'lightgray');
        $('#state').css('border-color', 'lightgray');
        $('#city').css('border-color', 'lightgray');
        $('#genderlabel').css('border-color', 'lightgray');
        $('#gendercheckbox').css('border-color', 'lightgray');
        $('#profilebox').css('border-color', 'lightgray');
        $('#display_image').css('display', 'none');
        $('#password').css('border-color', 'lightgray');
        $('#tickboxpasswordspan').css('border-color', 'lightgray');
        $('#confirmpassword').css('border-color', 'lightgray');
        $('#tickboxconfirmpasswordspan').css('border-color', 'lightgray');
        $('#loginemail').css('border-color', 'darkblue');
        $('#loginpassword').css('border-color', 'darkblue');
        $('#emaillogo').css('border-color', 'darkblue');
        $('#passwordlogo').css('border-color', 'darkblue');

        // Removing the tick checks
        $('#tickboxpassword').removeClass('fas fa-check');
        $('#tickboxpassword').removeClass('fas fa-times');
        $('#tickboxpassword').removeClass('fas fa-exclamation');

        $('#tickboxemail').removeClass('fas fa-check');
        $('#tickboxemail').removeClass('fas fa-times');
        $('#tickboxemail').removeClass('fas fa-exclamation');

        $('#tickboxconfirmpassword').removeClass('fas fa-check');
        $('#tickboxconfirmpassword').removeClass('fas fa-times');
        $('#tickboxconfirmpassword').removeClass('fas fa-exclamation');

        // Hiding the input error check spans.
        $('#checkfirstname').hide()
        $('#checklastname').hide()
        $('#checkemail').hide()
        $('#checkaddress').hide()
        $('#checkcountry').hide()
        $('#checkstate').hide()
        $('#checkcity').hide()
        $('#checkgender').hide()
        $('#checkprofile').hide()
        $('#checkpassword').hide()
        $('#checkconfirmpassword').hide()
        $('#checkloginemail').hide()
        $('#checkloginpassword').hide()

      }

      $('input').focusin(function() {
        $('#emaillogo').css('border-color', 'darkblue');
        $('#passwordlogo').css('border-color', 'darkblue');
        $('#loginemail').css('border-color', 'darkblue');
        $('#loginpassword').css('border-color', 'darkblue');
      });

      // Checking if any Session is already going on or not.
      let checksession = <?php if (isset($_SESSION['Id'])) {
                            $email = $_SESSION['Email'];
                            $id = $_SESSION['Id'];
                            $sql = "SELECT * FROM users WHERE Email='$email'";
                            $data = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($data);
                            $profile = $row['Profile'];
                            $firstname = $row['Firstname'];
                            echo 1;
                          } else {
                            echo 0;
                          } ?>;

      // If above condition is true;
      if (checksession) {
        // Setting the navbar-toggler image and hiding the sign and login buttons
        $('#navlogoprofile').attr('src', "Uploads/<?php echo $profile; ?>");
        $('#nav-toggler').attr('src', "Uploads/<?php echo $profile; ?>");
        $('#username').html("<?php echo $firstname; ?>");
        $('#navlogoprofile').show();
        $("#logout").show();
        $('#navsignupbtn').hide();
        $('#navloginbtn').hide();
        $('#loginusername').show();

        // To display the Message login/Upade successfully.
        if (<?php if ($message == '') {
              echo 0;
            } else {
              echo 1;
            } ?>) {
          $('#temp_container').css('background-color', 'lightgreen');
          $('#temp_container').hide().html('<?php echo $message; ?>').slideDown().delay(1500).slideUp();
        }
        welcome = "<div><p style = 'font-size: 20px;'>Welcome <b><?php echo $firstname; ?></b></p></div>"
        $('#welcome').html(welcome);
        $('#welcome').fadeIn();

      }

      // If above condition is false
      if (!checksession) {
        $('#navlogoprofile').hide();
        $("#logout").hide();
        $('#navsignupbtn').show();
        $('#navloginbtn').show();
        $('#loginusername').hide();
        $('#editprofilebtn').hide();
        $('#changepasswordbtn').hide();

        // Including the Signup form
        $.ajax({
          url: "form-signup.php",
          type: "post",
          data: {},
          success: function(result) {
            $('#signup').html(result);
          }
        });

        // Including the Login form
        $.ajax({
          url: "form-login.php",
          type: "post",
          data: {},
          success: function(result) {
            $('#login').html(result);
          }
        });
      }

      // Click event of nav Signup button and Signup here button in the form.
      $('#navsignupbtn, #signuphere').on("click", function(e) {
        e.preventDefault();
        $('#login').slideUp();
        $('#formlogin').trigger('reset');
        resetfields();
        $('#signup').slideDown();
      });

      // Click event of nav Login button and Login here button in the form.
      $('#navloginbtn, #loginhere').on("click", function(e) {
        e.preventDefault();
        $('#signup').slideUp();
        resetfields();
        $('#formsignup').trigger('reset');
        $('#login').slideDown();
      });

      // Logout button click event
      $('#logout').on('click', function(e) {
        e.preventDefault();
        $.ajax({
          url: 'logout.php',
          type: "POST",
          success: function(result) {
            window.location.href = "Home.php";
          }
        });
      });

      // Edit Profile button Click event on the nav bar.
      $('#editprofilebtn').click(function() {
        $('#login').hide();
        $('#signup').hide();
        $('#welcome').slideUp();
        $('#changepassword').slideUp();

        // Including the edit-profile.php for updation.
        $.ajax({
          url: 'form-editprofile.php',
          type: "POST",
          data: {
            userid: '<?php echo $id; ?>'
          },
          success: function(editprofile) {
            // Setting the html of editprofile form in empty editprofile div container.
            $('#editprofile').html(editprofile);
            $('#editprofile').slideDown();
          }
        });
        $('#changepassword').html('');
      });

      // Change Password button Click event on the nav bar.
      $('#changepasswordbtn').on('click', function() {
        $('#login').hide();
        $('#signup').hide();
        $('#welcome').slideUp();
        $('#editprofile').slideUp();

        // Including the change-password.php for changing the password.
        $.ajax({
          url: 'form-changepass.php',
          type: "POST",
          data: {
            userid: '<?php echo $id; ?>',
            email: '<?php echo $email; ?>'
          },
          success: function(editprofile) {
            // Setting the html of changepassword form in empty changepassword div container.
            $('#changepassword').html(editprofile);
            $('#changepassword').slideDown();
          }
        });
        $('#editprofile').html('');

      });

    });
  </script>

  <!-- Nav bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
    <div class="container-fluid">
      <a class="navbar-brand" style="padding:4px 10px 4px 10px; border:3px double rgb(65, 113, 128);border-radius:30%;font-family:sans-serif;color: rgb(28, 28, 119);background-color:rgb(151, 229, 255);" href="#"><b>Ashish-Fitness</b></a>

      <!-- Nav bar toggler button for responsiveness. -->
      <button class="navbar-toggler" style="padding:0px;border-radius: 50%;width: fit-content;height: fit-content;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="">
          <img style="border-radius:50%;width:50px;height:50px;" id="nav-toggler" src="flags/flag-of-India.jpg" />
        </span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <!-- Home button -->
          <li class="nav-item">
            <a id="homebtn" class="nav-link active" aria-current="page" href="Home.php">Home</a>
          </li>

          <!-- Edit profile button -->
          <li class="nav-item">
            <button id="editprofilebtn" class="nav-link bg-dark rm-b" href="#">Edit Profile</button>
          </li>

          <!-- Change password button -->
          <li class="nav-item">
            <button id="changepasswordbtn" class="nav-link bg-dark rm-b" href="#" tabindex="-1" aria-disabled="true">Change Password</button>
          </li>
        </ul>

        <!-- Form for SignUp and Login Button if not registered else Profile image and username  -->
        <form class="d-flex">

          <!-- Sign Up button -->
          <button id="navsignupbtn" class="btn btn-outline-info me-2" type="submit">Sign Up</button>

          <!-- Login Button -->
          <button id="navloginbtn" class="btn btn-outline-info" type="submit">Login</button>

          <!-- Profile Image -->
          <img id="navlogoprofile" style="border-radius:50%;width:40px;height:40px;" />

          <!-- Profile Name with Logout facility -->
          <li id="loginusername" class="nav-item dropdown my-2" style="width: fit-content;">
          
          <!-- Username -->
          <a class="dropdown-toggle me-5" href="#" id="username" style="text-decoration:none;font-size:medium;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Username
            </a>
            <ul class="dropdown-menu" aria-labelledby="username">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <!-- Logout Button -->
              <button id="logout" class="btn btn-dark" style="margin:5px;border:2px solid gray">Logout</button>
            </ul>
          </li>

        </form>
      </div>
    </div>
  </nav>

  <!-- Empty Container for Message popups -->
  <div id="temp_container"></div>

  <!-- Empty Welcome container when logined -->
  <div id="welcome"></div>

  <!-- Empty Edit Profile for editprofile form -->
  <div id="editprofile"></div>

  <!-- Empty Change password container for change password form  -->
  <div id="changepassword"></div>

  <!-- Empty SignUp container for signup form -->
  <div id="signup"></div>

  <!-- Empty Login conatainer for login form  -->
  <div id="login"></div>

</body>

</html>
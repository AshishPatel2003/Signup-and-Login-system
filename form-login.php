<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    $(document).ready(function() {

        $('#checkloginemail').hide();
        $('#checkloginpassword').hide();

        $('#loginemail, #loginpassword').focusin(function() {
            $('#emaillogo').css('border-color', 'darkblue');
            $('#passwordlogo').css('border-color', 'darkblue');
            $('#loginemail').css('border-color', 'darkblue');
            $('#loginpassword').css('border-color', 'darkblue');
        });
        
        function emailcss(color) {
            $('#loginemail').css('border-color', color);
            $('#emaillogo').css('border-color', color);
            $('#checkloginemail').css('color', color);  
        }

        function passwordcss(color) {
            $('#checkloginpassword').css('color', color);
            $('#loginpassword').css('border-color', color);
            $('#passwordlogo').css('border-color', color);
        }

        // SignUp here
        $('#signuphere').on("click", function(e) {
            e.preventDefault();
            $('#login').slideUp();
            $('#signup').slideDown();
        });

        $('#loginemail').on('blur', function() {
            validateloginemail();
        });
        // Email Validation Function.
        function validateloginemail() {
            let email = $('#loginemail').val();
            let emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (email.length == 0) {
                emailcss('darkblue');
                return false;
            } else if (!email.match(emailformat)) {
                $('#checkloginemail').html('X Please provide valid email address');
                emailcss('red');
                $('#checkloginemail').slideDown();
                return false;
            } else {
                $('#loginemail').css('border-color', 'darkblue');
                $('#emaillogo').css('border-color', 'darkblue');
                $('#checkloginemail').slideUp();
                return true;
            }
        }

        // Password Validation Function.
        function validateloginpassword() {
            password = $('#loginpassword');
            if (password.val() == '') {
                $('#checkloginpassword').html('** Please Provide Password.');
                passwordcss('red');
                $('#checkloginpassword').slideDown();
                return false;
            } else if (password.val().length < 8) {
                $('#checkloginpassword').html('** Invalid Password.');
                passwordcss('red');
                $('#checkloginpassword').slideDown();
                return false;
            } else {
                $('#checkpassword').html('');
                passwordcss('darkblue');
                $('#checkloginpassword').slideUp();
                return true;
            }
        }

        // Signup form submission.
        $('#formlogin').on('submit', function(e) {
            e.preventDefault();
            checkuser = validateloginemail();
            checkpass = validateloginpassword();

            if (checkuser == true && checkpass == true) {
                $.ajax({
                    url: "verify-login.php",
                    type: "POST",
                    data: {
                        email: $('#loginemail').val(),
                        password: $('#loginpassword').val()
                    },
                    success: function(result) {
                        // alert(result);
                        if (result == 1) {
                            $('#checkloginemail').html("Account doesn't Exists.");
                            emailcss('red');
                            $('#checkloginemail').slideDown();
                        } else if (result == 2) {
                            $('#checkloginpassword').html('** Wrong Password');
                            passwordcss('red');
                            $('#checkloginpassword').slideDown();
                        } else if (result == 3) {
                            window.location.href = "Home.php?login_message='login'";
                        }
                    }
                });
            } else {
                $('#temp_container').css('background-color', '#f7e683');
                $('#temp_container').html('Please fill correct details...').slideDown().delay(2000).slideUp();
            }
        });
    });
</script>
<div id="logincontainer">
    <div id="loginlabel">
        <h2>Login</h2>
    </div>
    <div id="loginform">
        <form name="formlogin" id="formlogin" enctype="multipart/form-data">
            <!-- Email -->
            <div class="mx-2 my-2">
                <div class="d-flex">
                    <div class="d-flex">
                        <i id='emaillogo' class="form-control userlogo fas fa-user-circle rm-b-r rm-br-tr rm-br-br"></i>
                    </div>
                    <input type="text" class="form-control bc-db rm-br-tl rm-br-bl" name="loginemail" id="loginemail" placeholder="Email">
                </div>
                <!-- Check Email -->
                <div>
                    <span id="checkloginemail" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>

            <!-- Password -->
            <div class="mx-2 my-2">
                <div class="d-flex">
                    <div class="d-flex">
                        <i id="passwordlogo" class="form-control userlogo fas fa-key rm-b-r rm-br-tr rm-br-br"></i>
                    </div>
                    <input type="password" class="form-control bc-db rm-br-tl rm-br-bl" name="loginpassword" id="loginpassword" placeholder="Password">
                </div>
                <!-- Check Password -->
                <div>
                    <span id="checkloginpassword" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>
            <div class="m-2">
                <hr>
            </div>
            <div class="loginbtn-container">
                <div class="notexist">
                    Don't have any account? <br><button id="signuphere">SignUp here</button>
                </div>
                <button type="submit" name="loginbtn" id="loginbtn" class="btn btn-primary width-30">Login</button>
            </div>

        </form>
    </div>
</div>
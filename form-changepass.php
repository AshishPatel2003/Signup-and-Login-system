<?php
// Fetching the userid and Email
$id = $_POST['userid'];
$email = $_POST['email'];
?>
<script>
    $(document).ready(function() {
        $('#checkoldpassword').hide();
        $('#checknewpassword').hide();
        $('#checkconfirmnewpassword').hide();

        verify = 0;

        // Ajax of Checking the old password is correct or not.
        function ajaxcheckpassword() {
            $.ajax({
                url: 'verify-oldpassword.php',
                type: 'POST',
                data: {
                    userid: '<?php echo $id; ?>',
                    old: $('#oldpassword').val()
                },
                success: function(data) {
                    verify = data;
                    if (verify == 1) {
                        return true;
                    } else if (verify == 0) {
                        return false;
                    }
                }
            });
        }

        // Old Password Validation Function
        function validateoldpassword() {
            if ($('#oldpassword').val() == '') {
                $('#checkoldpassword').html('Enter Old Password.')
                $('#checkoldpassword').css('color', '#c48002');
                $('#oldpassword').css('border-color', '#c48002');
                $('#checkoldpassword').slideDown();
                return false;
            } else {
                ajaxcheckpassword();

                if (verify == 1) {
                    $('#checkoldpassword').html('')
                    $('#checkoldpassword').css('color', 'green');
                    $('#oldpassword').css('border-color', 'green');
                    $('#checkoldpassword').slideUp();
                    return true;
                } else {
                    $('#checkoldpassword').html('**Wrong Password.')
                    $('#checkoldpassword').css('color', 'red');
                    $('#oldpassword').css('border-color', 'red');
                    $('#checkoldpassword').slideDown();
                    return false;
                }
            }
        }

        // Old password Validaton Blur Event
        $('#oldpassword').on('blur', function() {
            validoldpassblur();
        });

        // Validation of old password for blur event
        function validoldpassblur() {
            if ($('#oldpassword').val() == '') {
                return false;
            } else {
                ajaxcheckpassword();
                if (verify == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        // New Password Validation Function.
        function validatenewpassword() {
            if ($('#newpassword').val() == '') {
                $('#checknewpassword').html('! Please Provide New Password.')
                $('#checknewpassword').css('color', '#c48002');
                $('#newpassword').css('border-color', '#c48002');
                $('#checknewpassword').slideDown();
                return false;
            } else if ($('#newpassword').val().length < 8) {
                $('#checknewpassword').html('! Please Provide Password of atleast 8 letters and numbers.')
                $('#checknewpassword').css('color', 'red');
                $('#newpassword').css('border-color', 'red');
                $('#checknewpassword').slideDown();
                return false;
            } else {
                $('#checknewpassword').html('')
                $('#checknewpassword').css('color', 'green');
                $('#newpassword').css('border-color', 'green');
                $('#checknewpassword').slideUp();
                return true;
            }
        }

        // Validation of Confirm Password.
        $('#confirmnewpassword').keyup(function() {
            validateconfirmnewpassword();
        });

        // Confirm Password Validation Function.
        function validateconfirmnewpassword() {
            if ($('#confirmnewpassword').val() == '') {
                $('#checkconfirmnewpassword').html('! Please Provide Password.')
                $('#checkconfirmnewpassword').css('color', '#c48002');
                $('#confirmnewpassword').css('border-color', '#c48002');
                $('#confirmnewpasswordtickspan').css('border-color', '#c48002');
                $('#confirmnewpasswordtick').removeClass('fa fa-check');
                $('#confirmnewpasswordtick').removeClass('fa fa-times');
                $('#confirmnewpasswordtick').addClass('fa fa-exclamation');
                $('#confirmnewpasswordtick').css('color', '#c48002');
                $('#checkconfirmnewpassword').slideDown();
                return false;
            } else if ($('#confirmnewpassword').val() != $('#newpassword').val()) {
                $('#checkconfirmnewpassword').html("*Password Doesn't match")
                $('#checkconfirmnewpassword').css('color', 'red');
                $('#confirmnewpassword').css('border-color', 'red');
                $('#confirmnewpasswordtickspan').css('border-color', 'red');
                $('#confirmnewpasswordtick').removeClass('fa fa-check');
                $('#confirmnewpasswordtick').removeClass('fa fa-exclamation');
                $('#confirmnewpasswordtick').addClass('fa fa-times');
                $('#confirmnewpasswordtick').css('color', 'red');
                $('#checkconfirmnewpassword').slideDown();
                return false;
            } else {
                $('#checkconfirmnewpassword').html('')
                $('#checkconfirmnewpassword').css('color', 'green');
                $('#confirmnewpassword').css('border-color', 'green');
                $('#confirmnewpasswordtickspan').css('border-color', 'green');
                $('#confirmnewpasswordtick').removeClass('fa fa-times');
                $('#confirmnewpasswordtick').removeClass('fa fa-exclamation');
                $('#confirmnewpasswordtick').addClass('fa fa-check');
                $('#confirmnewpasswordtick').css('color', 'green');
                $('#checkconfirmnewpassword').slideUp();
                return true;
            }
        }

        // Submission of the Login Form.
        $('#formchange').on('submit', function(e) {
            e.preventDefault();
            validold = validateoldpassword();

            // Checking if the Old password is correct or not.
            if (validold) {
                validnew = validatenewpassword();
                validcon = validateconfirmnewpassword();

                let check = validnew == true && validcon == true;

                // Checking for the Validation of new password.
                if (check) {

                    // Updating the password.
                    $.ajax({
                        url: 'update-new-pass.php',
                        type: 'POST',
                        data: {
                            email: '<?php echo $email; ?>',
                            newpass: $('#newpassword').val()
                        },
                        success: function(result) {
                            match = result;
                            if (result == 1) {
                                $('#temp_container').css('background-color', 'lightgreen');
                                $('#temp_container').html('Password Changed Successfully').slideDown().delay(2000).slideUp();
                                $('#changepassword').slideUp();
                                $('#welcome').slideDown();
                            } else {
                                $('#temp_container').css('background-color', 'ligthyellow');
                                $('#temp_container').html('Password Changed Failed').slideDown().delay(2000).slideUp();
                            }
                        }
                    });
                }
            }
        });
    });
</script>

<div id="changecontainer">
    <label id="changepasswordlabel">
        Change Password
    </label>
    <div id="changepass">

        <!-- Change Password Form -->
        <form name="formchange" id="formchange" enctype="multipart/form-data">

            <!-- Old Password -->
            <div class="mx-2 my-2">
                <!-- Input Old Password -->
                <div class="d-flex">
                    <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password">
                </div>
                <!-- Check Old Password -->
                <div>
                    <span id="checkoldpassword" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>

            <!-- Seperator -->
            <div class="m-2">
                <hr>
            </div>

            <!-- New Password -->
            <div class="mx-2 my-2">
                <!-- Input New Password -->
                <div class="d-flex">
                    <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New Password">
                </div>
                <!-- Check New Password -->
                <div>
                    <span id="checknewpassword" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div class="mx-2 my-2">
                <!-- Input Confirm Password -->
                <div class="d-flex">
                    <input type="password" class="form-control rm-b-r rm-br-tr rm-br-br" name="confirmnewpassword" id="confirmnewpassword" placeholder="Confirm New Password">
                    <div class="d-flex">
                        <span class="form-control rm-b-l rm-br-tl rm-br-bl" id="confirmnewpasswordtickspan"><i id="confirmnewpasswordtick"></i></span>
                    </div>
                </div>
                <!-- Check Password -->
                <div>
                    <span id="checkconfirmnewpassword" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>

            <!-- Save Button -->
            <div class="changebtn-container">
                <button type="submit" name="savepassword" id="savepassword" class="btn btn-primary width-100">Save</button>
            </div>

        </form>
    </div>
</div>
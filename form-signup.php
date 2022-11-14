<!-- Including the font-awesome icon form email and password -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<script>
    $(document).ready(function() {

        // Hiding all the error check box.
        $('#checkfirstname').hide();
        $('#checklastname').hide();
        $('#checkemail').hide();
        $('#checkaddress').hide();
        $('#checkcountry').hide();
        $('#checkstate').hide();
        $('#checkcity').hide();
        $('#checkgender').hide();
        $('#checkprofile').hide();
        $('#checkpassword').hide();
        $('#checkconfirmpassword').hide();

        // Disabling the state and city
        $('#state').attr('disabled', true);
        $('#city').attr('disabled', true);

        // Resetting the field to new
        function reset_field() {

            $('#firstname').css('border-color', 'lightgray');
            $('#lastname').css('border-color', 'lightgray');
            $('#email').css('border-color', 'lightgray');
            $('#phone').css('border-color', 'lightgray');
            $('#tickboxemailspan').css('border', '5px 5px 5px 5px');
            $('#tickboxemailspan').css('border-color', 'lightgray');
            $('#tickboxemail').removeClass('fa fa-check');
            $('#tickboxemail').removeClass('fa fa-times');
            $('#tickboxemail').removeClass('fa fa-exclamation');
            $('#tickboxemailspan').hide();
            $('#email').css('border-right', '1px solid lightgray');
            $('#checkfirstname').html('');
            $('#checklastname').html('');
            $('#checkemail').html('');
            $('#checkphone').html('');
        }

        // Setting the css of Email
        function erroremailcss(msg) {
            $('#tickboxemail').removeClass('fa fa-exclamation');
            $('#tickboxemail').removeClass('fa fa-check');
            $('#checkemail').html(msg);
            $('#email').css('border-color', 'red');
            $('#tickboxemail').addClass('fa fa-times');
            $('#tickboxemailspan').css('border-color', "red");
            $('#tickboxemail').css('color', "red");
            $('#checkemail').css('color', "red");
            $('#checkemail').slideDown();
        }
        // <<<<<<<<<<<<<<<<<<<<< Effects >>>>>>>>>>>>>>>>>>>

        $('input').focusin(function() {
            $(this).css('border-color', 'blue');
        });
        $('input').focusout(function() {
            $(this).css('border-color', '#bdbab3');
        });

        // <<<<<<<<<<<<<<<<<<< Click Events >>>>>>>>>>>>>>>>

        // Check if the country is selected or not
        $('#state').on('click', function() {
            if ($('#country').val() == 'none') {
                $('#checkstate').html('! Please Select Country First');
                $('#state').css('border-color', '#c48002');
                $('#checkstate').slideDown();
                $('#checkstate').css('color', '#c48002');
            }
        });

        // Check if the country and state is selected or not.
        $('#city').on('click', function() {
            if ($('#country').val() == 'none') {
                $('#checkcity').html('! Please Select Country and State First');
                $('#city').css('border-color', '#c48002');
                $('#checkcity').slideDown();
                $('#checkcity').css('color', '#c48002');
            } else if ($('#state').val() == 'none') {
                $('#checkcity').html('! Please Select State First');
                $('#city').css('border-color', '#c48002');
                $('#checkcity').slideDown();
                $('#checkcity').css('color', '#c48002');
            }
        });

        // Login here button 
        $('#loginhere').on("click", function(e) {
            $('#signup').slideUp();
            $('#login').slideDown();
            e.preventDefault();
        });

        // <<<<<<<<<<<<<<<<<<<< Change Events >>>>>>>>>>>>>>>>>>>>

        // Fetching the states from country
        $('#country').on('change', function(e) {

            if (this.value != 'none') {
                $('#state').attr('disabled', false);
                countryid = this.value;
                countryquery = document.getElementById('country');
                countryname = countryquery.options[countryquery.selectedIndex].text;

                for (i = 0; i <= 4; i++) {
                    countryname = countryname.replace(' ', '-');
                }

                // Setting the html of img tag for Flag of the country
                img = '<img alt = "" style = "padding: 3px;width:38px; height: 22px;" src = "'.concat("flags/flag-of-", countryname, '.jpg"> </img>');
                $('#flagspan').css('background-color', "lightgray");
                $("#flagspan").html(img);

                $.ajax({
                    url: "fetch-states.php",
                    type: "POST",
                    data: {
                        cid: countryid,
                    },
                    success: function(states) {
                        $('#state').html(states);
                    }
                });
            } else {
                states = "<option value = 'none'>Select State</option>";
                $('#state').css('border-color', 'lightgray');
                $('#state').html(states);
                $('#state').attr('disabled', true);

                cities = "<option value = 'none'>Select City</option>";
                $('#city').css('border-color', 'lightgray');
                $('#city').html(cities);
                $('#city').attr('disabled', true);
            }
        });

        // Fetching Cities from state
        $('#state').on('change', function(e) {
            stateid = this.value;
            if (stateid != 'none') {
                $('#city').attr('disabled', false);
                $.ajax({
                    url: "fetch-cities.php",
                    type: "POST",
                    data: {
                        sid: stateid,
                    },
                    success: function(cities) {
                        $('#city').html(cities);
                    }
                });
            } else {
                cities = "<option value = 'none'>Select City</option>";
                $('#city').css('border-color', 'lightgray');
                $('#city').html(cities);
                $('#city').attr('disabled', true);

            }
        });

        // <<<<<<<<<<<<<<<<<<<<<< Validation >>>>>>>>>>>>>>>>>>>>>>

        // Firstname Validation
        $('#firstname').blur(function() {
            validatefirstname();
        });

        // Firstname Validation Function.
        function validatefirstname() {
            let firstname = $('#firstname').val();
            let firstnameformat = /^[A-Za-z\s]+$/;
            $('#checkfirstname').css('color', 'red');
            if (firstname.length == 0) {
                $('#checkfirstname').html("! This field can't be empty");
                $('#firstname').css('border-color', '#c48002');
                $('#checkfirstname').css('color', '#c48002');
                $('#checkfirstname').slideDown();
                return false;
            } else if (!firstname.match(firstnameformat)) {
                $('#checkfirstname').html('X Firstname must not contains numbers');
                $('#firstname').css('border-color', 'red');
                $('#checkfirstname').slideDown();
                return false;
            } else if (firstname.length > 20) {
                $('#checkfirstname').html('X Firstname length must be 3 to 20 letters.');
                $('#firstname').css('border-color', 'red');
                $('#checkfirstname').slideDown();
                return false;
            } else {
                $('#checkfirstname').html('');
                $('#firstname').css('border-color', 'green');
                $('#checkfirstname').slideUp();
                return true;
            }
        }

        // Lastname Validation
        $('#lastname').blur(function() {
            validatelastname();
        });

        // Lastname Validation Function.
        function validatelastname() {
            let lastname = $('#lastname').val();
            let lastnameformat = /^[A-Za-z\s]+$/;
            $('#checklastname').css('color', 'red');

            if (lastname.length == 0) {
                $('#checklastname').html("! This field can't be empty.");
                $('#lastname').css('border-color', '#c48002');
                $('#checklastname').css('color', '#c48002');
                $('#checklastname').slideDown();
                return false;
            } else if (!lastname.match(lastnameformat)) {
                $('#checklastname').html('X Lastname must not contains numbers');
                $('#lastname').css('border-color', 'red');
                $('#checklastname').slideDown();
                return false;
            } else if (lastname.length > 20) {
                $('#checklastname').html('X Lastname length must be 3 to 20 letters.');
                $('#lastname').css('border-color', 'red');
                $('#checklastname').slideDown();
                return false;
            } else {
                $('#checklastname').html('');
                $('#lastname').css('border-color', 'green');
                $('#checklastname').slideUp();
                return true;
            }
        }

        // Email Validation
        $('#email').blur(function() {
            validateemail();
        });

        checkaccount = 0;
        // Email Validation Function.
        function validateemail() {
            let email = $('#email').val();
            let emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            $('#tickboxemail').addClass('rm-b-l rm-bl-tl rm-bl-bl');

            if (email.length == 0) {
                $('#tickboxemail').removeClass('fa fa-times');
                $('#tickboxemail').removeClass('fa fa-check');
                $('#checkemail').html("! This field can't be empty");
                $('#email').css('border-color', '#c48002');
                $('#tickboxemail').addClass('fa fa-exclamation');
                $('#tickboxemailspan').css('border-color', "#c48002");
                $('#tickboxemail').css('color', "#c48002");
                $('#checkemail').css('color', "#c48002");
                $('#checkemail').slideDown();
                return false;
            } else if (!email.match(emailformat)) {
                errormsg = 'X Please provide valid email address';
                erroremailcss(errormsg);
                return false;
            } else {
                $.ajax({
                    url: "verify-email-exists.php",
                    type: "POST",
                    data: {
                        email: $('#email').val()
                    },
                    success: function(result) {
                        checkaccount = result;
                        if (checkaccount == 1) {
                            msg = "**Account Already exist. Try with another account.";
                            erroremailcss(msg);
                        } else if (checkaccount == 0) {
                            $('#checkemail').html('');
                            $('#tickboxemail').removeClass('fa fa-exclamation');
                            $('#tickboxemail').removeClass('fa fa-times');
                            $('#email').css('border-color', 'green');
                            $('#tickboxemail').addClass('fa fa-check');
                            $('#tickboxemailspan').css('border-color', "green");
                            $('#tickboxemail').css('color', "green");
                            $('#checkemail').css('color', "green");
                            $('#checkemail').slideUp();
                        }
                    }
                });
                if (checkaccount == 1) {
                    return false;
                } else {
                    return true;
                }
                // alert(checkaccount);

            }

        }

        // Address Validation
        $('#address').on('blur', function() {
            validateaddress();
        });

        // Address Validation Function.
        function validateaddress() {
            address = $('#address').val();
            if (address == '') {
                $('#address').css('border-color', '#c48002');
                $('#checkaddress').html('* This Field is required');
                $('#checkaddress').css('color', '#c48002');
                $('#checkaddress').slideDown();
                return false;
            } else if (address.length < 8) {
                $('#address').css('border-color', 'red');
                $('#checkaddress').html('* Please Provide Valid Address');
                $('#checkaddress').css('color', 'red');
                $('#checkaddress').slideDown();
                return false;
            } else {
                $('#address').css('border-color', 'green');
                $('#checkaddress').slideUp();
                return true;
            }
        }

        // Country Validation.
        $('#country').on('blur', function() {
            validatecountry();
        });

        // Country Validation Function.
        function validatecountry() {
            if ($('#country').val() == 'none') {
                $('#checkcountry').html('! This Field is requied.');
                $('#country').css('border-color', '#c48002');
                $('#flagspan').css('border-color', "#c48002");
                $('#checkcountry').slideDown();
                $('#checkcountry').css('color', '#c48002');
                return false;
            } else {
                $('#country').css('border-color', 'green');
                $('#flagspan').css('border-color', 'green');
                $('#checkcountry').css('color', 'green');
                $('#checkcountry').slideUp();
                return true;
            }
        }

        // State Validation.
        $('#state').on('blur', function() {
            validatestate();
        });

        // State Validation Function.
        function validatestate() {
            if ($('#state').val() == 'none') {
                $('#checkstate').html('! This Field is requied.');
                $('#state').css('border-color', '#c48002');
                $('#checkstate').slideDown();
                $('#checkstate').css('color', '#c48002');
                return false;
            } else {
                $('#state').css('border-color', 'green');
                $('#checkstate').css('color', 'green');
                $('#checkstate').slideUp();
                return true;
            }
        }

        // City Validation.
        $('#city').on('blur', function() {
            validatecity();
        });

        // City Validation Function.
        function validatecity() {
            if ($('#city').val() == 'none') {
                $('#checkcity').html('! This Field is requied.');
                $('#city').css('border-color', '#c48002');
                $('#checkcity').slideDown();
                $('#checkcity').css('color', '#c48002');
                return false;
            } else {
                $('#city').css('border-color', 'green');
                $('#checkcity').css('color', 'green');
                $('#checkcity').slideUp();
                return true;
            }
        }

        $('input[name="gender"]').on('blur', function() {
            validategender();
        });
        // Gender Validation Function.
        function validategender() {
            gender = $('input[name="gender"]:checked').val();
            if (!gender) {
                $('#genderlabel').css('border-color', '#c48002');
                $('#gendercheckbox').css('border-color', '#c48002');
                $('#checkgender').css('color', '#c48002');
                $('#checkgender').html('* This Field is required');
                $('#checkgender').slideDown();
                return false;
            } else {
                $('#genderlabel').css('border-color', "green");
                $('#gendercheckbox').css('border-color', 'green');
                $('#checkgender').slideUp();
                return true;
            }
        }

        // Profile Validation
        $('#profile').on('change', function() {
            validateprofile();
        });

        // Profile Validation Function.
        function validateprofile() {
            let profile = $('#profile').val();
            let imageformat = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (profile == '') {
                $('#checkprofile').css('color', '#c48002')
                $('#profilebox').css('border-color', '#c48002');
                $('#checkprofile').html('! Please Choose your Profile image');
                $('#checkprofile').slideDown();
                $('#display_image').slideUp();
                return false;
            } else if (!imageformat.exec(profile)) {
                $('#checkprofile').css('color', 'red')
                $('#profilebox').css('border-color', 'red');
                $('#checkprofile').html('**Please choose valid image format files (.jpg, .jpeg, .png, .gif)');
                $('#checkprofile').slideDown();
                $('#display_image').slideUp();
                $('#profile').val('');
                return false;
            }
            return true;
        }

        // Preview Image
        $('#profile').on("change", function() {
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                const uploaded_image = reader.result;
                $('#checkprofile').slideUp();
                $('#display_image').hide();
                $("#display_image").css('width', '200px');
                $("#display_image").css('height', '200px');
                $("#display_image").css('margin', 'auto');
                $("#display_image").css('border', '1px solid lightgray');
                $('#display_image').css('background-image', `url(${uploaded_image})
                    `);
                $('#profilebox').css('border-color', 'green')
                $('#display_image').slideDown();
            });
            reader.readAsDataURL(this.files[0]);

        });

        // Password Valiation
        $('#password').blur(function() {
            validatepassword();
        });

        // Password Validation Function.
        function validatepassword() {
            password = $('#password');
            if (password.val() == '') {
                $('#checkpassword').html('! Please Provide Password.')
                $('#checkpassword').css('color', '#c48002');
                $('#password').css('border-color', '#c48002');
                $('#tickboxpasswordspan').css('border-color', '#c48002');
                $('#tickboxpassword').removeClass('fa fa-check');
                $('#tickboxpassword').removeClass('fa fa-times');
                $('#tickboxpassword').addClass('fa fa-exclamation');
                $('#tickboxpassword').css('color', '#c48002');
                $('#checkpassword').slideDown();
                return false;
            } else if (password.val().length < 8) {
                $('#checkpassword').html('! Please Provide Password of at least 8 charaters.')
                $('#checkpassword').css('color', 'red');
                $('#password').css('border-color', 'red');
                $('#tickboxpasswordspan').css('border-color', 'red');
                $('#tickboxpassword').removeClass('fa fa-check');
                $('#tickboxpassword').removeClass('fa fa-exclamation');
                $('#tickboxpassword').addClass('fa fa-times');
                $('#tickboxpassword').css('color', 'red');
                $('#checkpassword').slideDown();
                return false;
            } else {
                $('#checkpassword').html('')
                $('#checkpassword').css('color', 'green');
                $('#password').css('border-color', 'green');
                $('#tickboxpasswordspan').css('border-color', 'green');
                $('#tickboxpassword').removeClass('fa fa-times');
                $('#tickboxpassword').removeClass('fa fa-exclamation');
                $('#tickboxpassword').addClass('fa fa-check');
                $('#tickboxpassword').css('color', 'green');
                $('#checkpassword').slideUp();
                return true;
            }
        }

        // Confirm Password Validation
        $('#confirmpassword').keyup(function() {
            validateconfirmpassword();
        });

        // Confirm Password Validation Function.
        function validateconfirmpassword() {
            if ($('#confirmpassword').val() == '') {
                $('#checkconfirmpassword').html('! Please Provide Password.')
                $('#checkconfirmpassword').css('color', '#c48002');
                $('#confirmpassword').css('border-color', '#c48002');
                $('#tickboxconfirmpasswordspan').css('border-color', '#c48002');
                $('#tickboxconfirmpassword').removeClass('fa fa-check');
                $('#tickboxconfirmpassword').removeClass('fa fa-times');
                $('#tickboxconfirmpassword').addClass('fa fa-exclamation');
                $('#tickboxconfirmpassword').css('color', '#c48002');
                $('#checkconfirmpassword').slideDown();
                return false;
            } else if ($('#confirmpassword').val() != $('#password').val()) {
                $('#checkconfirmpassword').html("*Password Doesn't match")
                $('#checkconfirmpassword').css('color', 'red');
                $('#confirmpassword').css('border-color', 'red');
                $('#tickboxconfirmpasswordspan').css('border-color', 'red');
                $('#tickboxconfirmpassword').removeClass('fa fa-check');
                $('#tickboxconfirmpassword').removeClass('fa fa-exclamation');
                $('#tickboxconfirmpassword').addClass('fa fa-times');
                $('#tickboxconfirmpassword').css('color', 'red');
                $('#checkconfirmpassword').slideDown();
                return false;
            } else {
                $('#checkconfirmpassword').html('')
                $('#checkconfirmpassword').css('color', 'green');
                $('#confirmpassword').css('border-color', 'green');
                $('#tickboxconfirmpasswordspan').css('border-color', 'green');
                $('#tickboxconfirmpassword').removeClass('fa fa-times');
                $('#tickboxconfirmpassword').removeClass('fa fa-exclamation');
                $('#tickboxconfirmpassword').addClass('fa fa-check');
                $('#tickboxconfirmpassword').css('color', 'green');
                $('#checkconfirmpassword').slideUp();
                return true;
            }
        }

        // Submitting the data
        $('#formsignup').on('submit', function(e) {
            e.preventDefault();
            let checkfirst = validatefirstname();
            let checklast = validatelastname();
            let checkemail = validateemail();
            let checkaddress = validateaddress();
            let checkcountry = validatecountry();
            let checkstate = validatestate();
            let checkcity = validatecity();
            let checkgender = validategender();
            let profile = validateprofile();
            let password = validatepassword();
            let confirmpassword = validateconfirmpassword();

            let check = checkfirst == true && checklast == true && checkemail == true && checkaddress == true && checkcountry == true && checkstate == true && checkcity == true && checkgender == true && profile == true && password == true && confirmpassword == true;

            if (check) {
                $.ajax({
                    url: "info-insert.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $('#temp_container').css('background-color', 'lightgreen');
                        $('#formsignup').trigger('reset');
                        $('#temp_container').html('');
                        $('#temp_container').hide();
                        $('#signup').slideToggle();
                        $('#temp_container').html(data).slideToggle().delay(2000).slideToggle();
                        reset_field();
                        $('#signup').slideUp();
                        $('#login').slideDown();
                    }
                });
            } else {
                $('#temp_container').css('background-color', '#f7e683');
                $('#temp_container').html('Please fill correct details...').slideDown().delay(2000).slideUp();

            }
        });

    });
</script>

<div id="signupcontainer">

    <!-- SignUp Label -->
    <div id="signuplabel">
        <h2>Sign Up</h2>
    </div>

    <!-- SignUp Form -->
    <div id="signupform">
        <form name="formsignup" id="formsignup" enctype="multipart/form-data">
            <!-- Firstname - Lastname -->
            <div class="mx-1">
                <div class="d-flex my-2">
                    <div class="width-50 mx-1">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Firstname">
                        <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkfirstname"></span>

                    </div>
                    <!-- Check Firstname and Lastname -->
                    <div class="width-50 mx-1">
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Lastname">
                        <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checklastname"></span>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="mx-2 my-2">
                <div class="d-flex">
                    <input type="email" class="form-control rm-b-r rm-br-tr rm-br-br" name="email" id="email" placeholder="Email">
                    <div id="tickcontemail" class="d-flex">
                        <span class="form-control rm-b-l rm-br-tl rm-br-bl" id="tickboxemailspan"><i id="tickboxemail" class="rm-b-l rm-bl-tl rm-bl-bl"></i></span>
                    </div>
                </div>
                <!-- Check Email -->
                <div>
                    <span id="checkemail" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>

            <!-- Address -->
            <div class="my-2">
                <div class="d-flex">
                    <textarea id="address" name="address" rows="2" class="form-control mx-2" placeholder="Address..."></textarea>
                </div>
                <!-- Check address -->
                <div class="d-flex">
                    <span class="form-control mx-2 sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkaddress"></span>
                </div>
            </div>

            <!-- Country -->
            <div class="my-2 mx-2">
                <div class="d-flex">
                    <div id="flagcontainer" class="d-flex">
                        <span class="form-control rm-b-r rm-br-tr rm-br-br" id="flagspan"></span>
                    </div>
                    <select id="country" name="country" class="form-control rm-br-tl rm-br-bl">
                        <option value="none">Select Country</option>
                        <?php
                        require "connection.php";

                        $countriessql = "SELECT * FROM countries";
                        $result = mysqli_query($conn, $countriessql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php
                        }

                        ?>
                    </select>
                </div>
                <!-- Check country -->
                <div class="d-flex">
                    <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkcountry"></span>
                </div>
            </div>

            <!-- States and City-->
            <div class="mx-1">
                <div class="d-flex width-100">
                    <div class="d-block width-50 mx-1">
                        <select id="state" name="state" class="form-control">
                            <option value="none">Select State</option>
                        </select>
                        <span class="form-control sz-xs" id="checkstate"></span>

                    </div>
                    <!-- Check States and City-->
                    <div class="d-block width-50 mx-1">
                        <select id="city" name="city" class="form-control">
                            <option value="none">Select City</option>
                        </select>
                        <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkcity"></span>
                    </div>
                </div>
            </div>

            <!-- Gender -->
            <div class="my-2">
                <div class="d-flex mx-2">
                    <span id="genderlabel" class="input-group-text lg rm-b-r rm-br-tr rm-br-br">
                        <label>Gender</label>
                    </span>
                    <div id="gendercheckbox" class="display-auto form-control p-l-2 rm-br-tl rm-br-bl">
                        <div class="form-control p-0 b-0 form-check mx-2">
                            <input class="form-check-input" type="radio" name="gender" value="Male">
                            <label class="form-check-label">Male</label>
                        </div>
                        <div class="form-control p-0 b-0 form-check mx-4">
                            <input class="form-check-input" type="radio" name="gender" value="Female">
                            <label class="form-check-label">Female</label>
                        </div>
                        <div class="form-control p-0 b-0 form-check mx-4">
                            <input class="form-check-input" type="radio" name="gender" value="Other">
                            <label class="form-check-label">Other</label>
                        </div>
                    </div>
                </div>
                <!-- Check Gender -->
                <div class="d-flex">
                    <span class="form-control mx-2 sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkgender"></span>
                </div>
            </div>

            <!-- Profile -->
            <div class="mx-2">
                <div class="my-2" style="width: 100%;">
                    <div id="profilebox" class="form-control">
                        <div class="input-group my-3">
                            <label class="input-group-text mx-2">Profile</label>
                            <input type="file" name="profile" class="form-control mx-2" id="profile">
                        </div>
                        <!-- Preview Image container -->
                        <div id="display_image"></div>
                    </div>
                    <div>
                        <span id="checkprofile" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="mx-2 my-2">
                <div class="d-flex">
                    <input type="password" class="form-control rm-b-r rm-br-tr rm-br-br" name="password" id="password" placeholder="Password">
                    <div id="tickcontpassword" class="d-flex">
                        <span class="form-control rm-b-l rm-br-tl rm-br-bl" id="tickboxpasswordspan"><i id="tickboxpassword"></i></span>
                    </div>
                </div>
                <!-- Check Password -->
                <div>
                    <span id="checkpassword" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mx-2 my-2">
                <div class="d-flex">
                    <input type="password" class="form-control rm-b-r rm-br-tr rm-br-br" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password">
                    <div id="tickcontconfirmpassword" class="d-flex">
                        <span class="form-control rm-b-l rm-br-tl rm-br-bl" id="tickboxconfirmpasswordspan"><i id="tickboxconfirmpassword"></i></span>
                    </div>
                </div>
                <!-- Check Confirm Password -->
                <div>
                    <span id="checkconfirmpassword" class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr"></span>
                </div>
            </div>

            <div class="m-2">
                <hr>
            </div>

            <!-- Submit button -->
            <div class="submitbtn-container">
                <div class="exist">
                    Already have and account? <br><button id="loginhere">Login here</button>
                </div>
                <button type="submit" name="submit" id="submit" class="btn btn-primary width-30">SignUp</button>
            </div>

        </form>
    </div>
</div>
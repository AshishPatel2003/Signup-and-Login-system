<?php
require "connection.php";

// Getting the userid.
$id = $_POST['userid'];

// Extracting all the data from the database of this user.
$select = "SELECT * FROM users WHERE Id=$id";
$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) != 0) {
    $row = mysqli_fetch_assoc($result);

    $Firstname = $row['Firstname'];
    $Lastname = $row['Lastname'];
    $Email = $row['Email'];
    $Address = $row['Address'];
    $Country = $row['Country'];
    $State = $row['State'];
    $City = $row['City'];
    $Gender = $row['Gender'];
    $Profile = $row['Profile'];
    $Password = $row['Password'];
}

?>
<style>
    /* Previewing the Image */
    #display_edit_image {
        max-width: auto;
        max-height: 40%;
        border: 0px solid black;
        background-position: center;
        background-size: cover;
        padding: 5%;
    }
</style>

<script>
    $(document).ready(function() {

        // Getting the value from php.
        countryid = <?php echo $Country; ?>;
        stateid = <?php echo $State; ?>;
        cityid = <?php echo $City; ?>;

        // Hiding the Error Fields
        $('#checkeditfirstname').hide();
        $('#checkeditlastname').hide();
        $('#checkeditemail').hide();
        $('#checkeditaddress').hide();
        $('#checkeditcountry').hide();
        $('#checkeditstate').hide();
        $('#checkeditcity').hide();
        $('#checkeditgender').hide();
        $('#checkeditprofile').hide();

        // Disabling the Email Field
        $('#editfirstname').css('border-color', 'green');
        $('#editlastname').css('border-color', 'green');
        $('#editemail').css('border-color', 'green');
        $('#editaddress').css('border-color', 'green');
        $('#editflagspan').css('border-color', 'green');
        $('#editcountry').css('border-color', 'green');
        $('#editstate').css('border-color', 'green');
        $('#editcity').css('border-color', 'green');
        $('#editgendercheckbox').css('border-color', 'green');
        $('#editgenderlabel').css('border-color', 'green');
        $('#editprofilebox').css('border-color', 'green');
        $('#editemail').prop('readonly', true);


        // Setting the Profile image
        $('#display_edit_image').css('width', 'auto');
        $("#display_edit_image").css('height', "100px");
        $("#display_edit_image").css('margin', "auto");
        $("#display_edit_image").css('border', "1px solid lightgray");
        $("#display_edit_image").css('background-image', `url('Uploads/<?php echo $Profile; ?>')`);

        // Setting the State
        $.ajax({
            url: "fetch-states.php",
            type: "POST",
            data: {
                cid: countryid,
                sid: stateid
            },
            success: function(states) {
                $('#editstate').html(states);
            }
        });

        // Setting the City
        $.ajax({
            url: "fetch-cities.php",
            type: "POST",
            data: {
                sid: stateid,
                cid: cityid
            },
            success: function(states) {
                $('#editcity').html(states);
            }
        });


        // <<<<<<<<<<<<<<<<<<<<<< Validation >>>>>>>>>>>>>>>>>>>>>>

        // Firstname Validation
        $('#editfirstname').blur(function() {
            validateeditfirstname();
        });

        // Firstname Validation Function.
        function validateeditfirstname() {
            let editfirstname = $('#editfirstname').val();
            let editfirstnameformat = /^[A-Za-z\s]+$/;
            $('#checkeditfirstname').css('color', 'red');
            if (editfirstname.length == 0) {
                $('#checkeditfirstname').html("! This field can't be empty");
                $('#editfirstname').css('border-color', '#c48002');
                $('#checkeditfirstname').css('color', '#c48002');
                $('#checkeditfirstname').slideDown();
                return false;
            } else if (!editfirstname.match(editfirstnameformat)) {
                $('#checkeditfirstname').html('X Firstname must not contains numbers');
                $('#editfirstname').css('border-color', 'red');
                $('#checkeditfirstname').slideDown();
                return false;
            } else if (editfirstname.length > 20) {
                $('#checkeditfirstname').html('X Firstname length must be 3 to 20 letters.');
                $('#editfirstname').css('border-color', 'red');
                $('#checkeditfirstname').slideDown();
                return false;
            } else {
                $('#checkeditfirstname').html('');
                $('#editfirstname').css('border-color', 'green');
                $('#checkeditfirstname').slideUp();
                return true;
            }
        }

        // Lastname Validation
        $('#editlastname').blur(function() {
            validateeditlastname();
        });

        // Lastname Validation Function.
        function validateeditlastname() {
            let editlastname = $('#editlastname').val();
            let editlastnameformat = /^[A-Za-z\s]+$/;
            $('#checkeditlastname').css('color', 'red');

            if (editlastname.length == 0) {
                $('#checkeditlastname').html("! This field can't be empty.");
                $('#editlastname').css('border-color', '#c48002');
                $('#checkeditlastname').css('color', '#c48002');
                $('#checkeditlastname').slideDown();
                return false;
            } else if (!editlastname.match(editlastnameformat)) {
                $('#checkeditlastname').html('X Lastname must not contains numbers');
                $('#editlastname').css('border-color', 'red');
                $('#checkeditlastname').slideDown();
                return false;
            } else if (editlastname.length > 20) {
                $('#checkeditlastname').html('X Lastname length must be 3 to 20 letters.');
                $('#editlastname').css('border-color', 'red');
                $('#checkeditlastname').slideDown();
                return false;
            } else {
                $('#checkeditlastname').html('');
                $('#editlastname').css('border-color', 'green');
                $('#checkeditlastname').slideUp();
                return true;
            }
        }

        // Address Validation
        $('#editaddress').on('blur', function() {
            validateeditaddress();
        });

        // Address Validation Function.
        function validateeditaddress() {
            editaddress = $('#editaddress').val();
            if (editaddress == '') {
                $('#editaddress').css('border-color', '#c48002');
                $('#checkeditaddress').html('* This Field is required');
                $('#checkeditaddress').css('color', '#c48002');
                $('#checkeditaddress').slideDown();
                return false;
            } else if (editaddress.length < 8) {
                $('#editaddress').css('border-color', 'red');
                $('#checkeditaddress').html('* Please Provide Valid Address');
                $('#checkeditaddress').css('color', 'red');
                $('#checkeditaddress').slideDown();
                return false;
            } else {
                $('#editaddress').css('border-color', 'green');
                $('#checkeditaddress').slideUp();
                return true;
            }
        }

        // Country Validation.
        $('#editcountry').on('change', function() {
            countryid = this.value;
            countryquery = document.getElementById('editcountry');
            countryname = countryquery.options[countryquery.selectedIndex].text;

            for (i = 0; i <= 4; i++) {
                countryname = countryname.replace(' ', '-');
            }

            img = '<img alt = "" style = "padding: 3px;width:38px; height: 22px;" src = "'.concat("flags/flag-of-", countryname, '.jpg"> </img>');
            $('#flagspan').css('background-color', "lightgray");
            $("#editflagspan").html(img);

            valideditcountry = validateeditcountry();
            if (validateeditcountry) {
                $.ajax({
                    url: "fetch-states.php",
                    type: "POST",
                    data: {
                        cid: countryid
                    },
                    success: function(states) {
                        $('#editstate').html('');
                        $('#editstate').html(states);
                    }
                });
            }

        });

        // Country Validation Function.
        function validateeditcountry() {
            if ($('#editcountry').val() == 'none') {
                $('#checkeditcountry').html('! This Field is requied.');
                $('#editcountry').css('border-color', '#c48002');
                $('#editflagspan').css('border-color', "#c48002");
                $('#checkeditcountry').slideDown();
                $('#checkeditcountry').css('color', '#c48002');
                return false;
            } else {
                $('#editcountry').css('border-color', 'green');
                $('#editflagspan').css('border-color', 'green');
                $('#checkeditcountry').css('color', 'green');
                $('#checkeditcountry').slideUp();
                return true;
            }
        }

        // State Validation.
        $('#editstate').on('change', function() {
            stateid = $('#editstate').val();
            let valideditstate = validateeditstate();
            if (valideditstate) {
                $.ajax({
                    url: "fetch-cities.php",
                    type: "POST",
                    data: {
                        sid: stateid
                    },
                    success: function(cities) {
                        $('#editcity').html(cities);
                    }
                });
            }
        });

        // State Validation Function.
        function validateeditstate() {
            if ($('#editstate').val() == 'none') {
                $('#checkeditstate').html('! This Field is requied.');
                $('#editstate').css('border-color', '#c48002');
                $('#checkeditstate').slideDown();
                $('#checkeditstate').css('color', '#c48002');
                return false;
            } else {
                $('#editstate').css('border-color', 'green');
                $('#checkeditstate').css('color', 'green');
                $('#checkeditstate').slideUp();
                return true;
            }
        }

        // City Validation.
        $('#editcity').on('blur', function() {
            validateeditcity();
        });

        // City Validation Function.
        function validateeditcity() {
            if ($('#editcity').val() == 'none') {
                $('#checkeditcity').html('! This Field is requied.');
                $('#editcity').css('border-color', '#c48002');
                $('#checkeditcity').slideDown();
                $('#checkeditcity').css('color', '#c48002');
                return false;
            } else {
                $('#editcity').css('border-color', 'green');
                $('#checkeditcity').css('color', 'green');
                $('#checkeditcity').slideUp();
                return true;
            }
        }

        // Gender Validation.
        $('input[name="editgender"]').on('blur', function() {
            validateeditgender();
        });
        // Gender Validation Function.
        function validateeditgender() {
            editgender = $('input[name="editgender"]:checked').val();
            if (!editgender) {
                $('#editgenderlabel').css('border-color', '#c48002');
                $('#editgendercheckbox').css('border-color', '#c48002');
                $('#checkeditgender').css('color', '#c48002');
                $('#checkeditgender').html('* This Field is required');
                $('#checkeditgender').slideDown();
                return false;
            } else {
                $('#editgenderlabel').css('border-color', "green");
                $('#editgendercheckbox').css('border-color', 'green');
                $('#checkeditgender').slideUp();
                return true;
            }
        }

        // Edit Profile Validation Function.
        function validateeditprofile() {
            let image = $("input[name = 'editprofile']").val();
            let imageformat = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (image == '') {
                $('#display_edit_image').css('width', 'auto');
                $("#display_edit_image").css('height', "100px");
                $("#display_edit_image").css('margin', "auto");
                $("#display_edit_image").css('background-image', `url('Uploads/<?php echo $Profile; ?>')`);
                return true;
            } else if (!imageformat.exec(image)) {
                $('#checkeditprofile').css('color', 'red')
                $('#editprofilebox').css('border-color', 'red');
                $('#checkeditprofile').html('**Please choose valid image format files (.jpg, .jpeg, .png, .gif)');
                $('#checkeditprofile').slideDown();
                $('#display_edit_image').slideUp();
                $('#editprofile').val('');
                $("input[name = 'editprofile']").val('');
                return false;
            }
            return true;
        }

        // Previewing the Image.
        $('#editprofile').on("change", function() {
            checkeditprofile = validateeditprofile();
            let image = $("input[name = 'editprofile']").val();
            if (checkeditprofile && image != '') {
                image = $("input[type='file']").get(0).files[0];
                const readerr = new FileReader();
                readerr.addEventListener("load", function() {
                    const uploaded_image = readerr.result;
                    $('#checkeditprofile').slideUp();
                    $('#display_edit_image').hide();
                    $("#display_edit_image").css('width', '20%');
                    $("#display_edit_image").css('height', 'auto');
                    $("#display_edit_image").css('margin', 'auto');
                    $("#display_edit_image").css('border', '1px solid lightgray');
                    $('#display_edit_image').css('background-image', `url(${uploaded_image})`);
                    $('#editprofilebox').css('border-color', 'green')
                    $('#display_edit_image').slideDown();
                });
                readerr.readAsDataURL(image);
            }

        });

        // Fetching the States and Flag image from the country
        $('#editcountry').on('change', function(e) {
            countryid = this.value;
            countryquery = document.getElementById('editcountry');
            countryname = countryquery.options[countryquery.selectedIndex].text;

            for (i = 0; i <= 4; i++) {
                countryname = countryname.replace(' ', '-');
            }

            img = '<img alt = "" style = "padding: 3px;width:38px; height: 22px;" src = "'.concat("flags/flag-of-", countryname, '.jpg"> </img>');
            $('#editflagspan').css('background-color', "lightgray");
            $("#editflagspan").html(img);

            $.ajax({
                url: "fetch-states.php",
                type: "POST",
                data: {
                    cid: countryid,
                    sid: stateid
                },
                success: function(states) {
                    $('#state').html(states);
                }
            });
        });

        // Updation Form Submit.
        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            let validfirstname = validateeditfirstname();
            let validlastname = validateeditlastname();
            let validaddress = validateeditaddress();
            let validcountry = validateeditcountry();
            let validstate = validateeditstate();
            let validcity = validateeditcity();
            let validgender = validateeditgender();
            let validprofile = validateeditprofile();

            // Checking form the validaton of the fields on submission.
            let valid = validfirstname == true && validlastname == true &&
                validaddress == true && validcountry == true && validstate == true && validcity == true && validgender == true && validprofile == true

            if (valid) {
                $.ajax({
                    url: "info-update.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data == 1) {
                            $('#temp_container').css('background-color', 'lightgreen');
                            $('#temp_container').hide().html("Updated Successfully.").slideDown().delay(2000).slideUp();
                            $('#welcome').slideDown();
                            $('#editprofile').html('');
                            window.location.href = "Home.php?update_message='update'";
                        } else {
                            $('#temp_container').css('background-color', 'lightred');
                            $('#temp_container').hide().html("Updation Failed").slideDown().delay(2000).slideUp();
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

<div id="edit-container">

    <!-- Edit Form Label -->
    <label id="edit-label">Edit Profile</label>

    <!-- Edit Form -->
    <form id="edit-form" enctype="multipart/form-data">

        <!-- Edit Firstname and Lastname -->
        <div class="d-flex my-2">
            <!-- Firstname -->
            <div class="width-33 mx-2">
                <input type="text" class="form-control" name="editfirstname" id="editfirstname" placeholder="Firstname" value="<?php echo $Firstname; ?>">
                <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditfirstname"></span>
            </div>
            <!-- Lastname -->
            <div class="mx-2 width-33">
                <input type="text" class="form-control" name="editlastname" id="editlastname" placeholder="Lastname" value="<?php echo $Lastname; ?>">
                <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditlastname"></span>
            </div>
            <!-- Email -->
            <div class="mx-2 width-33">
                <input type="email" class="form-control" name="editemail" id="editemail" placeholder="Email" value="<?php echo $Email; ?>">
                <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditemail"></span>
            </div>
        </div>

        <!-- Address -->
        <div class="d-flex my-2">
            <div class="width-100 mx-2">
                <textarea type="text" class="form-control" name="editaddress" id="editaddress" placeholder="Firstname"><?php echo $Address; ?></textarea>
                <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditaddress"></span>
            </div>
        </div>

        <!-- Country, States and City -->
        <div class="d-flex my-2 mx-1">
            <div class="width-33 mx-1">

                <!-- Flag and Country -->
                <div class="d-flex">
                    <div id="editflagcontainer" class="d-flex">
                        <span class="form-control rm-b-r rm-br-tr rm-br-br" id="editflagspan"></span>
                    </div>
                    <select id="editcountry" name="editcountry" class="form-control rm-br-tl rm-br-bl">
                        <option value="none">Select Country</option>
                        <?php require "connection.php";
                        $countriessql = "SELECT * FROM countries";
                        $result = mysqli_query($conn, $countriessql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['id']; ?>" <?php if ($Country == $row['id']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $row['name']; ?></option>
                        <?php
                        }

                        ?>
                    </select>
                    <script>
                        countryquery = document.getElementById('editcountry');
                        countryname = countryquery.options[countryquery.selectedIndex].text;
                        for (i = 0; i <= 4; i++) {
                            countryname = countryname.replace(' ', '-');
                        }
                        img = '<img alt = "" style = "padding: 3px;width:38px; height: 22px;" src = "'.concat("flags/flag-of-", countryname, '.jpg"> </img>');
                        $('#editflagspan').css('background-color', "lightgray");
                        $("#editflagspan").html(img);
                    </script>
                </div>
                <!-- Check country -->
                <div class="d-flex width-100">
                    <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditcountry"></span>
                </div>
            </div>

            <!-- State -->
            <div class="d-block width-33 mx-2">
                <select id="editstate" name="editstate" class="form-control">
                    <option value="none">Select State</option>
                </select>
                <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditstate"></span>
            </div>
            <!-- City-->
            <div class="d-block width-33 mx-2">
                <select id="editcity" name="editcity" class="form-control">
                    <option value="none">Select City</option>
                </select>
                <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditcity"></span>
            </div>
        </div>

        <!-- Gender -->
        <div class="my-2">
            <div class="d-flex mx-2">
                <span id="editgenderlabel" class="input-group-text lg rm-b-r rm-br-tr rm-br-br">
                    <label>Gender</label>
                </span>
                <div id="editgendercheckbox" class="display-auto form-control p-l-2 rm-br-tl rm-br-bl">
                    <div class="form-control p-0 b-0 form-check mx-2">
                        <input class="form-check-input" type="radio" name="editgender" value="Male" <?php if ($Gender == "Male") {
                                                                                                        echo "checked";
                                                                                                    } ?>>
                        <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-control p-0 b-0 form-check mx-4">
                        <input class="form-check-input" type="radio" name="editgender" value="Female" <?php if ($Gender == "Female") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                        <label class="form-check-label">Female</label>
                    </div>
                    <div class="form-control p-0 b-0 form-check mx-4">
                        <input class="form-check-input" type="radio" name="editgender" value="Other" <?php if ($Gender == "Other") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                        <label class="form-check-label">Other</label>
                    </div>
                </div>
            </div>
            <!-- Check Gender -->
            <div class="d-flex mx-2">
                <span class="form-control sz-xs rm-b-t rm-br-tl rm-br-tr" id="checkeditgender"></span>
            </div>
        </div>

        <!-- Profile -->
        <div class="mx-2 my-2">
            <div id="editprofilebox" class="form-control d-flex">

                <!-- Profile Input -->
                <div class="input-group my-2">
                    <label class="input-group-text">Profile</label>
                    <input type="file" name="editprofile" class="form-control" id="editprofile">
                </div>
                <!-- Preview Image container -->
                <div id="display_edit_image" class="my-2"></div>
            </div>

            <!-- Check Profile -->
            <div class="mar-2">
                <span id="checkeditprofile" class="form-control sz-xs"></span>
            </div>
        </div>

        <!-- Seperator -->
        <div class="mx-2">
            <hr>
        </div>

        <!-- Update button -->
        <div class="update-container">
            <button type="submit" name="submit" id="submit" class="btn btn-primary width-100">Update</button>
        </div>
    </form>
</div>
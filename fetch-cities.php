<!-- Default selection of the City -->
<option value="none">Select City</option>
<?php
require 'connection.php';

$sid = $_POST['sid'];

// Checking if the countryid is posted for selection
if (isset($_POST['cid'])) {
    $cid = $_POST['cid'];
}

$statessql = "SELECT * FROM cities WHERE state_id=$sid";
$result = mysqli_query($conn, $statessql);
while ($row = mysqli_fetch_assoc($result)) {
?>
    Option of the
    <option value="<?php echo $row['id']; ?>" <?php
                                                // Print Selected if countryid is matched.
                                                if (isset($_POST['cid'])) {
                                                    if ($cid == $row['id']) {
                                                        echo 'selected';
                                                    }
                                                } ?>><?php echo $row['name']; ?></option>
<?php
}

?>
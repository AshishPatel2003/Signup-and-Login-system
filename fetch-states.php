<!-- Default selection of the City -->
<option value="none">Select State</option>
<?php
require 'connection.php';

$cid = $_POST['cid'];

// Checking if the stateid is posted for selection
if (isset($_POST['sid'])) {
    $sid = $_POST['sid'];
}
$statessql = "SELECT * FROM states WHERE country_id=$cid";
$result = mysqli_query($conn, $statessql);


while ($row = mysqli_fetch_assoc($result)) {
?>
    <option value="<?php echo $row['id']; ?>" <?php
                                                // Print Selected if stateid is matched.
                                                if (isset($_POST['sid'])) {
                                                    if ($sid == $row['id']) {
                                                        echo 'selected';
                                                    }
                                                } ?>><?php echo $row['name']; ?></option>
<?php
}

?>
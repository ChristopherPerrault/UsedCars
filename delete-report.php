<!-- Header -->
<?php
require('config/db.php');
?>


<?php
$contract_id = $_REQUEST['contract_id'];

$delete = "DELETE FROM `reports` WHERE `contract_id`='$contract_id'";

$result = mysqli_query($con,$delete) or die ( mysqli_error($con));

header("Location: home.php");
?>

<?php
require('config/db.php');
$car_id = $_REQUEST['car_id'];

$delete = "DELETE FROM `cars` WHERE `car_id`='$car_id'";

$result = mysqli_query($con,$delete) or die ( mysqli_error($con));

header("Location: userdashboard.php");
?>
<?php
require('config/db.php');
$user_id = $_REQUEST['user_id'];

$delete_user = "DELETE FROM `users` WHERE `user_id`='$user_id'";
$delete_cars = "DELETE FROM `cars` WHERE `user_id`='$user_id'";

$result1 = mysqli_query($con,$delete_user) or die ( mysqli_error($con));
$result2 = mysqli_query($con,$delete_cars) or die ( mysqli_error($con));

header("Location: login.php");
?>
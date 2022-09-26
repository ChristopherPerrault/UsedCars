<?php
#database parameters
$DBhost = "";
$DBuser = "";
$DBpassword = "";
$DBname = "usedcars";

#connection
$con = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);

#if connection failure
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
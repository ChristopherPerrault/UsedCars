<?php

$DBhost = "localhost";
$DBuser = "root";
$DBpassword = "";
$DBname = "UsedCars";

$con = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);

//  if connection failure
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
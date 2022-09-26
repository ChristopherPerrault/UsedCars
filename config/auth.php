<?php
#initialize session data
session_start();

#redirect to login page if session data is not set
if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();
}
?>
<?php
#initialize session data
session_start();

#destroying all sessions
if (session_destroy()) {

    #redirect to login page
    header("Location: login.php");
}
?>

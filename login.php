<!-- Header -->
<?php 
include('templates/header-logged-out.php');
require('config/db.php'); 
?>

<?php

session_start();

#if form submitted, insert values into the database.
if (isset($_POST['user_id'])) {
    #removes backslashes
    #escapes special characters in a string
    $user_id = stripslashes($_REQUEST['user_id']);
    $user_id = mysqli_real_escape_string($con, $user_id);

    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);

    #Checking if user exists in the database or not
    $query = "SELECT * FROM `users` WHERE user_id='$user_id' and password='" . md5($password) . "'";

    #execute query & validate 
    $result = mysqli_query($con, $query) or die(mysqli_error($con));

    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        #if success - store user_id in $_SESSION variable
        $_SESSION['user_id'] = $user_id;
        #redirect user to index.php
        header("Location: index.php");
    } else {
        #if failure
        echo "<div class='form'><h3>user_id/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
    }
}
?>

<div class="form container text-center">
    <h1>Used Cars Portal</h1>
    <h2>Log In</h2>
    <br>
    <!-- FORM -->
    <form action="" method="post" name="login">
        <input type="number" name="user_id" placeholder="User ID" required />
        <input type="password" name="password" placeholder="Password" required />
        <input name="submit" type="submit" value="Login" />
    </form>
    <br>
    <p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>

<!-- Footer -->
<?php include "templates/footer.php" ?>
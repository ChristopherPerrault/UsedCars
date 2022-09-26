<!-- Header -->
<?php
include('templates/header-logged-out.php');
?>

<?php
#initialize session data (first time)
session_start();

#check if form submitted
if (isset($_POST['user_id'])) {
    #store form inputs in variables
    #removes backslashes & escapes special characters in a string
    $user_id = stripslashes($_REQUEST['user_id']);
    $user_id = mysqli_real_escape_string($con, $user_id);

    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);

    #query -> check if user exists
    $query = "SELECT * FROM `users` WHERE user_id='$user_id' and password='" . md5($password) . "'";

    #execute query  
    $result = mysqli_query($con, $query) or die(mysqli_error($con));

    #store user info
    $row = mysqli_fetch_assoc($result);
    $num_row = mysqli_num_rows($result);

    #check if admin, user or failure
    if ($num_row == 1){
        if ($row['usertype'] == 'admin') {

            #store user_id and redirect
            $_SESSION['user_id'] = $user_id;
            header("Location: admin.php");
        } else if ($row['usertype'] == 'user') {
    
            #store user_id and redirect
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
        }
    } else {
        #if failure
        echo "<script type='text/javascript'>alert('user_id or password is incorrect!')</script>";
    }
    
}

?>

<div class="form container text-center">
    <h1>Used Cars Portal</h1>
    <h2>Log In</h2>
    <br>
    <!-- FORM -->
    <form action="" method="post" name="login">
        <!-- User Inputs -->
        <input type="number" name="user_id" placeholder="User ID" required />
        <input type="password" name="password" placeholder="Password" required />
        
        <input name="submit" type="submit" value="Login" />
    </form>
    <br>
    <p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>

<!-- Footer -->
<?php include "templates/footer.php" ?>
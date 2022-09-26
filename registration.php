<!-- Header -->
<?php 
include('templates/header-logged-out.php');
?>

<?php
#check if form submitted
if (isset($_REQUEST['user_id'])) {
    #store form inputs in variables
    #removes backslashes & escapes special characters in a string
    $user_id = stripslashes($_REQUEST['user_id']);
    $user_id = mysqli_real_escape_string($con, $user_id);

    $first_name = stripslashes($_REQUEST['first_name']);
    $first_name = mysqli_real_escape_string($con, $first_name);

    $last_name = stripslashes($_REQUEST['last_name']);
    $last_name = mysqli_real_escape_string($con, $last_name);

    $phone_number = stripslashes($_REQUEST['phone_number']);
    $phone_number = mysqli_real_escape_string($con, $phone_number);

    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($con, $email);

    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);


    #query -> insert in database table
    $query = "INSERT into `users` (user_id, first_name, last_name, phone_number, email, password) VALUES ('" . $user_id . "', '" . $first_name . "', '" . $last_name . "', '" . $phone_number . "', '" . $email . "', '" . md5($password) . "')";

    #execute query 
    $result = mysqli_query($con, $query);
    if ($result) {
        #if success
        echo "<script type='text/javascript'>alert('You have registered successfully!')</script>";
    }
}
?>

<div class="form container text-center">
    <h1>Registration</h1>
    <br>
    <!-- Form -->
    <form name="registration" action="" method="post">
        <!-- User Inputs -->
        <input type="number" name="user_id" placeholder="User ID" required /><br><br>
        <input type="text" name="first_name" placeholder="First Name" required /><br><br>
        <input type="text" name="last_name" placeholder="Last Name" required /><br><br>
        <input type="number" name="phone_number" placeholder="Phone Number" required /><br><br>
        <input type="email" name="email" placeholder="Email" required /><br><br>
        <input type="password" name="password" placeholder="Password" required /><br><br><br><br>

        <input type="submit" name="submit" value="Register" />
    </form>

</div>

<!-- Footer -->
<?php include "templates/footer.php" ?>
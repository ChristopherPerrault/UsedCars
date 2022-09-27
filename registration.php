<!-- Header -->
<?php 
include('templates/header-logged-out.php');
?>

<?php
$usernameErr = $fnameErr = $lnameErr = $phoneErr = $emailErr = $passwordErr = "";
$username = $fname = $lname = $phone = $email = $password = "";

$success = "";

// ------------------ TEST INPUT FUNCTION ------------------
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// ------------------ FORM VALIDATION ------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if(empty($_POST['username'])) {
        $usernameErr = "Username is required.";

   } else {
        $username = test_input($_POST['username']);
        $usernameErr = "";

        if(!preg_match("/^[a-zA-Z0-9]{5,20}$/", $username)) {
            $usernameErr = "Must be a minimum of 5 characters with only numbers and letters.";
        }
   }

   if(empty($_POST['fname'])) {
        $fnameErr = "First Name is required.";

   } else {
        $fnameErr = "";
        $fname = test_input($_POST['fname']);

        if(!preg_match("/^[A-Z]{3,50}$/", $fname)) {
            $fnameErr = "Only Captial letters and white spaces allowed.";
        }
   }

   if(empty($_POST['lname'])) {
        $lnameErr = "Last Name is required.";

   } else {
        $lnameErr = "";
        $lname = test_input($_POST['lname']);

        if(!preg_match("/^[A-Z -]{3,50}$/", $lname)) {
            $lnameErr = "Only Captial letters, white spaces and dashes allowed.";
        }
   }

   if(empty($_POST['phone'])) {
        $phoneErr = "Phone Number is Required.";

   } else {
        $phoneErr = "";
        $phone = test_input($_POST['phone']);
        
        if(!preg_match("/^[0-9]{10,}$/", $phone)) {
            $phoneErr = "Minimum of 10 digits required.";
        }
   }

   if(empty($_POST['email'])) {
        $emailErr = "Email is required.";

   } else {
        $emailErr = "";
        $email = test_input($_POST['email']);

        if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
            $emailErr = "Invalid email format.";
        }
   } 

   if(empty($_POST['password'])) {
        $passwordErr = "Password is required.";

   } else {
        $passwordErr = "";
        $password = test_input($_POST['password']);

        if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,100}$/", $password)) {
            $passwordErr = "Password must be at least 8 chars and include at least one special character, one uppercase letter and one digit.";
        }
   }

   // ------------------ SENDING TO DATABASE ------------------
   if(empty($usernameErr) &&
      empty($fnameErr) && 
      empty($lnameErr) && 
      empty($phoneErr) &&
      empty($emailErr) && 
      empty($passwordErr)) {
        
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        strtoupper($fname);
        $lname = $_POST['lname'];
        strtoupper($lname);
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if($username == "admin") {
            $usertype = "admin";

        } else {
            $usertype = "user";

        }

        $query = "INSERT into `users` (username, first_name, last_name, phone_number, email, password, usertype) VALUES ('" . $username . "', '" . $fname . "', '" . $lname . "', '" . $phone . "', '" . $email . "', '" . md5($password) . "', '" . $usertype . "')";

        #execute query 
        $result = mysqli_query($con, $query);
        if ($result) {
            #if success
            $success = "You have registered successfully! <a href='login.php'> Log In here!</a>";
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UsedCars | Register</title>
</head>

<div class="form container text-center">
    <h1>Registration</h1>
    <br>
    <!-- Form -->
    <form name="registration" action="" method="post">
        <!-- User Inputs -->
        <input type="text" name="username" placeholder="Username" /><br>
        <span class="error"><?php echo $usernameErr ?></span><br><br>
        <input type="text" name="fname" placeholder="First Name"  /><br>
        <span class="error"><?php echo $fnameErr ?></span><br><br>
        <input type="text" name="lname" placeholder="Last Name"  /><br>
        <span class="error"><?php echo $lnameErr ?></span><br><br>
        <input type="text" name="phone" placeholder="Phone Number"  /><br>
        <span class="error"><?php echo $phoneErr ?></span><br><br>
        <input type="text" name="email" placeholder="Email"  /><br>
        <span class="error"><?php echo $emailErr ?></span><br><br>
        <input type="password" name="password" placeholder="Password"  /><br>
        <span class="error"><?php echo $passwordErr ?></span><br><br>

        <input type="submit" name="submit" value="Register" />
    </form>
    <p><?php echo $success ?></p> 

</div>

<!-- Footer -->
<?php include "templates/footer.php" ?>

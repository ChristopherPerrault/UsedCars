<!-- Header -->
<?php
require('config/db.php');
require('config/auth.php');
include('templates/header-logged-in.php');
?>


<?php
#check if user_id is set and store in variable
if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    #query -> check if user exists
    $query = "SELECT * FROM `users` WHERE user_id = '" . $user_id . "'";

    #execute query
    $result = mysqli_query($con, $query) or die(mysqli_error($con));

    #store user first name
    while ($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['first_name'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UsedCars | Dashboard</title>
</head>

<!-- Body -->
<div class="container mt-5">
    <!-- Echo User First Name -->
    <h1 class="text-center"> Welcome <?php echo $first_name ?>!</h1>

    <p class="text-center">
        This is your home page -- You can chillout here
    </p>

    <p class="text-center">Check out all these cool listings below</p>
    <hr>
</div>



<!-- Footer -->
<?php include "templates/footer.php" ?>

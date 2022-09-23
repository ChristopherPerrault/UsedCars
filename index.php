<!-- Header -->
<?php 
include ('templates/header-logged-in.php');
require('config/db.php');
include ('config/auth.php'); 
?>

 
<?php 
if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    #Checking if user exists in the database or not
    $query = "SELECT * FROM `users` WHERE user_id = '" . $user_id . "'";

    #execute query & validate 
    $result = mysqli_query($con, $query) or die(mysqli_error($con));

    while($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['first_name'];   
    }
                 
}

?>

<!-- body -->
<div class="container mt-5">
    <h1 class="text-center"> Welcome <?php echo $first_name ?>!</h1>
        <p class="text-center">
            This is your home page -- You can chillout here
        </p>
        <p class="text-center">Check out all these cool listings below</p><hr>
</div>


 
<!-- Footer -->
<?php include "templates/footer.php" ?>
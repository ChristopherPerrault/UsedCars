<?php
require('config/db.php');
include('config/auth.php');
include('templates/header-logged-in.php');
?>

<?php
// check if user_id is set and store in variable
if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    // query -> check if user exists
    $query = "SELECT * FROM `users` WHERE user_id = '" . $user_id . "'";

    // execute query
    $result = mysqli_query($con, $query) or die(mysqli_error($con));

    $rows = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UsedCars | My Account</title>
</head>

<!-- Body -->
<div class="container mt-5">
    <!-- Echo User First Name -->
    <h1 class="text-center"> Account Information</h1>

    <p class="text-center">
        Here is your account information.
    </p>

    <p class="text-center">You can edit or delete your account here.</p>
    <hr>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="form">
        <label for="name">Username: </label>
        <input type="text" name="name" value="<?php echo $rows['username'] ?>" /><br />
        <label for="name">First Name: </label>
        <input type="text" name="name" value="<?php echo $rows['first_name'] ?>" /><br />
        <label for="name">Last Name: </label>
        <input type="text" name="name" value="<?php echo $rows['last_name'] ?>" /><br />
        <label for="name">Phone Number: </label>
        <input type="text" name="name" value="<?php echo $rows['phone_number'] ?>" /><br />
        <label for="phone">Email: </label>
        <input type="text" name="phone" value="<?php echo $rows['email'] ?>" /><br />
        <label for="email">Password: </label>
        <input type="text" name="email" value="<?php echo $rows['password']; ?>" /><br /><br />
        <a href="index-logged-in.php"><input type="button" class="bottom-btn back" value="Go Back"></a>
    </form>
</div>
<?php
include('./templates/footer.php');
?>
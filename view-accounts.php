<?php
require('config/db.php');
include('config/auth.php');
include('templates/header-logged-in.php');
?>

<?php
// query -> check if user exists
$query = "SELECT * FROM `users` WHERE usertype = 'user';";

// execute query
$accounts = mysqli_query($con, $query) or die(mysqli_error($con));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UsedCars | All Accounts</title>
</head>
<!-- Body -->
<div class="container mt-5">
    <!-- Echo User First Name -->
    <h1 class="text-center"> Active User Accounts</h1>

    <p class="text-center">
        As a part of our administration, you have access to all user accounts.
    </p>

    <p class="text-center">You can view or delete any account.</p>
    <hr>
    <table class="listings">
        <thead>
            <tr>
                <th><strong>User ID</strong></th>
                <th><strong>Username</strong></th>
                <th><strong>First Name</strong></th>
                <th><strong>Last Name</strong></th>
                <th><strong>Phone Number</strong></th>
                <th><strong>Email</strong></th>
                <th><strong>User Type</strong></th>
                <th id="empty"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($rows = mysqli_fetch_assoc($accounts)) {
            ?>
                <tr>
                    <td align="center"><?php echo $rows['user_id']; ?></td>
                    <td align="center"><?php echo $rows['username']; ?></td>
                    <td align="center"><?php echo $rows['first_name']; ?></td>
                    <td align="center"><?php echo $rows['last_name']; ?></td>
                    <td align="center"><?php echo $rows['phone_number']; ?></td>
                    <td align="center"><?php echo $rows['email']; ?></td>
                    <td align="center"><?php echo $rows['usertype']; ?></td>
                    <td align="center">
                        <button id="delete-car"><a href="delete-user.php?user_id=<?php echo $rows['user_id']; ?>">Delete</a></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Footer -->

<?php include "templates/footer.php" ?>
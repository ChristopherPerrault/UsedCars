<!-- Header -->
<?php
require('config/db.php');
include('config/auth.php');
include('templates/header-logged-in.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UsedCars | Homepage</title>
</head>

<!-- Body -->
<div class="container mt-5">
    <!-- Echo User First Name -->
    <h1 class="text-center"> Active Car Listings</h1>

    <p class="text-center">
        You can purchase/view any of these active listings.
    </p>

    <p class="text-center"><a href="userdashboard.php">Check your active listings here!</a></p>
    <hr>
    <?php
        $user_id = $_SESSION['user_id'];

        $no_cars = "";

        $view_cars = "SELECT * FROM `cars` WHERE `user_id`!= '$user_id';";

        $listings = mysqli_query($con, $view_cars);

        $count = mysqli_num_rows($listings);

        if($count == 0) {
            $no_cars = "<p style='text-align:center;font-size:15pt;'> It looks like we do not have any active listings at the moment!</p>";
            echo $no_cars;
        } else {
        ?>
    <table class="listings">
        <thead>
            <tr>
                <th><strong>Make</strong></th>
                <th><strong>Model</strong></th>
                <th><strong>Year</strong></th>
                <th><strong>Mileage</strong></th>
                <th><strong>Color</strong></th>
                <th><strong>Condition</strong></th>
                <th><strong>Asking Price</strong></th>
                <th><strong>Date Posted</strong></th>
                <th id="empty"></th>
            </tr>
        </thead>
        <tbody>
            <?php
             while($rows = mysqli_fetch_assoc($listings)) {
            ?>
            <tr>
                <td align="center"><?php echo $rows['make']; ?></td>
                <td align="center"><?php echo $rows['model']; ?></td>
                <td align="center"><?php echo $rows['year']; ?></td>
                <td align="center"><?php echo $rows['mileage'] . " km"; ?></td>
                <td align="center"><?php echo $rows['color']; ?></td>
                <td align="center"><?php echo $rows['car_condition']; ?></td>
                <td align="center"><?php echo "$".$rows['asking_price']; ?></td>
                <td align="center"><?php echo $rows['date_posted']; ?></td>
                <td align="center">
                    <button id="contact"><a href="contact.php?user_id=<?php echo $rows['user_id']; ?>">Contact Seller</a></button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</div>



<!-- Footer -->
<?php include "templates/footer.php" ?>

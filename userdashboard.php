<!-- Header -->
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

    // store user first name
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
    <h1 class="text-center"> Welcome, <?php echo $first_name ?>!</h1>

    <p class="text-center">
        This is your home page.
    </p>

    <p class="text-center">Check out all of your listings below:</p>


    <?php
    $add_car = "";

    $user_id = $_SESSION['user_id'];
    $view_cars = "SELECT * FROM `cars` WHERE `user_id`='$user_id'";

    $listings = mysqli_query($con, $view_cars);

    $count = mysqli_num_rows($listings);

    if ($count == 0) {
        $add_car = "<p style='text-align:center;font-size:15pt;'> It looks like you do not have any active listings. <a href='addCar.php'>Add a car listing here!</a></p>";
        echo $add_car;
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
                while ($rows = mysqli_fetch_assoc($listings)) {
                ?>
            <tr>
                <td align="center"><?php echo $rows['make']; ?></td>
                <td align="center"><?php echo $rows['model']; ?></td>
                <td align="center"><?php echo $rows['year']; ?></td>
                <td align="center"><?php echo $rows['mileage'] . " km"; ?></td>
                <td align="center"><?php echo $rows['color']; ?></td>
                <td align="center"><?php echo $rows['car_condition']; ?></td>
                <td align="center"><?php echo "$" . $rows['asking_price']; ?></td>
                <td align="center"><?php echo $rows['date_posted']; ?></td>
                <td align="center">
                    <button id="edit-car"><a href="edit-car.php?car_id=<?php echo $rows['car_id']; ?>">Edit</a></button>
                    <button id="delete-car"><a
                            href="delete-car.php?car_id=<?php echo $rows['car_id']; ?>">Delete</a></button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</div>



<!-- Footer -->
<?php include "templates/footer.php" ?>
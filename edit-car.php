<!-- Header -->
<?php
require('config/db.php');
include('config/auth.php');
include('templates/header-logged-in.php');

$car_id = $_REQUEST['car_id'];

$query = "SELECT * FROM `cars` WHERE `car_id`='$car_id'";

$result = mysqli_query($con, $query);

$rows = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UsedCars | Dashboard</title>
</head>

<body>
    <h2 align="center" style="padding:10px;">Update Your Car Listing</h2>
    <div class="container">
        <?php
        $status = "";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $make = $_POST['make'];
            $model = $_POST['model'];
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];
            $color = $_POST['color'];
            $condition = $_POST['condition'];
            $price = $_POST['price'];
            $posted_date = date("Y-m-d");

            $update = "UPDATE `cars` set make= '" . $make . "', model= '" . $model . "', year= '" . $year . "', mileage= '" . $mileage . "', 
            color= '" . $color . "', car_condition= '" . $condition . "', asking_price= '" . $price . "', date_posted= '" . $posted_date . "' WHERE car_id='". $car_id . "';";

            $result2 = mysqli_query($con, $update);

            if ($result2) {
                $status = "<p style='font-size:15pt; text-align:center;'>You have successfully updated your listing. <a href='userdashboard.php'>View updated listing here!</a></p>";
                echo $status;
            } else {
                $status = "<p style='font-size:15pt text-align:center;'>Update unsuccessful. Please try again.</p>";
                echo $status;
            }

        } else {
        ?>
        <form name="form" method="post" action="">
            <input type="hidden" name="new" value="1" />

            <label for="">Make:</label>
            <input type="text" name="make" required value="<?php echo $rows['make']; ?>" />
            <span class="error"><?php  ?></span>
            <br>
            <label for="">Model:</label>
            <input type="text" name="model" required value="<?php echo $rows['model']; ?>" />
            <span class="error"><?php  ?></span>
            <br>
            <label for="">Year:</label>
            <input type="text" name="year" required value="<?php echo $rows['year']; ?>" />
            <span class="error"><?php  ?></span>
            <br>
            <label for="">Mileage:</label>
            <input type="text" name="mileage" required value="<?php echo $rows['mileage']; ?>" />
            <span class="error"><?php  ?></span>
            <br>
            <label for="">Color:</label>
            <input type="text" name="color" required value="<?php echo $rows['color']; ?>" />
            <span class="error"><?php  ?></span>
            <br>
            <label for="">Condition:</label>
            <select name="condition">
                <optgroup label="--Select Condition--">
                    <option value="<?php echo $rows['car_condition'] ?>" hidden><?php echo $rows['car_condition'] ?></option>
                    <option value="Like New">Like New</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                    <option value="Poor">Poor</option>
                    <option value="Very Poor">Very Poor</option>
                </optgroup>
            </select>
            <br>
            <label for="">Asking Price</label>
            <input type="text" name="price" required value="<?php echo $rows['asking_price']; ?>" />
            <span class="error"><?php  ?></span>
            <br>

            <input name="submit" type="submit" value="Update" />
            <a href="userdashboard.php"><input type="button" value="Go Back" class="bottom-btn back"></a>
            <br />
        </form>
        <?php } ?>
    </div>
</body>

</html>

<!-- Footer -->
<?php include "templates/footer.php" ?>
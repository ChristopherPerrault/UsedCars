<!-- Header -->
<?php
require('config/db.php');
require('config/auth.php');
include('templates/header-logged-in.php');
?>


<div class="container mt-5">
    <h1 class="text-center">Search Database</h1><br>
    <p class="text-center">
        Choose the information you want to fetch from the database!
    </p>
    <p class="text-center">
        You can even save it to a text file!
    </p>
    <hr>
    <!-- </div> -->
    <!-- <div class="container mt-5"> -->
    <form id="databaseForm" action="" method="post">
        <div class="form-group">
            <label for="selectedUser" class="form-label">Select a User: </label>
            <select name="selectedUser">
                <?php
        $user_id = $_SESSION['user_id'];
        $view_usernames = "SELECT * FROM `users`";
        $allUsers = mysqli_query($con, $view_usernames);

        while ($rows = mysqli_fetch_assoc($allUsers)) {
        ?>
                <option value="<?php echo $rows['username']; ?>" selected><?php echo $rows['username']; ?></option>
                <?php }
        ?>
            </select>
            <br><br>
            <h4>Info to include from the User</h4>
            <input type="checkbox" name="first_name" value="first_name">
            <label for="first_name"> First Name</label>
            <input type="checkbox" name="last_name" value="last_name">
            <label for="last_name"> Last Name</label>
            <input type="checkbox" name="phone_number" value="phone_number">
            <label for="phone_number"> Phone Number</label>
            <input type="checkbox" name="email" value="email">
            <label for="email"> Email</label>
            <br><br>
            <h4>Info to include from the Cars they have Listed</h4>
            <input type="checkbox" name="make" value="make">
            <label for="make"> Make</label>
            <input type="checkbox" name="model" value="model">
            <label for="model"> Model</label>
            <input type="checkbox" name="year" value="year">
            <label for="year"> Year</label>
            <input type="checkbox" name="color" value="color">
            <label for="color"> Color</label>
            <input type="checkbox" name="car_condition" value="car_condition">
            <label for="car_condition"> Car Condition</label>
            <input type="checkbox" name="asking_price" value="asking_price">
            <label for="asking_price"> Asking Price</label>
            <input type="checkbox" name="date_posted" value="date_posted">
            <label for="date_posted"> Date Posted</label>
            <br><br>
        </div>
        <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $chosenUsername = $_POST['selectedUser'];
      $requestedData = "SELECT * FROM `users` WHERE username = '" . $chosenUsername . "'";
      $finalResult = mysqli_query($con, $requestedData);
      $chosenUser_id = $no_car = "";

      while ($userInfo = mysqli_fetch_assoc($finalResult)) {
        $chosenUser_id = $userInfo['user_id'];
        if (isset($_POST['first_name']) || isset($_POST['last_name']) || isset($_POST['phone_number']) || isset($_POST['email'])) {
    ?>
        <h5><?php echo "Here are the personal details for $chosenUsername" ?></h5>
        <table class="listings">
            <thead>
                <tr>
                    <th><strong>First Name</strong></th>
                    <th><strong>Last Name</strong></th>
                    <th><strong>Phone Number</strong></th>
                    <th><strong>Email</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center"><?php if (isset($_POST['first_name'])) {
                                      echo $userInfo['first_name'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['last_name'])) {
                                      echo $userInfo['last_name'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['phone_number'])) {
                                      echo $userInfo['phone_number'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['email'])) {
                                      echo $userInfo['email'];
                                    } ?></td>
                </tr>
            </tbody>
        </table>
        <?php
        } else {
        ?>
        <b><i>You didn't select any user information to display!</p> </i></b>
        <p>
            <?php
        }
      }
      $requestedData = "SELECT * FROM `cars` WHERE user_id = '" . $chosenUser_id . "'";
      $finalResult2 = mysqli_query($con, $requestedData);

      $car_number = 1;
      while ($carInfo = mysqli_fetch_assoc($finalResult2)) {
        if (isset($_POST['make']) || isset($_POST['model']) || isset($_POST['year']) || isset($_POST['color']) || isset($_POST['car_condition']) || isset($_POST['asking_price']) || isset($_POST['date_posted'])) {
          ?>
        <h5><?php echo "Here are the details for car $car_number:" ?></h5>
        <table class="listings">
            <thead>
                <tr>
                    <th><strong>Make</strong></th>
                    <th><strong>Model</strong></th>
                    <th><strong>Year</strong></th>
                    <th><strong>Color</strong></th>
                    <th><strong>Car Condition</strong></th>
                    <th><strong>Asking Price</strong></th>
                    <th><strong>Date Posted</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center"><?php if (isset($_POST['make'])) {
                                      echo $carInfo['make'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['model'])) {
                                      echo $carInfo['model'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['year'])) {
                                      echo $carInfo['year'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['color'])) {
                                      echo $carInfo['color'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['car_condition'])) {
                                      echo $carInfo['car_condition'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['asking_price'])) {
                                      echo $carInfo['asking_price'];
                                    } ?></td>
                    <td align="center"><?php if (isset($_POST['date_posted'])) {
                                      echo $carInfo['date_posted'];
                                    } ?></td>
                </tr>
            </tbody>
        </table>
        <?php
        } else {
          $no_car = "<b><i>You didn't select any car information to display!</i></b>";
        }

        $car_number++;
      }
      echo $no_car;
    }
    ?>

        <div class="form-group">
            <input id="generate-report" type="submit" name="submit" value="View Info">
        </div>
    </form>
</div>



<!-- Footer -->
<?php include "templates/footer.php" ?>
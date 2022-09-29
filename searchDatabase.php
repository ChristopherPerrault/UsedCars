<!-- Header -->
<?php
require('config/db.php');
require('config/auth.php');
include('templates/header-logged-in.php');
?>


<div class="container mt-5">
<h1 class="text-center">Search Database</h1>
  <form action="" method="post">
    <div class="form-group">
      <label for="selectedUser" class="form-label">Select a User: </label>
      <select name="selectedUser">
        <?php
        $user_id = $_SESSION['user_id'];
        $view_usernames = "SELECT * FROM `users`";
        $allUsers = mysqli_query($con, $view_usernames);
        #$count = mysqli_num_rows($allUsers);


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
      echo "<h5><b>$chosenUsername</b></h5><hr>";
      $requestedData = "SELECT * FROM `users` WHERE username = '" . $chosenUsername . "'";
      $finalResult = mysqli_query($con, $requestedData);
      $chosenUser_id = "";
      while ($userInfo = mysqli_fetch_assoc($finalResult)) {
        echo "Here are the personal details for <b>$chosenUsername</b> <br>";
        if (isset($_POST['first_name'])) {
          echo "FIRST NAME: " . $userInfo['first_name'] . " - ";
        }
        if (isset($_POST['last_name'])) {
          echo "LAST NAME: " . $userInfo['last_name'] . " - ";
        }
        if (isset($_POST['phone_number'])) {
          echo "PHONE NUMBER: " . $userInfo['phone_number'] . " - ";
        }
        if (isset($_POST['email'])) {
          echo "EMAIL: " . $userInfo['email'];
        }

        $chosenUser_id = $userInfo['user_id'];
      }

      echo "<br><hr>";
      $requestedData = "SELECT * FROM `cars` WHERE user_id = '" . $chosenUser_id . "'";
      $finalResult2 = mysqli_query($con, $requestedData);
      $count = mysqli_num_rows($finalResult2);
      $car_number = 1;
      echo "There is/are $count car(s) for <b>$chosenUsername</b> <br>";
      while ($carInfo = mysqli_fetch_assoc($finalResult2)) {
        echo "Here are the details for car $car_number: ";
        if (isset($_POST['make'])) {
          echo "MAKE: " . $carInfo['make'] . " - ";
        }
        if (isset($_POST['model'])) {
          echo "MODEL: " . $carInfo['model'] . " - ";
        }
        if (isset($_POST['year'])) {
          echo "YEAR: " . $carInfo['year'] . " - ";
        }
        if (isset($_POST['color'])) {
          echo "COLOR: " . $carInfo['color'] . " - ";
        }
        if (isset($_POST['car_condition'])) {
          echo "CAR CONDITON: " . $carInfo['car_condition'] . " - ";
        }
        if (isset($_POST['asking_price'])) {
          echo "ASKING PRICE: " . $carInfo['asking_price'] . " - ";
        }
        if (isset($_POST['date_posted'])) {
          echo "DATE POSTED: " . $carInfo['date_posted'];
        }
        echo "<br>";
        $car_number++;
      }
      
    }
    ?>

    <div class="form-group">
      <input type="submit" name="submit" class="btn btn-primary mt-2" value="Generate Report">
    </div>
  </form>
</div>


<!-- a BACK button to go to the home page -->
<div class="container text-center mt-5">
  <a href="home.php" class="btn btn-warning mt-5"> Back </a>
</div>



<!-- Footer -->
<?php include "templates/footer.php" ?>